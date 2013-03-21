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
 * SuperClass for Javascript/CSS collection classes.
 *
 * @package     Joomla.Platform
 * @subpackage  Media
 * @since       12.1 
 */
abstract class JMediaCollection
{
    /**
     * @var array  Array of Source files
     *
     * @since   12.1
     */
    public $sources = array();

    /**
     * @var  String   combined string
     *
     * @since   12.1
     */
    protected $combined = null;

    /**
     * @var array  options for the collection
     *
     * @since   12.1
     */
    protected $options = array();

    /**
     * @var    JMediaCompressor   Compressor Object
     *
     * @since  12.1
     */
    protected $compressor = null;

	/**
	 * Constructor
	 * 
	 * @param   Array  $options  options for the collection
	 * 
	 * @since   12.1 
	 */
	public function __construct($options = array())
	{
		// Merge user defined options with default options
		$this->options = array_merge($this->options, $options);
	}

	/**
	 * Method to combine content of a set of files.
	 *
	 * @return  Void
	 *
	 * @since  12.1
	 */
	public abstract function combine();

	/**
	 * Method to set collection options.
	 *
	 * @param   Array  $options  options to collection.
	 *
	 * @return  void
	 *
	 * @since  12.1
	 */
	public function setOptions($options)
    {
		// Merge old options with new options
		$this->options = array_merge($this->options, $options);
	}

    /**
     * Method to set the compressor for the collection
     *
     * @param   JMediaCompressor   Compressor
     *
     * @return  void
     *
     * @since   12.1
     */
    public function setCompressor($compressor)
    {
        $this->compressor = $compressor;
    }

    /**
	 * Method to set source files to combine
	 * 
	 * @param   array  $files  array of source files
	 * 
	 * @throws RuntimeException
	 * 
	 * @return  void
	 * 
	 * @since  12.1
	 */
	public function addFiles($files =array())
	{
		// Get collection object type
		$type = $this->options['type'];

		foreach ($files as $file)
		{
			// Check file ext for compatibility
			if (pathinfo($file, PATHINFO_EXTENSION) == $type)
			{
				if (!file_exists($file))
				{
					throw new RuntimeException(sprintf("%s File does not exist", $file));
				}
				// Check whether file already registered
				if (!in_array($file, $this->sources))
				{
					$this->sources[] = $file;
				}
			}
			else
			{
				throw new RuntimeException(sprintf("Multiple File types detected in files array. %s", $type));
			}

		}
	}

	/**
	 * Static method to get a set of files combined
	 *
	 * @param   array   $files        Set of source files
	 * @param   array   $options      Options for collection
	 * @param   string  $destination  Destination file
	 *
	 * @return  boolean  True on success
	 *
	 * @throws  RuntimeException
	 *
	 * @since 12.1
	 */
	public static function combineFiles($files, $options = array(), $destination = null)
	{
		// Detect file type
		$type = pathinfo($files[0], PATHINFO_EXTENSION);

		if (!self::isSupported($files[0]))
		{
			throw new RuntimeException(sprintf("Error Loading Collection class for %s file type", $type));
		}

		// Checks for the destination
		if ($destination === null)
		{
			$type = $extension = pathinfo($files[0], PATHINFO_EXTENSION);

			// Check for the file prefix in options, assign default prefix if not found
			if (array_key_exists('PREFIX', $options) && !empty($options['PREFIX']))
			{
				$destination = str_ireplace('.' . $type, '.' . $options['PREFIX'] . '.' . $type, $files[0]);
			}
			else
			{
				$destination = str_ireplace('.' . $type, '.combined.' . $type, $files[0]);
			}
		}

		$options['type'] = (!empty($options['type'])) ? $options['type'] : $type;

		$combiner = self::getInstance($options);

		$combiner->addFiles($files);

		$combiner->combine();

		if (!empty($combiner->combined))
		{
			$force = array_key_exists('OVERWRITE', $options) && !empty($options['OVERWRITE']) ? $options['OVERWRITE'] : false;

			if (!file_exists($destination) || (file_exists($destination) && $force))
			{
				file_put_contents($destination, $combiner->getCombined());

				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	/**
	 * Method to get source files
	 * 
	 * @return  array  Source File
	 * 
	 * @since   12.1
	 */
	public function getFiles()
	{
		return $this->sources;
	}

	/**
	 * Method to get combined string
	 * 
	 * @return  String  Combined String
	 */
	public function getCombined()
	{
		if ($this->combined == null)
		{
			$this->combine();
		}
		return  $this->combined;
	}

	/**
	 * Method to get options
	 *
	 * @return  array  Options for the collection object
	 *
	 * @since   12.1
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * Gives a collection object for CSS/JS
	 *
	 * @param   array  $options  options for the compressor
	 *
	 * @return  JMediaCollection  Returns a JMediaCollection object
	 *
	 * @throws  RuntimeException
	 *
	 * @since   12.1
	 */
	public static function getInstance( $options = array())
	{

	}

	/**
	 * Method to test if supported
	 *
	 * @param   string  $sourceFile  file to test
	 *
	 * @return  boolean   true or false
	 *
	 * @since  12.1
	 */
	public static function isSupported($sourceFile)
	{

	}

	/**
	 * Method to clear collection data
	 *
	 * @return  void
	 *
	 * @since  12.1
	 */
	public function clear()
	{
		$this->sources = array();
		$this->combined = null;
	}
}
