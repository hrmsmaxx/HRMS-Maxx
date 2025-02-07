<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Image JPEG Inline Transformations plugin for phpMyAdmin
 *
 * @package    PhpMyAdmin-Transformations
 * @subpackage Inline
 */
declare(strict_types=1);

namespace PhpMyAdmin\Plugins\Transformations\Output;

use PhpMyAdmin\Plugins\Transformations\Abs\InlineTransformationsPlugin;

/**
 * Handles the inline transformation for image jpeg
 *
 * @package    PhpMyAdmin-Transformations
 * @subpackage Inline
 */
// @codingStandardsIgnoreLine
class Image_JPEG_Inline extends InlineTransformationsPlugin
{
    /**
     * Gets the plugin`s MIME type
     *
     * @return string
     */
    public static function getMIMEType()
    {
        return "Image";
    }

    /**
     * Gets the plugin`s MIME subtype
     *
     * @return string
     */
    public static function getMIMESubtype()
    {
        return "JPEG";
    }
}
