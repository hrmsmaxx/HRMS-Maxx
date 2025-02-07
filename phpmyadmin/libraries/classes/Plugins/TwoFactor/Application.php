<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Second authentication factor handling
 *
 * @package PhpMyAdmin
 */
declare(strict_types=1);

namespace PhpMyAdmin\Plugins\TwoFactor;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use PhpMyAdmin\Plugins\TwoFactorPlugin;
use PhpMyAdmin\TwoFactor;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FAQRCode\Google2FA;

/**
 * HOTP and TOTP based two-factor authentication
 *
 * Also known as Google, Authy, or OTP
 *
 * @package PhpMyAdmin
 */
class Application extends TwoFactorPlugin
{
    /**
     * @var string
     */
    public static $id = 'application';

    protected $_google2fa;

    /**
     * Creates object
     *
     * @param TwoFactor $twofactor TwoFactor instance
     */
    public function __construct(TwoFactor $twofactor)
    {
        parent::__construct($twofactor);
        if (extension_loaded('imagick')) {
            $this->_google2fa = new Google2FA();
        } else {
            $this->_google2fa = new Google2FA(new SvgImageBackEnd());
        }
        $this->_google2fa->setWindow(8);
        if (! isset($this->_twofactor->config['settings']['secret'])) {
            $this->_twofactor->config['settings']['secret'] = '';
        }
    }

    /**
     * Get any property of this class
     *
     * @param string $property name of the property
     *
     * @return mixed|void if property exist, value of the relevant property
     */
    public function __get($property)
    {
        switch ($property) {
            case 'google2fa':
                return $this->_google2fa;
        }
    }

    /**
     * Checks authentication, returns true on success
     *
     * @return boolean
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function check()
    {
        $this->_provided = false;
        if (! isset($_POST['2fa_code'])) {
            return false;
        }
        $this->_provided = true;
        return $this->_google2fa->verifyKey(
            $this->_twofactor->config['settings']['secret'],
            $_POST['2fa_code']
        );
    }

    /**
     * Renders user interface to enter two-factor authentication
     *
     * @return string HTML code
     */
    public function render()
    {
        return $this->template->render('login/twofactor/application');
    }

    /**
     * Renders user interface to configure two-factor authentication
     *
     * @return string HTML code
     */
    public function setup()
    {
        $secret = $this->_twofactor->config['settings']['secret'];
        $inlineUrl = $this->_google2fa->getQRCodeInline(
            'phpMyAdmin (' . $this->getAppId(false) . ')',
            $this->_twofactor->user,
            $secret
        );
        return $this->template->render('login/twofactor/application_configure', [
            'image' => $inlineUrl,
            'secret' => $secret,
            'has_imagick' => extension_loaded('imagick'),
        ]);
    }

    /**
     * Performs backend configuration
     *
     * @return boolean
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function configure()
    {
        if (! isset($_SESSION['2fa_application_key'])) {
            $_SESSION['2fa_application_key'] = $this->_google2fa->generateSecretKey();
        }
        $this->_twofactor->config['settings']['secret'] = $_SESSION['2fa_application_key'];

        $result = $this->check();
        if ($result) {
            unset($_SESSION['2fa_application_key']);
        }
        return $result;
    }

    /**
     * Get user visible name
     *
     * @return string
     */
    public static function getName()
    {
        return __('Authentication Application (2FA)');
    }

    /**
     * Get user visible description
     *
     * @return string
     */
    public static function getDescription()
    {
        return __('Provides authentication using HOTP and TOTP applications such as FreeOTP, Google Authenticator or Authy.');
    }
}
