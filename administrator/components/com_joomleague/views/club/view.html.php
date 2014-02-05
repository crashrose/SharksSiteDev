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
class JoomleagueViewClub extends JLGView
{

	function display($tpl=null)
	{
		$option = JRequest::getCmd('option');
		$mainframe = JFactory::getApplication();
		$uri 	= JFactory::getURI();
		$user 	= JFactory::getUser();
		$model	= $this->getModel();

		$edit	= JRequest::getVar('edit',true);

		$lists=array();
		//get the club
		$club	= $this->get('data');
		$isNew	= ($club->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('COM_JOOMLEAGUE_ADMIN_CLUB'),$club->name);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			// initialise new record
			$club->order=0;
		}

		$this->form = $this->get('form');	
		$this->edit = $edit;
		$extended = $this->getExtended($club->extended, 'club');
		$this->extended = $extended;
		$this->lists = $lists;
		$this->club = $club;

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
		JLToolBarHelper::save('club.save');

		if (!$this->edit)
		{
			JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_CLUB_ADD_NEW'),'clubs');
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('club.cancel');
		}
		else
		{
			// for existing items the button is renamed `close` and the apply button is showed
			JToolBarHelper::title(JText::_('COM_JOOMLEAGUE_ADMIN_CLUB_EDIT'). ': ' . $this->club->name,'clubs');
			JLToolBarHelper::apply('club.apply');
			JToolBarHelper::divider();
			JLToolBarHelper::cancel('club.cancel','COM_JOOMLEAGUE_GLOBAL_CLOSE');
		}
		
		JToolBarHelper::help('screen.joomleague',true);		
	}	
}
?>
