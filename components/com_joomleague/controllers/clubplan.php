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

class JoomleagueControllerClubPlan extends JoomleagueController
{
	public function display($cachable = false, $urlparams = false)
	{
		$jinput = JFactory::getApplication() -> input;
		// Get the view name from the query string
		$viewName=$jinput -> get('view', 'clubplan','string');
		$startdate=$jinput -> get('startdate','', 'string');
		$enddate=$jinput -> get('enddate','', 'string');

		// Get the view
		$view = $this->getView($viewName);

		// Get the joomleague model
		$jl = $this->getModel("joomleague","JoomleagueModel");
		$jl->set("_name","joomleague");
		if (!JError::isError($jl)){$view->setModel($jl);}

		$mdlClubPlan = $this->getModel("clubplan","JoomleagueModel");
		$mdlClubPlan->set("_name","clubplan");
		$mdlClubPlan->setStartDate($startdate);
		$mdlClubPlan->setEndDate($enddate);
		if (!JError::isError($mdlClubPlan)){$view->setModel($mdlClubPlan);}

		$this->showprojectheading();
		$view->display();
		$this->showbackbutton();
		$this->showfooter();
	}

}
?>