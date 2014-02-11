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

/**
 * this file perform the basic init and includes for joomleague
 */

defined('_JEXEC') or die('Restricted access');

if (version_compare(phpversion(), '5.3.0', '<')===true) {
	echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;"><div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;"><h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">'.JText::_("COM_JOOMLEAGUE_INVALID_PHP1").'</h3></div>'.JText::_("COM_JOOMLEAGUE_INVALID_PHP2").'</div>';
	return;
}

if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}
define('JLG_PATH_SITE',  JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joomleague');
define('JLG_PATH_ADMIN', JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joomleague');
require_once( JLG_PATH_ADMIN .DIRECTORY_SEPARATOR. 'defines.php' );

require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'jlgcontroller.php'  );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'jlgcontrolleradmin.php'  );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'jlgmodel.php'  );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'jlgview.php'  );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'jlglanguage.php'  );

require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php' );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'countries.php' );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'extraparams.php' );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'ranking.php' );
require_once( JLG_PATH_SITE.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'html.php' );


require_once( JLG_PATH_ADMIN.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'joomleaguehelper.php' );
require_once( JLG_PATH_ADMIN.DIRECTORY_SEPARATOR.'tables'.DIRECTORY_SEPARATOR.'jltable.php' );

JTable::addIncludePath( JLG_PATH_ADMIN.DIRECTORY_SEPARATOR.'tables' );

require_once (JLG_PATH_ADMIN.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'plugins.php');
$jinput = JFactory::getApplication() -> input;
$task = $jinput -> get('task', '', 'string');
$option = $jinput -> get('option', '', 'string');
if($task != '' && $option == 'com_joomleague')  {
	if (!JFactory::getUser()->authorise($task, 'com_joomleague')) {
		//display the task which is not handled by the access.xml
		return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR').' Task: '  .$task);
	}
}
