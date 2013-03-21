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
     * constructor
     *
     * @param   Array  $options  Compression options for Minifier.
     *
     * @since  12.1
     */
    public function __construct($options = array())
    {
        parent::__construct($options);
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
        $class = 'JMediaCompressorJs';

        // Select the specific compressor
        if(!empty($options['compressor']))
        {
            $class .= ucfirst(strtolower($options['compressor']));
        }
        else
        {
            $class .= 'Default';
        }

        if (!class_exists($class))
        {
            throw new RuntimeException(sprintf("Error Loading %s compressor", $options['compressor']));
        }

        // Create our new JMediaCompressorCss class based on the options given.
        try
        {
            $instance = new $class($options);
        }
        catch (RuntimeException $e)
        {
            throw new RuntimeException(sprintf("Error Loading %s compressor", $options['compressor']));
        }

        return $instance;
    }
}
