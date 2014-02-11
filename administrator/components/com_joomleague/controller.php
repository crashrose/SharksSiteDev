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

jimport('joomla.application.component.controlleradmin');

/**
 * Joomleague Common Controller
 *
 * @package	JoomLeague
 * @since	2.5
 */

class JoomleagueController extends JLGControllerAdmin
{

	public function display($cachable = false, $urlparams = false)
	{
		$jinput = JFactory::getApplication() -> input;
		// display the left menu only if hidemainmenu is not true
		$show_menu=!$jinput -> get('hidemainmenu',false,'boolean');

		// display left menu

		$viewName = $jinput -> get('view', '', 'string');
		$layoutName=$jinput -> get('layout', 'default', 'string');
		if($viewName == '' && $layoutName=='default') {
			JRequest::setVar('view', 'projects');
			$viewName = "projects";
		}
		if ($viewName != 'about' && $show_menu) {
			$this->ShowMenu();
		}
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$view = $this->getView($viewName,$viewType);
		$view->setLayout($layoutName);
		$model = $this->getModel($viewName);
		$view->setModel($model, true);
		$view->display();
		parent::display($cachable, $urlparams);
	}

	public function ShowMenu()
	{
		$jinput = JFactory::getApplication() -> input;
		$option		= $jinput -> get('option', '', 'string');
		$mainframe	= JFactory::getApplication();
		$document	= JFactory::getDocument();
		$viewType	= $document->getType();
		$view		= $this->getView('joomleague',$viewType);
		if ($model = $this->getModel('project'))
		{
			// Push the model into the view (as default)
			$model->setId($mainframe->getUserState($option.'project',0));
			$view->setModel($model,true);
		}
		$view->display();
	}

	public function ShowMenuExtension()
	{
		$jinput = JFactory::getApplication() -> input;
		$option		= $jinput -> get('option', '', 'string');
		$mainframe = JFactory::getApplication();
		$document = JFactory::getDocument();
		$viewType=$document->getType();
		$view = $this->getView('joomleague',$viewType);
		$view->setLayout('extension');
		$view->display();
	}

	public function ShowMenuFooter()
	{
		$jinput = JFactory::getApplication() -> input;
		$option		= $jinput -> get('option', '', 'string');
		$mainframe = JFactory::getApplication();
		$document = JFactory::getDocument();
		$viewType=$document->getType();
		$view = $this->getView('joomleague',$viewType);
		$view->setLayout('footer');
		$view->display();
	}

	public function selectws()
	{
		$jinput = JFactory::getApplication() -> input;
		$option		= $jinput -> get('option', '', 'string');
		$mainframe = JFactory::getApplication();

		$stid	= $jinput -> get('stid',	array(0),'array');
		$pid	= $jinput -> get('pid',	array(0),'array');
		$tid	= $jinput -> get('tid',	array(0),'array');
		$rid	= $jinput -> get('rid',	array(0),'array');
		$sid	= $jinput -> get('seasonnav',	array(0),'array');
		$act	= $jinput -> get('act',0, 'int');

		$seasonnav = $jinput -> get('seasonnav',0, 'int');

		$mainframe->setUserState($option.'seasonnav', $seasonnav);

		switch ($act)
		{
			case 'projects':
				if ($mainframe->setUserState($option.'project',(int)$pid[0]))
				{
					$mainframe->setUserState($option.'project_team_id','0');
					$this->setRedirect('index.php?option=com_joomleague&task=joomleague.workspace&layout=panel&pid[]='.$pid[0],JText::_('COM_JOOMLEAGUE_ADMIN_CTRL_PROJECT_SELECTED'));
				}
				else
				{
					$this->setRedirect('index.php?option=com_joomleague&view=projects&task=project.display');
				}
				break;

			case 'teams':
				$mainframe->setUserState($option.'project_team_id',(int)$tid[0]);
				if ((int) $tid[0] != 0)
				{
					$this->setRedirect('index.php?option=com_joomleague&view=teamplayers&task=teamplayer.display',JText::_('COM_JOOMLEAGUE_ADMIN_CTRL_TEAM_SELECTED'));
				}
				else
				{
					$this->setRedirect('index.php?option=com_joomleague&task=joomleague.workspace&layout=panel&pid[]='.$pid[0]);
				}
				break;

			case 'rounds':
				if ((int) $rid[0] != 0)
				{
					$this->setRedirect('index.php?option=com_joomleague&view=matches&task=match.display&rid[]='.$rid[0],JText::_('COM_JOOMLEAGUE_ADMIN_CTRL_ROUND_SELECTED'));
				}
				break;

			case 'seasons':
				$this->setRedirect('index.php?option=com_joomleague&view=projects&task=project.display&sid[]='.$sid[0], JText::_('COM_JOOMLEAGUE_ADMIN_CTRL_SEASON_SELECTED'));
				break;

			default:
				if ($mainframe->setUserState($option.'sportstypes',(int)$stid[0]))
				{
					$mainframe->setUserState($option.'project','0');
					$this->setRedirect('index.php?option=com_joomleague&task=project.display&view=projects&stid[]='.$stid[0],JText::_('COM_JOOMLEAGUE_ADMIN_CTRL_SPORTSTYPE_SELECTED'));
				}
				else
				{
					$this->setRedirect('index.php?option=com_joomleague&view=sportstypes&task=sportstype.display');
				}
		}

	}
}

/**
 *
 * just to display the cpanel
 * @author And_One
 *
 */
class JoomleagueControllerJoomleague extends JoomleagueController {
}
