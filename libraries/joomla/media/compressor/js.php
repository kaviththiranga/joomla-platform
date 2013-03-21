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
 * Javascript Compressor Class.
 *
 * @package     Joomla.Platform  
 * @subpackage  Media
 * 
 * @since       12.1
 */
abstract class JMediaCompressorJs extends JMediaCompressorGeneric
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
     * Gives a compressor object for Js
     *
     * @param   array  $options  options for the compressor
     *
     * @return  JMediaCompressorJs  Returns a JMediaCompressorJs object
     *
     * @throws  RuntimeException
     *
     * @since   12.1
     */
    public static function getInstance( $options = array())
    {

    }
}
