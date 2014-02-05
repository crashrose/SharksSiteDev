<?php
/**
 * @version	 $Id: mod_joomleague_statranking.php 4905 2010-01-30 08:51:33Z and_one $
 * @package	 Joomla
 * @subpackage  Joomleague stats module
 * @copyright	Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license	 GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// get helper
require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joomleague'.DIRECTORY_SEPARATOR.'joomleague.core.php');

$list = modJLGStatHelper::getData($params);

$document = JFactory::getDocument();
//add css file
$document->addStyleSheet(JUri::base().'modules/mod_joomleague_statranking/css/mod_joomleague_statranking.css');

require(JModuleHelper::getLayoutPath('mod_joomleague_statranking'));