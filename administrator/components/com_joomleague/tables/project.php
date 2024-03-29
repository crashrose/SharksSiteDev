<?php
/**
 * @copyright	Copyright (C) 2006-2013 joomleague.at. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include library dependencies
jimport( 'joomla.filter.input' );

/**
* Project Table class
*
* @package		Joomleague
* @since 1.5
*/
class TableProject extends JLTable
{	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db)
	{
		parent::__construct( '#__joomleague_project', 'id', $db );
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind( $array, $ignore = '' )
	{
		if ( key_exists( 'params', $array ) && is_array( $array['params'] ) )
		{
			$registry = new JRegistry();
			$registry->loadArray( $array['params'] );
			$array['params'] = $registry->toString();
		}
		if ( key_exists( 'comp_params', $array ) && is_array( $array['comp_params'] ) )
		{
			$registry = new JRegistry();
			$registry->loadArray( $array['comp_params'] );
			$array['comp_params'] = $registry->toString();
		}
    	//print_r( $array );exit;
		return parent::bind( $array, $ignore );
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check()
	{
		// setting alias
		if ( empty( $this->alias ) )
		{
			$this->alias = JFilterOutput::stringURLSafe( $this->name );
		}
		else {
			$this->alias = JFilterOutput::stringURLSafe( $this->alias ); // make sure the user didn't modify it to something illegal...
		}
		return true;
	}
	
	/**
	 * Redefined asset name, as we support action control
	 */
	protected function _getAssetName() {
		$k = $this->_tbl_key;
		return 'com_joomleague.project.'.(int) $this->$k;
	}
	
}
?>