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
abstract class JMediaCompressorGeneric implements JMediaCompressor
{
    /**
     * @var    String  To hold uncompressed Code.
     * @since  12.1
     */
    public $uncompressed = null;

    /**
     * @var    int  size of uncompressed Code.
     * @since  12.1
     */
    public $uncompressedSize = null;

    /**
     * @var    String  To hold compressed Code.
     * @since  12.1
     */
    protected  $compressed = null;

    /**
     * @var    int  size of compressed Code.
     * @since  12.1
     */
    public $compressedSize = null;

    /**
     * @var    Array  Compression options for CSS Minifier.
     * @since  12.1
     */
    protected  $options = array();

    /**
     * @var    array  JMediaCompressor instances container.
     * @since  11.1
     */
    protected static $instances = array();

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
	 * Method to compress the code.
	 * 
	 * @return   Void
	 *
	 * @throws  RuntimeException
	 *
	 * @since  12.1 
	 */
	public abstract function compress();

    /**
     * Method to set uncompressed code.
     *
     * @param   string  $uncompressed  Uncompressed Code.
     *
     * @return  void
     *
     * @since  12.1
     */
    public function setUncompressed($uncompressed)
    {
        $this->uncompressed = $uncompressed;
        $this->uncompressedSize	= strlen($this->uncompressed);
    }

    /**
     * Method to get uncompressed code.
     *
     * @return  String  uncompressed code.
     *
     * @since  12.1
     */
    public function getUncompressed()
    {
        return $this->uncompressed;
    }

    /**
     * Method to set compressed code.
     *
     * @param   string  $compressed  compressed Code.
     *
     * @return  void
     *
     * @since  12.1
     */
    public function setCompressed($compressed)
    {
        $this->compressed = $compressed;
        $this->compressedSize	= strlen($this->compressed);
    }

    /**
     * Method to get compressed code.
     *
     * @return  String  compressed code.
     *
     * @since  12.1
     */
    public function getCompressed()
    {
        if ($this->compressed === null && $this->uncompressed != null)
        {
            $this->compress();
        }
        return $this->compressed;
    }

    /**
     * Method to set compression options.
     *
     * @param   Array  $options  options to compress.
     *
     * @return  void
     *
     * @since  12.1
     */
    public function setOptions($options)
    {
        $prevSignature = md5(serialize($this->options));

        // Merge old options with new options
        $this->options = array_merge($this->options, $options);

        $newSignature = md5(serialize($this->options));

        if (strcmp($prevSignature, $newSignature) !== 0)
        {
            // Remove old signature from instance array
            unset(self::$instances[$prevSignature]);

            // Set new instance signature
            if (!array_key_exists($newSignature, self::$instances))
            {
                self::$instances[$newSignature] = $this;
            }
        }
    }

    /**
     * Method to get compressor options
     *
     * @return  array  Options for the compressor
     *
     * @since   12.1
     */
    public function getOptions(){

        return $this->options;
    }

    /**
     * Method to get compressed ratio.
     *
     * @return  double  Compressed ratio.
     *
     * @since  12.1
     */
    public function getRatio()
    {
        return round(($this->compressedSize / $this->uncompressedSize * 100), 2);
    }

}
