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
        // Derive the class name from the type.
        $class = 'JMediaCollection' . ucfirst(strtolower($options['type']));

        if (!class_exists($class))
        {
            throw new RuntimeException(sprintf("Error Loading collection class for %s file type", $options['type']));
        }

        // Create our new JMediaCollection class based on the options given.
        try
        {
            $instance = new $class($options);
        }
        catch (RuntimeException $e)
        {
            throw new RuntimeException(sprintf("Error Loading Collection class for %s file type", $options['type']));
        }

        return $instance;

	}

    /**
     * Method to save combined sources to file
     *
     * @param   String   $destination  file to save
     *
     * @return  boolean  True if saving to file is successful
     *
     * @since   12.1
     */
    public function toFile($destination = null)
    {
        if ($this->combined === null)
        {
            $this->combine();
        }

        if ($destination === null)
        {
            $destination = md5(serialize($this->options) . serialize($this->sources)) . '.' . $this->options['type'];
        }

        if (file_put_contents($destination, $this->combined) === false)
        {
            return false;
        }

        return true;
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
