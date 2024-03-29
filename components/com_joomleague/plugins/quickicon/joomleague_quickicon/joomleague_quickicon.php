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

defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * JoomLeague Quick Icon Plugin
 *
 * @package		JoomLeague
 * @subpackage	Quickicon.JoomLeague
 * @since		2.5
 */
class plgQuickiconJoomLeague_Quickicon extends JPlugin
{
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onGetIcons($context)
	{
		$text = $this->params->get('displayedtext');
		if(empty($text)) $text = JText::_('COM_JOOMLEAGUE');

		return array(array(
			'link' => 'index.php?option=com_joomleague',
			'image' => '../../../components/com_joomleague/assets/images/joomleague-48.png',
			'text' => $text,
			'id' => 'plg_quickicon_joomleague'
		));
	}
}
?>
