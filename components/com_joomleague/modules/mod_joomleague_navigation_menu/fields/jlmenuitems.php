<?php
/**
 * @copyright	Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.filesystem.folder');
JFormHelper::loadFieldClass('list');

/**
 * Session form field class
 */
class JFormFieldJLMenuItems extends JFormFieldList
{
	/**
	 * field type
	 * @var string
	 */
	public $type = 'JLMenuItems';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array(
				JHtml::_('select.option', '', JText::_('JNONE')),
				JHtml::_('select.option', 'separator', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_SEPARATOR')),
				JHtml::_('select.option', 'calendar', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_CALENDAR')),
				JHtml::_('select.option', 'curve', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_CURVE')),
				JHtml::_('select.option', 'eventsranking', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_eventsranking')),
				JHtml::_('select.option', 'matrix', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_matrix')),
				JHtml::_('select.option', 'ranking', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_TABLE')),
				JHtml::_('select.option', 'referees', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_referees')),
				JHtml::_('select.option', 'results', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_RESULTS')),
				JHtml::_('select.option', 'resultsmatrix', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_resultsmatrix')),
				JHtml::_('select.option', 'resultsranking', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_TABLE_AND_RESULTS')),
				JHtml::_('select.option', 'roster', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_roster')),
				JHtml::_('select.option', 'stats', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_stats')),
				JHtml::_('select.option', 'statsranking', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_statsranking')),
				JHtml::_('select.option', 'teaminfo', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_teaminfo')),
				JHtml::_('select.option', 'teamplan', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_teamplan')),
				JHtml::_('select.option', 'teamstats', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_teamstats')),
				JHtml::_('select.option', 'treetonode', JText::_('MODULE_JOOMLEAGUE_NAVIGATION_NAVSELECT_treetonode')),
				);
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
