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

jimport('joomla.application.component.view');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	1.5
 */
class JoomleagueViewPerson extends JLGView
{
	function display($tpl=null)
	{
		if ($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}
		elseif ($this->getLayout() == 'assignperson')
		{
			$this->_displayModal($tpl);
			return;
		}
	}

	function _displayForm($tpl)
	{
		$jinput = JFactory::getApplication() -> input; $option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$db = JFactory::getDbo();
		$uri = JFactory::getURI();
		$user = JFactory::getUser();
		$model = $this->getModel();
		$edit = $jinput -> get('edit',true, 'boolean');
		$lists=array();

		//get the person
		$person = $this->get('data');
		$isNew=($person->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_THEPERSON'),$person->name);
			$app->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			$person->ordering=0;
		}

		$this->form = $this->get('form');
		$this->edit = $edit;
		$extended = $this->getExtended($person->extended, 'person');
		$this->extended = $extended;
		//$this->assignRef('lists',$lists);
		$this->person = $person;

		$this->addToolbar();

		// Load the language files for the contact integration
		$jlang = JFactory::getLanguage();
		$jlang->load('com_contact', JPATH_ADMINISTRATOR, 'en-GB', true);
		$jlang->load('com_contact', JPATH_ADMINISTRATOR, $jlang->getDefault(), true);
		$jlang->load('com_contact', JPATH_ADMINISTRATOR, null, true);

		parent::display($tpl);
	}

	function _displayModal($tpl)
	{
		$app	= JFactory::getApplication();
		JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_ASSIGN_DESCR'));
		// Do not allow cache
		JResponse::allowCache(false);

		$document = JFactory::getDocument();
		$prjid=array();
		$jinput = JFactory::getApplication() -> input;
		$prjid=$jinput -> get('prjid',array(0),'array');
		$proj_id=(int) $prjid[0];

		//build the html select list for projects
		$projects[]=JHtml::_('select.option','0',JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_PROJECT'),'id','name');

		if ($res=JoomleagueHelper::getProjects()){$projects=array_merge($projects,$res);}
		$lists['projects']=JHtmlSelect::genericlist(	$projects,
														'prjid[]',
														'class="inputbox" onChange="this.form.submit();" style="width:170px"',
														'id',
														'name',
														$proj_id);
		unset($projects);

		$projectteams[]=JHtmlSelect::option('0',JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TEAM'),'value','text');

		// if a project is active we show the teams select list
		if ($proj_id > 0)
		{
			if ($res=JoomleagueHelper::getProjectteams($proj_id)){$projectteams=array_merge($projectteams,$res);}
			$lists['projectteams']=JHtmlSelect::genericlist($projectteams,'xtid[]','class="inputbox" style="width:170px"','value','text');
			unset($projectteams);
		}

		$this->assignRef('lists',$lists);
		$this->assignRef('project_id',$proj_id);

		parent::display($tpl);
	}
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{
		// Set toolbar items for the page
		$text = !$this->edit ? JText::_('COM_JOOMLEAGUE_GLOBAL_NEW') : JText::_('COM_JOOMLEAGUE_GLOBAL_EDIT');

		JLToolBarHelper::save('person.save');

		if (!$this->edit)
		{
			JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_TITLE'));
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('person.cancel');
		}
		else
		{
			$jinput = JFactory::getApplication() -> input; $option = $jinput -> get('option', '', 'string');
			$params = JComponentHelper::getParams( $option );
			$default_name_format = $params->get("name_format");
			// for existing items the button is renamed `close` and the apply button is showed
			$name = JoomleagueHelper::formatName(null ,$this->person->firstname, $this->person->nickname, $this->person->lastname, $default_name_format);
			JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_PERSON_TITLE2'). ': ' . $name);
			JLToolBarHelper::apply('person.apply');
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('person.cancel',JText::_('COM_JOOMLEAGUE_GLOBAL_CLOSE'));
		}
		JToolBarHelper::divider();
		JToolBarHelper::back();
		JToolBarHelper::help('screen.joomleague',true);
	}

}
?>