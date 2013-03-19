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
 * Javascript and CSS Compressor Interface.
 *
 * @package     Joomla.Platform
 * @subpackage  Media
 * @since       12.1
 */
interface JMediaCompressor
{
	/**
	 * Method to compress the code.
	 *
	 * @return   Void
	 *
	 * @since  12.1
	 */
	public function compress();

	/**
	 * Method to set uncompressed code.
	 *
	 * @param   string  $uncompressed  Uncompressed Code.
	 *
	 * @return  void
	 *
	 * @since  12.1
	 */
	public function setUncompressed($uncompressed);

	/**
	 * Method to get uncompressed code.
	 *
	 * @return  String  uncompressed code.
	 *
	 * @since  12.1
	 */
	public function getUncompressed();

	/**
	 * Method to set compressed code.
	 *
	 * @param   string  $compressed  compressed Code.
	 *
	 * @return  void
	 *
	 * @since  12.1
	 */
	public function setCompressed($compressed);

	/**
	 * Method to get compressed code.
	 *
	 * @return  String  compressed code.
	 *
	 * @since  12.1
	 */
	public function getCompressed();

	/**
	 * Method to set compression options.
	 *
	 * @param   Array  $options  options to compress.
	 *
	 * @return  void
	 *
	 * @since  12.1
	 */
	public function setOptions($options);

	/**
	 * Method to get compressed ratio.
	 *
	 * @return  double  Compressed ratio.
	 *
	 * @since  12.1
	 */
	public function getRatio();

	/**
	 * Method to get compressor options
	 * 
	 * @return  array  Options for the compressor
	 * 
	 * @since   12.1
	 */
	public function getOptions();

	/**
	 * Method to clear compressor data
	 * 
	 * @return  void
	 * 
	 * @since  12.1
	 */
	public function clear();
}
