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

jimport( 'joomla.application.component.controller' );

class JoomleagueControllerPerson extends JoomleagueController
{

	public function display($cachable = false, $urlparams = false)
	{
		// Get the view name from the query string
		$jinput = JFactory::getApplication() -> input;
		$viewName = $jinput -> get('view', 'person', 'string' );

		// Get the view
		$view = $this->getView( $viewName );

		// Get the joomleague model
		$jl = $this->getModel( 'project', 'JoomleagueModel' );
		$jl->set( '_name', 'project' );
		if ( !JError::isError( $jl ) )
		{
			$view->setModel ( $jl );
		}

		// Get the joomleague model
		$sr = $this->getModel( 'person', 'JoomleagueModel' );
		$sr->set( '_name', 'person' );
		if ( !JError::isError( $sr ) )
		{
			$view->setModel ( $sr );
		}

		$this->showprojectheading();
		$view->display();
		$this->showbackbutton();
		$this->showfooter();
	}

	public function save( )
	{
		// Check for request forgeries
		JSession::checkToken() or die( 'COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN' );
		$jinput = JFactory::getApplication() -> input;

		$pid = $jinput -> get('pid', 0, 'int');
		$tpid = $jinput -> get('tpid', 0, 'int'); //teamplayer

		$post = JRequest::get( 'post' );

		if( $pid > 0 )
		{
			//set id
			$post['id'] = $pid;
			// Convert Date
			$post['birthday'] = JoomleagueHelper::convertDate( $post['birthday'], 0 );
			$post['deathday'] = JoomleagueHelper::convertDate( $post['deathday'], 0 );

			$model = $this->getModel('person');
			$params =& JComponentHelper::getParams('com_joomleague');

			// Save methode des models benutzen
			if( $model->store($post, 'Person') )
			{
				$user = JFactory::getUser();

				$person=$model->getPerson($pid);
				$to = $model->getPlayerChangedRecipients();

				$nickname = $person->nickname;
				if( !empty($nickname) )
				{
					$nickname = "'".$nickname."'";
				}

				$subject = addslashes(
				sprintf(
				JText::_( "COM_JOOMLEAGUE_EDIT_PERSON_SUBJECT" ),
				$person->firstname, $nickname, $person->lastname ) );
				$message = addslashes(sprintf(
				JText::_( "COM_JOOMLEAGUE_EDIT_PERSON_MESSAGE" ),
				$user->name,
				$person->firstname, $nickname, $person->lastname ) );
				$message .= $this->_getShowPlayerLink();

				// send mail
				if ( $params->get('cfg_edit_person_info_update_notify') == "1" )
				{
				$model->sendMailTo($to,$subject,$message);
				}

				// save player information
				if( JoomleagueControllerPerson::_saveTeamplayer($tpid,$post) )
				{
					$msg = JText::_( 'COM_JOOMLEAGUE_EDIT_PERSON_SAVED' );
				}
				else
				{
					$msg .= ' '.JText::_( 'COM_JOOMLEAGUE_EDIT_PERSON_SAVE_ERROR' ) . $model->getError();
				}
			}
			else
			{
				$msg .= ' '.JText::_( 'COM_JOOMLEAGUE_EDIT_PERSON_SAVE_ERROR' ) . $model->getError();
			}
		}
		$this->setRedirect( $this->_getShowPlayerLink(), $msg);
	}

	private function _saveTeamplayer($tpid,$post)
	{
		$jinput = JFactory::getApplication() -> input;
		if( $tpid > 0 )
		{
			//set id
			$post['id'] = $tpid;

			$model = $this->getModel('player');

			// decription must be fetched without striping away html code
			$post['notes'] = $jinput -> get('notes', 'none', 'string' );


			// Save methode des models benutzen
			return $model->store($post, 'TeamPlayer');
		}

		return false;
	}

	public function cancel( )
	{
		$this->setRedirect( $this->_getShowPlayerLink() );
	}


	private function _getShowPlayerLink( )
	{
		$jinput = JFactory::getApplication() -> input;
		$p = $jinput -> get('p',0,'int');
		$tid = $jinput -> get('tid',0,'int');
		$pid = $jinput -> get('pid', 0, 'int');
		$link = JoomleagueHelperRoute::getPlayerRoute( $p, $tid, $pid );
		return $link;
	}

}
?>
