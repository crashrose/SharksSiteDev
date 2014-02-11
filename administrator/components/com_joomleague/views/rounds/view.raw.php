<?php

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die();

jimport( 'joomla.application.component.view' );

/**
 * AJAX View class for the Joomleague component
 *
 * @static
 * @package	Joomleague
 * @since	1.5
 */
class JoomleagueViewRounds extends JLGView
{
	/**
	* view AJAX display method
	* @return void
	**/
	function display( $tpl = null )
	{
		if ($this->getLayout() == 'jsonoptions') {
			return $this->_displayJsonOptions();
		}
		return;
	}

	/**
	* view AJAX display method
	* @return void
	**/
	function _displayJsonOptions( $tpl = null )
	{
		$jinput = JFactory::getApplication() -> input;
		$p = $jinput -> get('p','','string');
		// Get some data from the model
		$db	= JFactory::getDbo();
		$db->setQuery(	"	SELECT CASE WHEN CHAR_LENGTH(r.alias) THEN CONCAT_WS(':', r.roundcode, r.alias) ELSE r.roundcode END AS value,
									r.name AS text
							FROM #__joomleague_round AS r
							WHERE r.project_id = " . $p . "
							ORDER BY r.roundcode" );

		echo '[';
		foreach ((array)$db->loadObjectList() as $option)
		{
			echo "{ value: '$option->value', text: '$option->text'},";
		}
		echo ']';
	}
}
?>