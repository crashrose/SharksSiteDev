<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JoomleagueViewProjectHeading extends JLGView
{
    function display( $tpl = null )
    {
    	$jinput = JFactory::getApplication() -> input;
        $model = $this->getModel();
        $overallconfig = $model->getOverallConfig();
        $project = $model->getProject();
        $this->assignRef('project', $project);
        $division = $model->getDivision($jinput -> get('division',0,'int'));
        $this->assignRef( 'division', $division );
        $this->assignRef( 'overallconfig',  $overallconfig);
        parent::display($tpl);
    }
}
?>