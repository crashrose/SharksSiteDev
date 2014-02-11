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

jimport('joomla.application.component.model');
require_once (JPATH_COMPONENT.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'list.php');

/**
 * Joomleague Component Teams Model
 *
 * @package		Joomleague
 * @since 0.1
 */
class JoomleagueModelTeams extends JoomleagueModelList
{
	var $_identifier = "teams";

	function _buildQuery()
	{
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();

		$query = ' SELECT c.name as clubname, c.id AS club_id, t.*, u.name AS editor '
				. ' FROM #__joomleague_team AS t '
				. ' LEFT JOIN #__joomleague_club AS c '
				. ' ON t.club_id = c.id'
				. ' LEFT JOIN #__users AS u ON u.id = t.checked_out '
				. $where
				. $orderby
		;
		return $query;
	}

	function _buildContentOrderBy()
	{
		$jinput = JFactory::getApplication() -> input; $option = $jinput -> get('option', '', 'string');
		$mainframe	= JFactory::getApplication();

		$filter_order		= $mainframe->getUserStateFromRequest( $option.'t_filter_order','filter_order','t.ordering','cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'t_filter_order_Dir','filter_order_Dir','','word' );

		if ($filter_order == 't.ordering'){
			$orderby 	= ' ORDER BY t.ordering '.$filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir.' , t.ordering ';
		}

		return $orderby;
	}
	function _buildContentWhere()
	{
		$jinput = JFactory::getApplication() -> input; $option = $jinput -> get('option', '', 'string');
		$mainframe	= JFactory::getApplication();

		$filter_state		= $mainframe->getUserStateFromRequest( $option.'t_filter_state',		'filter_state',		'',				'word' );
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'t_filter_order',		'filter_order',		't.ordering',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'t_filter_order_Dir',	'filter_order_Dir',	'',				'word' );
		$search			= $mainframe->getUserStateFromRequest( $option.'t_search',			'search',			'',				'string' );
		$search_mode		= $mainframe->getUserStateFromRequest( $option.'t_search_mode',			'search_mode',			'',				'string' );
		$search			= JString::strtolower( $search );

		$where = array();

		if ($search) {
			if($search_mode)
				$where[] = 'LOWER(t.name) LIKE '.$this->_db->Quote($search.'%');
			else
				$where[] = 'LOWER(t.name) LIKE '.$this->_db->Quote('%'.$search.'%');
		}

                if ($cid = $jinput -> get('cid', 0, 'int')) {
                    $where[] = 'club_id ='. $cid;
                }

                $where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}
}
?>
