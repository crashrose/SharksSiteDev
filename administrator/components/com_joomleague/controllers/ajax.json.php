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

jimport('joomla.application.component.controller');

/**
 * Joomleague Ajax Controller
 *
 * @package		Joomleague
 * @since 1.5
 */
class JoomleagueControllerAjax extends JControllerLegacy
{

	public function __construct()
	{
		// Get the document object.
		$document = JFactory::getDocument();
		// Set the MIME type for JSON output.
		$document->setMimeEncoding('application/json');
		parent::__construct();
	}

	public function projectdivisionsoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectDivisionsOptions($jinput -> get('p', 0, 'int' ), $required));
	}

	public function projecteventsoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectEventsOptions($jinput -> get('p', 0, 'int' ), $required));
	}

	public function projectteamsbydivisionoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectTeamsByDivisionOptions($jinput -> get('p', 0, 'int' ), $jinput -> get('division', 0, 'int' ), $required));
	}

	public function projectsbysportstypesoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectsBySportsTypesOptions($jinput -> get('sportstype', 0, 'int' ), $required));
	}

	public function projectsbycluboptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectsByClubOptions($jinput -> get('cid', 0, 'int' ), $required));
	}

	public function projectteamsoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectTeamOptions($jinput -> get('p', 0, 'int' ),$jinput -> get('division', 0, 'int' ),$required));
	}

	public function projectplayeroptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectPlayerOptions($jinput -> get('p', 0, 'int' ),$jinput -> get('division', 0, 'int' ),$required));
	}

	public function projectstaffoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectStaffOptions($jinput -> get('p', 0, 'int' ),$jinput -> get('division', 0, 'int' ),$required));
	}

	public function projectclubsoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectClubOptions($jinput -> get('p', 0, 'int' ), $required));
	}

	public function projectstatsoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectStatOptions($jinput -> get('p', 0, 'int' ), $required));
	}

	public function matchesoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getMatchesOptions($jinput -> get('p', 0, 'int' ),$jinput -> get('division', 0, 'int' ), $required));
	}

	public function refereesoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getRefereesOptions($jinput -> get('p', 0, 'int' ), $required));
	}

	public function roundsoptions()
	{
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) JoomleagueHelper::getRoundsOptions($jinput -> get('p', 0, 'int' ),'ASC', $required));
	}

	public function projecttreenodeoptions()
	{
		$model = $this->getModel('ajax');
		$jinput = JFactory::getApplication() -> input;
		$req = $jinput -> get('required', false, 'boolean');
		$required = ($req == 'true' || $req == '1') ? true : false;
		echo json_encode((array) $model->getProjectTreenodeOptions($jinput -> get('p', 0, 'int' ), $required));
	}

	public function sportstypesoptions()
	{
		echo json_encode((array) JoomleagueModelSportsTypes::getSportsTypes());
	}

}
