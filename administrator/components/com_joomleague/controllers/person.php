<?php defined('_JEXEC') or die('Restricted access'); // Check to ensure this file is included in Joomla!
/**
 * @copyright	Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

/**
 * Joomleague Component Person Controller
 *
 * @package	JoomLeague
 * @since	1.50a
 */
class JoomleagueControllerPerson extends JoomleagueController
{
	protected $view_list = 'persons';

	public function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('add','display');
		$this->registerTask('edit','display');
		$this->registerTask('apply','save');
	}

	public function display($cachable = false, $urlparams = false)
	{
		switch($this->getTask())
		{
			case 'add' :
				{
					JRequest::setVar('hidemainmenu',0);
					JRequest::setVar('layout','form');
					JRequest::setVar('view','person');
					JRequest::setVar('edit',false);

					// Checkout the project
					$model=$this->getModel('person');
					$model->checkout();
				} break;

			case 'edit' :
				{
					JRequest::setVar('hidemainmenu',0);
					JRequest::setVar('layout','form');
					JRequest::setVar('view','person');
					JRequest::setVar('edit',true);

					// Checkout the project
					$model=$this->getModel('person');
					$model->checkout();
				} break;
		}
		parent::display();
	}

	public function save()
	{
		// Check for request forgeries
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$jinput = JFactory::getApplication() -> input;
		$post=$jinput->post;
		$ids = $jinput -> get('cid', array(0), 'array');
		$post['id'] = $ids[0]; //map cid to table pk: id

		// decription must be fetched without striping away html code
		$post['notes']=$jinput -> get('notes', '', 'string');

		$model=$this->getModel('person');

		if ($pid = $model->store($post))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_SAVED');

			if ($jinput -> get('assignperson', '', 'string'))
			{
				$project_team_id    = $jinput -> get('team_id', 0, 'int');;

				$model=$this->getModel('teamplayers');
				if ($model->storeassigned(array($pid), $project_team_id))
				{
					$msg .= ' - '.JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_PERSON_ASSIGNED');
				}
				else
				{
					$msg .= ' - '.JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED').$model->getError();
				}
				$model=$this->getModel('person');
			}
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_ERROR_SAVE').$model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		if ($this->getTask() == 'save')
		{
			$link='index.php?option=com_joomleague&view=persons';
		}
		else
		{
			$link='index.php?option=com_joomleague&task=person.edit&cid[]='.$post['id'];
		}
		#echo $msg;
		$this->setRedirect($link,$msg);
	}

	// save the checked rows inside the persons list
	public function saveshort()
	{
		$jinput = JFactory::getApplication() -> input;
		$post=$jinput->post;
		$ids = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($ids);
		$model=$this->getModel('person');
		if ($model->storeshort($ids,$post))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_PERSON_UPDATE');
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_ERROR_PERSON_UPDATE').$model->getError();
		}
		#echo $msg;
		$link='index.php?option=com_joomleague&view=persons&task=person.display';
		$this->setRedirect($link,$msg);
	}

	public function remove()
	{
		$jinput = JFactory::getApplication() -> input;
		$ids = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($ids);
		if (count($ids) < 1){JError::raiseError(500,JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TO_DELETE'));}
		$model=$this->getModel('person');
		if(!$model->delete($ids))
		{
			$this->setRedirect('index.php?option=com_joomleague&view=persons&task=person.display',$model->getError(),'error');
			return;
		}
		$this->setRedirect('index.php?option=com_joomleague&view=persons&task=person.display');
	}

	public function cancel()
	{
		// Checkin the project
		$model=$this->getModel('person');
		$model->checkin();
		$this->setRedirect('index.php?option=com_joomleague&view=persons&task=person.display');
	}

	//FIXME can it be removed?
	public function assign()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$mainframe	= JFactory::getApplication();
		$ids = $jinput -> get('cid', array(0), 'array');
		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','assignconfirm');
		JRequest::setVar('view','persons');
		JRequest::setVar('project_id',$mainframe->getUserState($option.'project',0));
		JRequest::setVar('pid', $ids[0]);
		// Checkout the project
		$model=$this->getModel('teamplayers');
		parent::display();
	}

	public function saveassigned()
	{
		$jinput = JFactory::getApplication() -> input;
		$post				= $jinput->post;
		$project_team_id	= $jinput -> get('project_team_id',0,'int');
		$pid 				= $jinput -> get('cid', array(0), 'array');
		$type				= $jinput -> get('type',0,'int');
		$project_id			= $jinput -> get('project_id',0,'int');
		JArrayHelper::toInteger($pid);
		if ($type == 0)
		{ //players
			$model=$this->getModel('teamplayers');

			if ($model->storeassigned($pid,$project_team_id))
			{
				$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_PERSON_ASSIGNED_AS_PLAYER');
			}
			else
			{
				$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED_AS_PLAYER').$model->getError();
			}
			$link='index.php?option=com_joomleague&view=teamplayers&task=teamplayer.display';
		}
		elseif ($type == 1)
		{ //staff
			$model=$this->getModel('teamstaffs');

			if ($model->storeassigned($pid,$project_team_id))
			{
				$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_PERSON_ASSIGNED_AS_STAFF');
			}
			else
			{
				$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED_AS_STAFF').$model->getError();
			}
			$link='index.php?option=com_joomleague&view=teamstaffs&task=teamstaff.display';
		}
		elseif ($type == 2)
		{ //referee
			$model=$this->getModel('projectreferees');

			if ($model->storeassigned($pid,$project_id))
			{
				$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_PERSON_ASSIGNED_AS_REFEREE');
			}
			else
			{
				$msg=JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED_AS_REFEREE').$model->getError();
			}
			$link='index.php?option=com_joomleague&view=projectreferees&task=projectreferee.display';
		}
		#echo $msg;
		$this->setRedirect($link,$msg);
	}

	// view,layout are settend in link request,to be changed?
	public function personassign()
	{
		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','assignperson');
		parent::display();
	}

	public function select()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$mainframe	= JFactory::getApplication();
		JRequest::setVar('team_id',$jinput -> get('team', '', 'string'));
		JRequest::setVar('task','teamplayers');
		$mainframe->setUserState($option.'team_id',$jinput -> get('team_id', '', 'string'));
		$mainframe->setUserState($option.'task',$jinput -> get('task', '', 'string'));
		$this->setRedirect('index.php?option=com_joomleague&task=person.display&view=persons&layout=teamplayers');
	}

	public function import()
	{
		JRequest::setVar('view',	'import');
		JRequest::setVar('table',	'person');
		parent::display();
	}

	public function export()
	{
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$jinput = JFactory::getApplication() -> input;
		$post=$jinput->post;
		$cid = $jinput -> get('cid', array(0), 'array');
		if (count($cid) < 1){JError::raiseError(500,JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TO_EXPORT'));}
		$model = $this->getModel("person");
		$model->export($cid, "person", "Person");
	}

	/**
	 * Proxy for getModel
	 *
	 * @param	string	$name	The model name. Optional.
	 * @param	string	$prefix	The class prefix. Optional.
	 *
	 * @return	object	The model.
	 * @since	1.6
	 */
	public function getModel($name = 'Person', $prefix = 'JoomleagueModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}
?>