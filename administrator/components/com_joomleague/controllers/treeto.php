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

/**
 * Joomleague Component Treeto Controller
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueControllerTreeto extends JoomleagueController
{
	protected $view_list = 'treetos';

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
		$jinput = JFactory::getApplication() -> input; $option = $jinput -> get('option', '', 'string');
		$mainframe = JFactory::getApplication();
		$document = JFactory::getDocument();
		$model=$this->getModel('treetos');
		$viewType=$document->getType();
		$view=$this->getView('treetos',$viewType);
		$view->setModel($model,true);  // true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($mainframe->getUserState($option.'project',0));
		$view->setModel($projectws);

		switch($this->getTask())
		{
			case 'add':
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','treeto');
				JRequest::setVar('edit',false);

				$model=$this->getModel('treeto');
				//$model->checkout();
				break;
			}

			case 'edit':
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','treeto');
				JRequest::setVar('edit',true);

				$model=$this->getModel('treeto');
				//$model->checkout();
				break;
			}
		}
		parent::display();
	}

	// save the checked rows inside the treetos list (save division assignment)
	public function saveshort()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$post=$jinput->post;
		$cid = $jinput -> get('cid', array(0), 'array');

		$mainframe	= JFactory::getApplication();
 		$project_id = $mainframe->getUserState($option . 'project');

		JArrayHelper::toInteger($cid);

		$model = $this->getModel('treetos');

		if ($model->storeshort($cid, $post))
		{
			$msg = JText::_('COM_JOOMLEAGUE_ADMIN_TREETO_CTRL_SAVED');
		}
		else
		{
			$msg = JText::_('COM_JOOMLEAGUE_ADMIN_TREETO_CTRL_ERROR_SAVED') . $model->getError();
		}

		$link = 'index.php?option=com_joomleague&task=treeto.display&view=treetos';
		$this->setRedirect($link, $msg);
	}

	public function genNode()
	{
		$jinput = JFactory::getApplication() -> input; $option = $jinput -> get('option', '', 'string');
		$mainframe = JFactory::getApplication();
		$document = JFactory::getDocument();
		$proj=$mainframe->getUserState($option.'project',0);
		$post=$jinput->post;
		$cid = $jinput -> get('cid', array(), 'array');
		JArrayHelper::toInteger($cid);

		$model=$this->getModel('treeto');

		$viewType=$document->getType();
		$view=$this->getView('treeto',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($mainframe->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',0);
		JRequest::setVar('layout','gennode');
		JRequest::setVar('view','treeto');
		JRequest::setVar('edit',true);

		// Checkout the project
		//$model=$this->getModel('treeto');
		$model->checkout();
		parent::display();
	}

	public function generatenode()
	{
		JSession::checkToken() or die(JText::_('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN'));
		$jinput = JFactory::getApplication() -> input; $option = $jinput -> get('option', '', 'string');
		$mainframe = JFactory::getApplication();
		$post=$jinput->post;
		$model=$this->getModel('treeto');
		$project_id=$mainframe->getUserState($option.'project');
		if ($model->setGenerateNode() )
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_TREETO_CTRL_GENERATE_NODE');
			$link = 'index.php?option=com_joomleague&task=treetonode.display&view=treetonodes&tid[]='.$post['id'];
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_TREETO_CTRL_ERROR_GENERATE_NODE').$model->getError();
			$link = 'index.php?option=com_joomleague&view=treetos&task=treeto.display';
		}
		$this->setRedirect( $link, $msg );
	}

	public function save()
	{
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication() -> input;
		$post=$jinput->post;
		$cid = $jinput -> get('cid', array(0), 'array');
		$post['id'] = (int) $cid[0];
		$msg='';

		$model=$this->getModel('treeto');
		if ($model->store($post))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_TREETO_CTRL_SAVED');
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_TREETO_CTRL_ERROR_SAVED').$model->getError();
		}
		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		if ($this->getTask()=='save')
		{
			$link='index.php?option=com_joomleague&view=treetos&task=treeto.display';
		}
		else
		{
			$link='index.php?option=com_joomleague&task=treeto.edit&cid[]='.$post['id'];
		}
		$this->setRedirect($link,$msg);
	}

	public function remove()
	{
		$jinput = JFactory::getApplication() -> input; $cid = $jinput -> get('cid', array(), 'array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TO_DELETE'));}
		$model=$this->getModel('treeto');
		if (!$model->delete($cid)){echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";}
		$this->setRedirect('index.php?option=com_joomleague&task=treeto.display&view=treetos');
	}

	public function cancel()
	{
		// Checkin the project
		#$model=$this->getModel('treeto');
		#$model->checkin();
		$this->setRedirect('index.php?option=com_joomleague&task=treeto.display&view=treetos');
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
	public function getModel($name = 'Treeto', $prefix = 'JoomleagueModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}
?>
