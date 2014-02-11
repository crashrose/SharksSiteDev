<?php
/**
 * @copyright	Copyright (C) 2006-2013 joomleague.at. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model');

require_once( JLG_PATH_SITE .DIRECTORY_SEPARATOR. 'models' .DIRECTORY_SEPARATOR. 'project.php' );

class JoomleagueModelStatsRanking extends JoomleagueModelProject
{
	/**
	 * players total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	var $order = null;
	var $divisionid = 0;
	var $teamid = 0;

	function __construct( )
	{
		parent::__construct( );

		$jinput = JFactory::getApplication() -> input;
		$this->projectid	= $jinput -> get('p', 0, 'int' );
		$this->divisionid	= $jinput -> get( 'division', 0, 'int' );
		$this->teamid		= $jinput -> get( 'tid', 0, 'int' );
		$this->setStatid($jinput -> get('sid', 0, 'int'));
		$config = $this->getTemplateConfig($this->getName());
		// TODO: the default value for limit should be updated when we know if there is more than 1 statistics type to be shown
		if ( $this->stat_id != 0 )
		{
			$this->limit = $jinput -> get('limit', $config["max_stats"] , 'int');
		}
		else
		{
			$this->limit = $jinput -> get( 'limit', $config["count_stats"], 'int' );
		}
		$this->limitstart = $jinput -> get('limitstart', 0 , 'int');
		$this->setOrder($jinput -> get('order', '', 'string'));
	}

	function getDivision()
	{
		$division = null;
		if ($this->divisionid != 0)
		{
			$division = parent::getDivision($this->divisionid);
		}
		return $division;
	}

	function getTeamId()
	{
		return $this->teamid;
	}

	/**
	 * set order (asc or desc)
	 * @param string $order
	 * @return string order
	 */
	function setOrder($order)
	{
		if (strcasecmp($order, 'asc') === 0 || strcasecmp($order, 'desc') === 0) {
			$this->order = strtolower($order);
		}
		return $this->order;
	}

	function getLimit( )
	{
		return $this->limit;
	}

	function getLimitStart( )
	{
		return $this->limitstart;
	}

	function setStatid($statid)
	{
		// Allow for multiple statistics IDs, arranged in a single parameters (sid) as string
		// with "|" as separator
		$sidarr = explode("|", $statid);
		$this->stat_id = array();
		foreach ($sidarr as $sid)
		{
			$this->stat_id[] = (int)$sid;	// The cast gets rid of the slug
		}
		// In case 0 was (part of) the sid string, make sure all stat types are loaded)
		if (in_array(0, $this->stat_id))
		{
			$this->stat_id = 0;
		}
	}

	// return unique stats assigned to project
	/**
	 * (non-PHPdoc)
	 * @see components/com_joomleague/models/JoomleagueModelProject#getProjectStats($statid, $positionid)
	 */
	function getProjectUniqueStats()
	{
		$pos_stats = $this->getProjectStats($this->stat_id);

		$allstats = array();
		foreach ($pos_stats as $pos => $stats)
		{
			foreach ($stats as $stat) {
				$allstats[$stat->id] = $stat;
			}
		}
		return $allstats;
	}

	function getPlayersStats($order=null)
	{
		$stats = &$this->getProjectUniqueStats();
		$order = ($order ? $order : $this->order);

		$results = array();
		foreach ($stats as $stat)
		{
			$results[$stat->id] = $stat->getPlayersRanking($this->projectid, $this->divisionid, $this->teamid, $this->getLimit(), $this->getLimitStart(), $order);
		}

		return $results;
	}

}
?>