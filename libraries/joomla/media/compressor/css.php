<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Media
 * 
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * CSS Compressor Class.
 *
 * @package     Joomla.Platform
 * @subpackage  Media
 * @since       12.1 
 */
abstract class JMediaCompressorCss extends JMediaCompressorGeneric
{
    /**
     * Object Constructor takes two parameters.
     *
     * @param   Array  $options  Compression options for Minifier.
     *
     * @since  12.1
     */
    public function __construct($options = array())
    {
        // Merge user defined options with default options
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Gives a compressor object for CSS
     *
     * @param   array  $options  options for the compressor
     *
     * @return  JMediaCompressorCss  Returns a JMediaCompressorCss object
     *
     * @throws  RuntimeException
     *
     * @since   12.1
     */
    public static function getInstance( $options = array())
    {

    }
}
