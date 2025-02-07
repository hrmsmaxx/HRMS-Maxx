<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Base class for preferences.
 *
 * @package PhpMyAdmin
 */
declare(strict_types=1);

namespace PhpMyAdmin\Config\Forms;

use PhpMyAdmin\Config\ConfigFile;
use PhpMyAdmin\Config\FormDisplay;

/**
 * Base form for user preferences
 *
 * @package PhpMyAdmin
 */
abstract class BaseForm extends FormDisplay
{
    /**
     * Constructor
     *
     * @param ConfigFile $cf       Config file instance
     * @param int|null   $serverId 0 if new server, validation; >= 1 if editing a server
     */
    public function __construct(ConfigFile $cf, $serverId = null)
    {
        parent::__construct($cf);
        foreach (static::getForms() as $formName => $form) {
            $this->registerForm($formName, $form, $serverId);
        }
    }

    /**
     * List of available forms, each form is described as an array of fields to display.
     * Fields MUST have their counterparts in the $cfg array.
     *
     * To define form field, use the notation below:
     * $forms['Form group']['Form name'] = array('Option/path');
     *
     * You can assign default values set by special button ("set value: ..."), eg.:
     * 'Servers/1/pmadb' => 'phpmyadmin'
     *
     * To group options, use:
     * ':group:' . __('group name') // just define a group
     * or
     * 'option' => ':group' // group starting from this option
     * End group blocks with:
     * ':group:end'
     *
     * @todo This should be abstract, but that does not work in PHP 5
     *
     * @return array
     */
    public static function getForms()
    {
        return [];
    }

    /**
     * Returns list of fields used in the form.
     *
     * @return string[]
     */
    public static function getFields()
    {
        $names = [];
        foreach (static::getForms() as $form) {
            foreach ($form as $k => $v) {
                $names[] = is_int($k) ? $v : $k;
            }
        }
        return $names;
    }

    /**
     * Returns name of the form
     *
     * @todo This should be abstract, but that does not work in PHP 5
     *
     * @return string
     */
    public static function getName()
    {
        return '';
    }
}
