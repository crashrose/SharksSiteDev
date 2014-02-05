<?php
/**
 * @version	 $Id: mod_joomleague_ticker.php 4905 2012-02-02 22:51:33Z and_one $
 * @package	 Joomla
 * @subpackage  Joomleague ticker module
 * @copyright	Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license	 GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */
defined('_JEXEC') or die('Restricted access');

//get helper
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joomleague'.DIRECTORY_SEPARATOR.'joomleague.core.php');

$document = JFactory::getDocument();

//add css file
$document->addStyleSheet(JUri::base().'modules/mod_joomleague_ticker/css/mod_joomleague_ticker.css');

$mode = $params->def("mode");
$results = $params->get('results');
$round = $params->get('round');
$ordering = $params->get('ordering');
$matchstatus=$params->get('matchstatus');
$selectiondate = modJoomleagueTickerHelper::getSelectionDate($params->get('daysback'), $params->get('timezone', 'Europe/Amsterdam'));
$bUseFav = $params->get('usefavteams');

$matches = modJoomleagueTickerHelper::getMatches($results, $params->get('p'), $params->get('teamid'), $selectiondate, $ordering, $round, $matchstatus,$bUseFav);
if(empty($matches) || count($matches) == 0)
{
	echo JText::_("No matches");
	return;
} else {
	$timezone = new DateTimeZone($params->get('timezone'));
	$utc = new DateTime();
	$offset = $timezone->getOffset($utc);
	$date = modJoomleagueTickerHelper::getCorrectDateFormat($params->get('dateformat'), $matches, $offset, $params->get('timezone'));
	if (count($matches)<$results)
	{
		$results=count($matches);
	}

	$tickerpause = $params->def("tickerpause");
	$scrollspeed = $params->def("scrollspeed");
	$scrollpause = $params->def("scrollpause");

	switch ($mode)
	{
		case 'T':
			include(dirname(__FILE__).DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'ticker.js');
			break;
		case 'V':
			include(dirname(__FILE__).DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'qscrollerv.js');
			$document->addScript(JUri::base().'modules/mod_joomleague_ticker/js/qscroller.js');
			break;
		case 'H':
			include(dirname(__FILE__).DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'qscrollerh.js');
			$document->addScript(JUri::base().'modules/mod_joomleague_ticker/js/qscroller.js');
			break;
	}
}
require(JModuleHelper::getLayoutPath('mod_joomleague_ticker'));
?>