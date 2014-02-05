<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JoomleagueViewTeamInfo extends JLGView
{
	function display( $tpl = null )
	{
		// Get a reference of the page instance in joomla
		$document	= JFactory::getDocument();
		$model		= $this->getModel();
		$config		= $model->getTemplateConfig( $this->getName() );
		$project	= $model->getProject();
		$this->assignRef( 'project', $project );
		$isEditor = $model->hasEditPermission('projectteam.edit');

		if ( isset($this->project->id) )
		{
			$overallconfig = $model->getOverallConfig();
			$this->assignRef( 'overallconfig',  $overallconfig);
			$this->assignRef( 'config', $config );
			$team = $model->getTeamByProject();
			$this->assignRef( 'team',  $team );

			$club = $model->getClub() ;
			$this->assignRef( 'club', $club);
			$seasons = $model->getSeasons( $config );
			$this->assignRef( 'seasons', $seasons );
			$this->assignRef('showediticon', $isEditor);
			$this->assignRef('projectteamid', $model->projectteamid);

			$trainingData = $model->getTrainigData($this->project->id);
			$this->assignRef( 'trainingData', $trainingData );

			$daysOfWeek=array(
				1 => JText::_('COM_JOOMLEAGUE_GLOBAL_MONDAY'),
				2 => JText::_('COM_JOOMLEAGUE_GLOBAL_TUESDAY'),
				3 => JText::_('COM_JOOMLEAGUE_GLOBAL_WEDNESDAY'),
				4 => JText::_('COM_JOOMLEAGUE_GLOBAL_THURSDAY'),
				5 => JText::_('COM_JOOMLEAGUE_GLOBAL_FRIDAY'),
				6 => JText::_('COM_JOOMLEAGUE_GLOBAL_SATURDAY'),
				7 => JText::_('COM_JOOMLEAGUE_GLOBAL_SUNDAY')
			);
			$this->assignRef( 'daysOfWeek', $daysOfWeek );
		}

		$extended = $this->getExtended($team->teamextended, 'team');
		$this->assignRef( 'extended', $extended );

		// Set page title
		$pageTitle = JText::_( 'COM_JOOMLEAGUE_TEAMINFO_PAGE_TITLE' );
		if ( isset( $this->team ) )
		{
			$pageTitle .= ': ' . $this->team->tname;
		}
		$document->setTitle( $pageTitle );

		parent::display( $tpl );
	}
}
?>