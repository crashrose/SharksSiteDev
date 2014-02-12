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
 * Joomleague Component Match Model
 *
 * @author	Marco Vaninetti <martizva@tiscali.it>
 * @package	JoomLeague
 * @since	0.1
 */

class JoomleagueControllerMatch extends JoomleagueController
{

	public function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('add','display');
		$this->registerTask('edit','display');
		$this->registerTask('apply','save');
	}

	public function display($cachable = false, $urlparams = false) {
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$document = JFactory::getDocument();
		$app = JFactory::getApplication();

		// check if pid was specified in request
		$pids = $jinput -> get('pid', array(0), 'array');
		if ($pids && $pids[0]) {
			$app->setUserState($option.'project', $pids[0]);
		}

		$model=$this->getModel('matches');
		$viewType=$document->getType();
		$view=$this->getView('matches',$viewType);
		$view->setModel($model,true); // true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws, false);
		if ($rid=$jinput -> get('rid',array(0),'array'))
		{
			$app->setUserState($option.'round_id',$rid[0]);
		}
		$roundws=$this->getModel('round');
		$roundws->setId($app->getUserState($option.'round_id'));
		$view->setModel($roundws);

		switch ($this->getTask())
		{
			case 'add'		:	{
				JRequest::setVar('hidemainmenu',1);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','match');
				JRequest::setVar('edit',false);
				$model=$this->getModel('match');
				$viewType=$document->getType();
				$view=$this->getView('match',$viewType);
				$view->setModel($model,true);	// true is for the default model;

				$view->setModel($projectws);

				$model=$this->getModel('match');
				$model->checkout();
			}
			break;

			case 'edit'		:	{
				$model=$this->getModel('match');
				$viewType=$document->getType();
				$view=$this->getView('match',$viewType);
				$view->setModel($model,true);	// true is for the default model;

				$view->setModel($projectws);

				JRequest::setVar('hidemainmenu',1);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','match');
				JRequest::setVar('edit',true);

				// Checkout the project
				$model=$this->getModel('match');
				$model->checkout();
			}
			break;

			case 'massadd'	:	{
				JRequest::setVar('massadd',true);
			}
		}

		parent::display();

	}

	public function editEvents()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$proj=$app->getUserState($option.'project',0);
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($cid);

		$model=$this->getModel('match');

		$viewType=$document->getType();
		$view=$this->getView('match',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editevents');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);

		// Checkout the project
		$model->checkout();
		parent::display();
	}

	public function editEventsbb()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$proj=$app->getUserState($option.'project',0);
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($cid);

		$model=$this->getModel('match');

		$viewType=$document->getType();
		$view=$this->getView('match',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editeventsbb');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);

		// Checkout the project
		$model->checkout();
		if(!parent::display())  {
			$link='index.php?option=com_joomleague&view=positions&task=position.display';
			$this->setRedirect($link);
		}
	}

	public function editstats()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$proj=$app->getUserState($option.'project',0);
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($cid);

		$model=$this->getModel('match');

		$viewType=$document->getType();
		$view=$this->getView('match',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editstats');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);

		// Checkout the project
		$model->checkout();
		parent::display();

	}

	public function editReferees()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$proj=$app->getUserState($option.'project',0);
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($cid);

		$model=$this->getModel('match');

		$viewType=$document->getType();
		$view=$this->getView('match',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editreferees');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);

		// Checkout the project
		$model->checkout();
		parent::display();

	}

	public function editlineup()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$proj=$app->getUserState($option.'project',0);
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($cid);

		$model=$this->getModel('match');

		$viewType=$document->getType();
		$view=$this->getView('match',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editlineup');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);

		// Checkout the match
		$model->checkout();
		parent::display();

	}

	public function saveroster()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		// Check for request forgeries
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');

		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$model=$this->getModel('match');
		$positions=$model->getProjectPositions();
		$staffpositions=$model->getProjectStaffPositions();
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		$post['mid']=$cid[0];
		$post['positions']=$positions;
		$post['staffpositions']=$staffpositions;
		$team=$post['team'];

		$model->updateRoster($post);
		$model->updateStaff($post);

		$viewType=$document->getType();
		$view=$this->getView('match',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editlineup');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);

		// Checkout the match
		$model=$this->getModel('match');
		$model->checkout();
		$link='index.php?option=com_joomleague&close='.$jinput -> get('close', '', 'string').'&tmpl=component&view=match&task=match.editlineup&cid[]='.$cid[0].'&team='.$team;
		$this->setRedirect($link);
	}

	public function saveReferees()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		// Check for request forgeries
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');

		$app = JFactory::getApplication();
		$document = JFactory::getDocument();
		$model=$this->getModel('match');
		$positions=$model->getProjectRefereePositions();
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		$post['mid']=$cid[0];
		$post['positions']=$positions;

		if ($model->updateReferees($post))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_MR');
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_SAVE_MR').'<br />'.$model->getError();
		}

		$viewType=$document->getType();
		$view=$this->getView('match',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		$projectws=$this->getModel('project');
		$projectws->setId($app->getUserState($option.'project',0));
		$view->setModel($projectws);

		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editreferees');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);

		// Checkout the match
		$model=$this->getModel('match');
		$model->checkout();
		$link='index.php?option=com_joomleague&close='.$jinput -> get('close', '', 'string').'&tmpl=component&view=match&task=match.editreferees&cid[]='.$cid[0];

		//echo $link.'<br />';
		$this->setRedirect($link,$msg);
	}

	// save the checked rows inside the round matches list
	public function saveshort()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app 		= JFactory::getApplication();
		$project_id	= $app->getUserState($option.'project',0);
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		JArrayHelper::toInteger($cid);

		$model = $this->getModel('match');
		$project_tz = new DateTimeZone($model->getProject()->timezone);
		for ($x=0; $x < count($cid); $x++)
		{
			$uiDate = $post['match_date'.$cid[$x]];
			$uiTime = $post['match_time'.$cid[$x]];
			$post['match_date'.$cid[$x]] = $this->convertUiDateTimeToMatchDate($uiDate, $uiTime, $project_tz);
			unset($post['match_time'.$cid[$x]]);

			//clear ranking cache
			$cache = JFactory::getCache('joomleague.project'.$project_id);
			$cache->clean();
			if (!$model->save_array($cid[$x],$post,true,$project_id))
			{
				JError::raiseWarning($model->getError());
			}
		}
		$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_MATCH');
		$link='index.php?option=com_joomleague&view=matches&task=match.display';
		$this->setRedirect($link,$msg);
	}

	public function copyfrom()
	{
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$msg='';
		$post=$jinput->getArray();
		$model=$this->getModel('match');
		$add_match_count=$jinput -> get('add_match_count', 0, 'int');
		$round_id=$jinput -> get('rid', 0, 'int');
		$post['project_id']=$app->getUserState($option.'project',0);
		$post['round_id']=$app->getUserState($option.'round_id',0);
		$project_tz = new DateTimeZone($model->getProject()->timezone);

		// Add matches (type=1)
		if ($post['addtype']==1)
		{
			if ($add_match_count > 0) // Only MassAdd a number of new and empty matches
			{
				if (!empty($post['autoPublish'])) // 1=YES Publish new matches
				{
					$post['published']=1;
				}

				$matchNumber= $jinput -> get('firstMatchNumber',1, 'int');
				$roundFound=false;

				if ($projectRounds=$model->getProjectRoundCodes($post['project_id']))
				{
					// convert date and time to utc
					$uiDate = $post['match_date'];
					$uiTime = $post['startTime'];
					$post['match_date'] = $this->convertUiDateTimeToMatchDate($uiDate, $uiTime, $project_tz);

					foreach ($projectRounds AS $projectRound)
					{
						if ($projectRound->id==$post['round_id']){
							$roundFound=true;
						}
						if ($roundFound)
						{
							$post['round_id']=$projectRound->id;
							$post['roundcode']=$projectRound->roundcode;
							for ($x=1; $x <= $add_match_count; $x++)
							{
								if (!empty($post['firstMatchNumber'])) // 1=YES Add continuous match Number to new matches
								{
									$post['match_number']=$matchNumber;
								}

								if ($model->store($post))
								{
									$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ADD_MATCH');
									$matchNumber++;
								}
								else
								{
									$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_ADD_MATCH').$model->getError();
									break;
								}
							}
							if (empty($post['addToRound'])) // 1=YES Add matches to all rounds
							{
								break;
							}
						}
					}
				}
			}
		}
		// Copy matches (type=2)
		if ($post['addtype']==2)// Copy or mirror new matches from a selected existing round
		{
			if ($matches=$model->getRoundMatches($round_id))
			{
				// convert date and time to utc
				$uiDate = $post['date'];
				$uiTime = $post['startTime'];
				$post['match_date'] = $this->convertUiDateTimeToMatchDate($uiDate, $uiTime, $project_tz);

				foreach($matches as $match)
				{
					//aufpassen,was uebernommen werden soll und welche daten durch die aus der post ueberschrieben werden muessen
					//manche daten muessen auf null gesetzt werden

 					$dmatch['match_date'] = $post['match_date'];

					if ($post['mirror'] == '1')
					{
						$dmatch['projectteam1_id']	= $match->projectteam2_id;
						$dmatch['projectteam2_id']	= $match->projectteam1_id;
					}
					else
					{
						$dmatch['projectteam1_id']	= $match->projectteam1_id;
						$dmatch['projectteam2_id']	= $match->projectteam2_id;
					}
					$dmatch['project_id']	= $post['project_id'];
					$dmatch['round_id']		= $post['round_id'];
					if ($post['start_match_number'] != '')
					{
						$dmatch['match_number']=$post['start_match_number'];
						$post['start_match_number']++;
					}

					if ($model->store($dmatch))
					{
						$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_COPY_MATCH');
					}
					else
					{
						$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_COPY_MATCH').$model->getError();
					}
				}
			}
			else
			{
				$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_COPY_MATCH2').$model->getError();
			}
		}
		//echo $msg;
		$link='index.php?option=com_joomleague&view=matches&task=match.display';
		$this->setRedirect($link,$msg);
	}

	//	add a match to round
	public function addmatch()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$post=$jinput->getArray();
		$post['project_id']=$app->getUserState($option.'project',0);
		$post['round_id']=$app->getUserState($option.'round_id',0);
		//get the home team standard playground
		$tblProjectHomeTeam = JTable::getInstance('Projectteam', 'table');
		$tblProjectHomeTeam->load($post['projectteam1_id']);
		$standard_playground_id = (!empty($tblProjectHomeTeam->standard_playground) && $tblProjectHomeTeam->standard_playground > 0) ? $tblProjectHomeTeam->standard_playground : null;
		$post['playground_id'] = $standard_playground_id;

		// convert date and time to utc
		$model=$this->getModel('match');
		list($uiDate, $uiTime) = explode(" ", $post['match_date']);
		$project_tz = new DateTimeZone($model->getProject()->timezone);
		$post['match_date'] = $this->convertUiDateTimeToMatchDate($uiDate, $uiTime, $project_tz);

		if ($model->store($post))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ADD_MATCH');
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_ADD_MATCH').$model->getError();
		}
		$link='index.php?option=com_joomleague&view=matches&task=match.display';
		$this->setRedirect($link,$msg);
	}

	public function remove()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$project_id=$app->getUserState($option.'project',0);
		$user = JFactory::getUser();
		$cid=$jinput -> get('cid',array(),'array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){
			JError::raiseError(500,JText::_('COM_JOOMLEAGUE_GLOBAL_SELECT_TO_DELETE'));
		}
		// Access checks.
		foreach ($cid as $i => $id)
		{
			if (!$user->authorise('core.admin', 'com_joomleague') ||
				!$user->authorise('core.admin', 'com_joomleague.project.'.(int) $project_id) ||
				!$user->authorise('core.delete', 'com_joomleague.match.'.(int) $id))
			{
				// Prune items that you can't delete.
				unset($cid[$i]);
				JError::raiseNotice(403, JText::_('JERROR_CORE_DELETE_NOT_PERMITTED'));
			}
		}
		$model=$this->getModel('match');
		if (!$model->delete($cid)){
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect('index.php?option=com_joomleague&task=match.display&view=matches');
	}

	public function cancel()
	{
		// Checkin the project
		$model=$this->getModel('matches');
		//$model->checkin();
		$this->setRedirect('index.php?option=com_joomleague&task=match.display&view=matches');
	}

	public function publish()
	{
		$this->view_list = 'matches&task=match.display';
		parent::publish();
	}

	public function unpublish()
	{
		$this->view_list = 'matches&task=match.display';
		parent::unpublish();
	}

	public function savedetails()
	{
		// Check for request forgeries
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');

		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app 		= JFactory::getApplication();
		$project_id = $app->getUserState($option.'project',0);

		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		$summary	= $jinput -> get('summary','','string');
		$preview	= $jinput -> get('preview','','string');
		$post['id']	= (int)$cid[0];
		$post['summary']=$summary;
		$post['preview']=$preview;
		$model=$this->getModel('match');
		if ($returnid=$model->savedetails($post))
		{
			//clear ranking cache
			$cache = JFactory::getCache('joomleague.project'.$project_id);
			$cache->clean();

			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_MD');
			$type='message';
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_SAVED_MD').': '.$model->getError();
			$type='error';
		}

		$this->setRedirect('index.php?option=com_joomleague&close='.$jinput -> get('close', '', 'string').'&tmpl=component&task=match.edit&cid[]='.$cid[0],$msg,$type);
	}

	public function saveevent()
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');

		// Check for request forgeries
		JSession::checkToken("GET") or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');

		$app = JFactory::getApplication();
		$data = array();
		$data['teamplayer_id']	= $jinput -> get('teamplayer_id', 0, 'int');
		$data['projectteam_id']	= $jinput -> get('projectteam_id', 0, 'int');
		$data['event_type_id']	= $jinput -> get('event_type_id', 0, 'int');
		$data['event_time']		= $jinput -> get('event_time', '', 'string');
		$data['match_id']		= $jinput -> get('match_id', 0, 'int');
		$data['event_sum']		= $jinput -> get('event_sum', '', 'string');
		$data['notice']			= $jinput -> get('notice', '', 'string');
		$data['notes']			= $jinput -> get('notes', '', 'string');

		$model=$this->getModel('match');
		$project_id=$app->getUserState($option.'project',0);
		if (!$result=$model->saveevent($data, $project_id)) {
			$result="0"."\n".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_SAVED_EVENT').': '.$model->getError();
		} else {
			$result=$jinput -> get('rowid',0, 'int').'\n'.JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_EVENT');
		}
		echo json_encode($result);
		JFactory::getApplication()->close();
	}

	public function savesubst()
	{
		// Check for request forgeries
		JSession::checkToken("GET") or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$data = array();
		$data['in'] 					= $jinput -> get('in', 0, 'int');
		$data['out'] 					= $jinput -> get('out', 0, 'int');
		$data['matchid'] 				= $jinput -> get('matchid', 0, 'int');
		$data['in_out_time'] 			= $jinput -> get('in_out_time', '', 'string');
		$data['project_position_id'] 	= $jinput -> get('project_position_id', 0, 'int');

		$model=$this->getModel('match');
		if (!$result=$model->savesubstitution($data)){
			$result="0"."\n".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_SAVED_SUBST').': '.$model->getError();
		} else {
			$result=$jinput -> get('rowid',0, 'int').'\n'.JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_SAVED_SUBST');
		}
		echo json_encode($result);
		JFactory::getApplication()->close();
	}

	public function removeSubst()
	{
		JSession::checkToken("GET") or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$substid = $jinput -> get('substid',0, 'int');
		$model=$this->getModel('match');
		if (!$result=$model->deleteSubstitution($substid))
		{
			$result="0"."\n".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_REMOVE_SUBST').': '.$model->getError();
		}
		else
		{
			$result="1"."\n".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_REMOVE_SUBST');
		}
		echo json_encode($result);
		JFactory::getApplication()->close();
	}

	// save the checked rows inside matcheventsbb list
	public function saveeventbb()
	{
		// Check for request forgeries
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app = JFactory::getApplication();
		$post=$jinput->getArray();
		$cid = $jinput -> get('cid', array(0), 'array');
		$model=$this->getModel('match');
		$project_id=$app->getUserState($option.'project',0);
		if ($model->saveeventbb($post,$project_id))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_UPDATE_EVENTS');
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_UPDATE_EVENTS').$model->getError();
		}
		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editeventsbb');
		JRequest::setVar('view','match');
		JRequest::setVar('edit',true);
		$link='index.php?option=com_joomleague&close='.$jinput -> get('close', '', 'string').'&view=match&task=match.editeventsbb&cid[]='.$cid[0];
		$this->setRedirect($link, $msg);
	}


	/**
	 * save the match stats
	 */
	public function savestats()
	{
		// Check for request forgeries
		JSession::checkToken() or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');
		$post=$jinput->getArray();
		$cid = $jinput -> get('match_id', 0, 'int');
		$model=$this->getModel('match');
		if ($model->savestats($post))
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_UPDATE_STATS');
		}
		else
		{
			$msg=JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_UPDATE_STATS').$model->getError();
		}
		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','editstats');
		JRequest::setVar('view','match');
		JRequest::setVar('tmpl','component');
		JRequest::setVar('cid',array($post['match_id']));
		JRequest::setVar('msg',$msg);
		$link='index.php?option=com_joomleague&close='.$jinput -> get('close','', 'string').'&tmpl=component&view=match&task=match.editstats&cid[]='.$cid;
		$this->setRedirect($link, $msg);
	}

	public function removeEvent()
	{
		// Check for request forgeries
		JSession::checkToken("GET") or die('COM_JOOMLEAGUE_GLOBAL_INVALID_TOKEN');

		$event_id=$jinput -> get('event_id', 0, 'int');
		$model=$this->getModel('match');
		if (!$result=$model->deleteevent($event_id))
		{
			$result="0"."\n".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_ERROR_DELETE_EVENTS').': '.$model->getError();
		}
		else
		{
			$result="1"."\n".JText::_('COM_JOOMLEAGUE_ADMIN_MATCH_CTRL_DELETE_EVENTS');
		}
		echo json_encode($result);
		JFactory::getApplication()->close();
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
	public function getModel($name = 'Match', $prefix = 'JoomleagueModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	private function convertUiDateTimeToMatchDate($uiDate, $uiTime, $timezone)
	{
		$format = JText::_('COM_JOOMLEAGUE_ADMIN_MATCHES_DATE_FORMAT');
		$dateStr = $uiDate;
		if (!empty($uiTime))
		{
			$format  .= ' H:i';

			if(strpos($uiTime,":")!==false)
			{
				$dateStr .= ' '.$uiTime;
			}
			// to support short time inputs
			// for example 2158 is used instead of 21:58
			else
			{
				$dateStr .= ' '.substr($uiTime, 0, -2) . ':' . substr($uiTime, -2);
			}
		}
		$timestamp = DateTime::createFromFormat($format, $dateStr, $timezone);
		$timestamp->setTimezone(new DateTimeZone('UTC'));
		return $timestamp->format('Y-m-d H:i:s');
	}
}
?>
