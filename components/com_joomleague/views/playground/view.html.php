<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JoomleagueViewPlayground extends JLGView
{
	function display( $tpl = null )
	{
		// Get a refrence of the page instance in joomla
		$document= JFactory::getDocument();

		// Set page title
		$document->setTitle( JText::_( 'COM_JOOMLEAGUE_PLAYGROUND_TITLE' ) );

		$model 			= $this->getModel();
		$address_string = $model->getAddressString();
		$map_config		= $model->getMapConfig();
		$config 		= $model->getTemplateConfig($this->getName());
		$games 			= $model->getNextGames(0, $config['show_referee']);
		$gamesteams 	= $model->getTeamsFromMatches( $games );
		$playground 	= $model->getPlayground() ;
		$teams 			= $model->getTeams();
		$project		= $model->getProject();
		$overallconfig	= $model->getOverallConfig();
		
		$this->assignRef( 'project', 		$project);
		$this->assignRef( 'overallconfig',  $overallconfig);
		$this->assignRef( 'config', 		$config );
		$this->assignRef( 'playground',  	$playground);
		$this->assignRef( 'teams', 			$teams );
		$this->assignRef( 'games', 			$games );
		$this->assignRef( 'gamesteams', 	$gamesteams );

		$this->assignRef( 'address_string', $address_string);
		$this->assignRef( 'mapconfig',		$map_config ); // Loads the project-template -settings for the GoogleMap

		$extended = $this->getExtended($this->playground->extended, 'playground');
		$this->assignRef( 'extended', $extended );
		// Set page title
		$pageTitle = JText::_( 'COM_JOOMLEAGUE_PLAYGROUND_PAGE_TITLE' );
		if ( isset( $this->playground->name ) )
		{
			$pageTitle .= ' - ' . $this->playground->name;
		}
		$document->setTitle( $pageTitle );
		$document->addCustomTag( '<meta property="og:title" content="' . $this->playground->name .'"/>' );
		$document->addCustomTag( '<meta property="og:street-address" content="' . $this->address_string .'"/>' );
		parent::display( $tpl );
	}
}
?>