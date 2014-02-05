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
 * @since	0.1
 */
class JoomleagueViewEventtype extends JLGView
{
	function display($tpl=null)
	{
		if($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();

		$db = JFactory::getDbo();
		$uri = JFactory::getURI();
		$user = JFactory::getUser();
		$model = $this->getModel();

		$lists=array();
		//get the project
		$event = $this->get('data');
		$isNew = ($event->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('COM_JOOMLEAGUE_EVENTTYPE_THE_EVENT'),JText::_($event->name));
			$mainframe->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}

		$this->event = $event;
		//$extended = $this->getExtended($projectreferee->extended, 'eventtype');
		//$this->assignRef( 'extended', $extended );
		
		$this->form = $this->get('form');		
		$this->addToolbar();			
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
		$edit=JRequest::getVar('edit',true);
		$text=!$edit ? JText::_('COM_JOOMLEAGUE_GLOBAL_NEW') : JText::_('COM_JOOMLEAGUE_GLOBAL_EDIT'). ': ' . JText::_($this->event->name);
		JToolBarHelper::title((JText::_('COM_JOOMLEAGUE_ADMIN_EVENTTYPE_EVENT').': <small><small>[ '.$text.' ]</small></small>'),'events');
		JLToolBarHelper::save('eventtype.save');
		if (!$edit)
		{
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('eventtype.cancel');
		}
		else
		{		
			// for existing items the button is renamed `close` and the apply button is showed
			JLToolBarHelper::apply('eventtype.apply');
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('eventtype.cancel','COM_JOOMLEAGUE_GLOBAL_CLOSE');
		}
		JToolBarHelper::help('screen.joomleague',true);
	}
}
?>
