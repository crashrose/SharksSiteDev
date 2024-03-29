<?php
/**
 * @copyright	Copyright (C) 2006-2013 joomleague.at. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
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
 * @author	Zoltan Koteles
 * @package JoomLeague
 * @since	1.5.0a
 */
class JoomleagueViewJLXMLExports extends JLGView
{
	function display($tpl=null)
	{
		// Set toolbar items for the page
		JToolBarHelper::title(JText::_('JoomLeague XML Export'),'generic.png');

		$db = JFactory::getDbo();

		parent::display($tpl);
	}

}
?>