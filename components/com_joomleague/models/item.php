<?php
/**
 * @copyright	Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.modeladmin' );

/**
 * Joomleague Component Item Model
 *
 * @package	JoomLeague
 * @since	1.505a
 */
if(!class_exists('JoomleagueModelItem')) {
class JoomleagueModelItem extends JModelAdmin
{
	/**
	 * item id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Project data
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	function __construct()
	{
		parent::__construct();

		$jinput = JFactory::getApplication() -> input;
		$array= $jinput -> get('cid', array(0), 'array');
		$edit = $jinput -> get('edit', true, 'boolean' );
		if( $edit )
		{
			$this->setId( (int)$array[0] );
		}
	}

	/**
	 * Method to set the item identifier
	 *
	 * @access	public
	 * @param	int item identifier
	 */
	function setId( $id )
	{
		// Set item id and wipe data
		$this->_id	  = $id;
		$this->_data	= null;
	}

	/**
	 * Method to get an item
	 *
	 * @since 0.1
	 */
	function &getData()
	{
		// Load the item data
		if ( !$this->_loadData() )
		{
			$this->_initData();
		}

		return $this->_data;
	}

	/**
	 * Tests if item is checked out
	 *
	 * @access	public
	 * @param	int	A user id
	 * @return	boolean	True if checked out
	 * @since	0.1
	 */
	function isCheckedOut( $uid = 0 )
	{
		if ( $this->_loadData() )
		{
			if ( $uid )
			{
				return ( $this->_data->checked_out && $this->_data->checked_out != $uid );
			}
			else
			{
				return $this->_data->checked_out;
			}
		}
	}

	/**
	 * Method to store the item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store( $data, $table = '' )
	{
		if ( $table == '')
		{
			$row =& $this->getTable();
		}
		else
		{
			$row = JTable::getInstance( $table, 'Table' );
		}

		// Bind the form fields to the items table
		if ( !$row->bind( $data ) )
		{
			$this->setError( JText::_('Binding failed') );
			return false;
		}

		// Create the timestamp for the date
		$row->checked_out_time = gmdate( 'Y-m-d H:i:s' );

		// if new item, order last, but only if an ordering exist
		if ( ( isset( $row->id ) ) && ( isset( $row->ordering ) ) )
		{
			if ( !$row->id && $row->ordering != NULL )
			{
				$row->ordering = $row->getNextOrder();
			}
		}

		// Make sure the item is valid
		if ( !$row->check() )
		{
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		// Store the item to the database
		if ( !$row->store() )
		{
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		return true;
	}

	/**
	 * Method to move an item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function move( $direction )
	{
		$row =& $this->getTable();
		if ( !$row->load( $this->_id ) )
		{
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		if ( !$row->move( $direction ) )
		{
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		return true;
	}

	/**
	 * Returns a Table object, always creating it
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'tablename', $prefix = '', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.7
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_joomleague.'.$this->name, $this->name,
				array('load_data' => $loadData) );
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.7
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_joomleague.edit.'.$this->name.'.data', array());
		if (empty($data))
		{
			$data = $this->getData();
		}
		return $data;
	}
}
}
?>