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

class JoomleagueControllerMatchReport extends JoomleagueController
{
    public function display($cachable = false, $urlparams = false)
    {
        // Get the view name from the query string
        $jinput = JFactory::getApplication() -> input;
		$viewName = $jinput -> get('view', 'matchreport', 'string' );

        // Get the view
        $view = $this->getView( $viewName );

        // Get the joomleague model
        $jl = $this->getModel( "joomleague", "JoomleagueModel" );
        $jl->set( "_name", "joomleague" );
        if (!JError::isError( $jl ) )
        {
            $view->setModel ( $jl );
        }

        // Get the joomleague model
        $sr = $this->getModel( "matchreport", "JoomleagueModel" );
        $sr->set( "_name", "matchreport" );
        if (!JError::isError( $sr ) )
        {
            $view->setModel ( $sr );
        }

        $this->showprojectheading();
        $jinput = JFactory::getApplication() -> input;
        if ( $jinput -> get('mid', 0, 'int') == 0 )
        {
            $view->showreports();
        }
        else
        {
            $view->display();
        }
        $this->showbackbutton();
        $this->showfooter();
    }
}
