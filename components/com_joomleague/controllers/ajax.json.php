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

jimport('joomla.application.component.controller');

class JoomleagueControllerAjax extends JoomleagueController
{
	public function __construct()
	{
		// Get the document object.
		$document = JFactory::getDocument();
		// Set the MIME type for JSON output.
		$document->setMimeEncoding('application/json');
		parent::__construct();
	}

	public function getprojectsoptions()
	{
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication() -> input;

		$season = $jinput -> get('s', 0, 'int');
		$league = $jinput -> get('l', 0, 'int');
		$ordering = $jinput -> get('o', 0, 'int');

		$model = $this->getModel('ajax');

		$res = $model->getProjectsOptions($season, $league, $ordering);

		echo json_encode($res);

		$app->close();
	}

	public function getroute()
	{
		$jinput = JFactory::getApplication() -> input;
		$view = $jinput -> get('view', '', 'string');

		switch ($view)
		{
			case "matrix":
				$link = JoomleagueHelperRoute::getMatrixRoute($jinput -> get('p', '', 'string'),$jinput -> get('division', '', 'string'),$jinput -> get('r', '', 'string') );
				break;

			case "teaminfo":
				$link = JoomleagueHelperRoute::getTeamInfoRoute($jinput -> get('p', '', 'string'), $jinput -> get('tid', '', 'string') );
				break;

			case "referees":
				$link = JoomleagueHelperRoute::getRefereesRoute($jinput -> get('p', '', 'string') );
				break;

			case "results":
				$link = JoomleagueHelperRoute::getResultsRoute($jinput -> get('p', '', 'string'),$jinput -> get('r', '', 'string'),$jinput -> get('division', '', 'string') );
				break;

			case "resultsranking":
				$link = JoomleagueHelperRoute::getResultsRankingRoute($jinput -> get('p', '', 'string') );
				break;

			case "rankingmatrix":
				$link = JoomleagueHelperRoute::getRankingMatrixRoute($jinput -> get('p', '', 'string'),$jinput -> get('r', '', 'string'),$jinput -> get('division', '', 'string') );
				break;

			case "resultsrankingmatrix":
				$link = JoomleagueHelperRoute::getResultsRankingMatrixRoute($jinput -> get('p', '', 'string'),$jinput -> get('r', '', 'string'),$jinput -> get('division', '', 'string') );
				break;

			case "teamplan":
				$link = JoomleagueHelperRoute::getTeamPlanRoute($jinput -> get('p', '', 'string'), $jinput -> get('tid', '', 'string'),$jinput -> get('division', '', 'string') );
				break;

			case "roster":
				$link = JoomleagueHelperRoute::getPlayersRoute($jinput -> get('p', '', 'string'), $jinput -> get('tid', '', 'string') );
				break;

			case "eventsranking":
				$link = JoomleagueHelperRoute::getEventsRankingRoute($jinput -> get('p', '', 'string'),$jinput -> get('division', '', 'string'),$jinput -> get('tid', '', 'string') );
				break;

			case "curve":
				$link = JoomleagueHelperRoute::getCurveRoute($jinput -> get('p', '', 'string'),$jinput -> get('tid', '', 'string'),0,$jinput -> get('division', '', 'string') );
				break;

			case "statsranking":
				$link = JoomleagueHelperRoute::getStatsRankingRoute($jinput -> get('p', '', 'string'),$jinput -> get('division', '', 'string') );
				break;

			default:
			case "ranking":
				$link = JoomleagueHelperRoute::getRankingRoute($jinput -> get('p', '', 'string'),$jinput -> get('r', '', 'string'),null,null,0,$jinput -> get('division', '', 'string') );
		}

		echo json_encode($link);
	}
}