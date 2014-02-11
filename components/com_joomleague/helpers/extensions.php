<?php
/**
 * @see JLGView
 * @see JLGModel
 * @author		Wolfgang Pinitsch <andone@mfga.at>
 * @copyright	Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die;
$app			= JFactory::getApplication();
$jinput = JFactory::getApplication() -> input;
$arrExtensions 	= JoomleagueHelper::getExtensions($jinput -> get('p',0,'int'));
$model_pathes[]	= array();
$view_pathes[]	= array();
$lang 			= JFactory::getLanguage();
$type 			= '';
$task 			= '';
$jinput = JFactory::getApplication() -> input;
$command = $jinput -> get('task', 'display', 'string');

// Check for array format.
$filter = JFilterInput::getInstance();

if (is_array($command))
{
	$command = $filter->clean(array_pop(array_keys($command)), 'cmd');
}
else
{
	$command = $filter->clean($command, 'cmd');
}

// Check for a controller.task command.
if (strpos($command, '.') !== false)
{
	// Explode the controller.task command.
	list ($type, $task) = explode('.', $command);
}

for ($e = 0; $e < count($arrExtensions); $e++)
{
	$extension = $arrExtensions[$e];
	$extensionpath = JLG_PATH_SITE.DIRECTORY_SEPARATOR.'extensions'.DIRECTORY_SEPARATOR.$extension;
	// include file named after the extension for specific includes for examples
	if ( file_exists( $extensionpath.DIRECTORY_SEPARATOR.$extension.'.php') )  {
		//e.g example.php
		require_once $extensionpath.DIRECTORY_SEPARATOR.$extension.'.php';
	}
	if($app->isAdmin()) {
		$base_path = $extensionpath.DIRECTORY_SEPARATOR.'admin';
		// language file
		$lang->load('com_joomleague_'.$extension, $base_path);
	} else {
		$base_path = $extensionpath;
		//language file
		$lang->load('com_joomleague_'.$extension, $base_path);
	}

	//set the base_path to the extension controllers directory
	if(is_dir($base_path))
	{
		$params = array('base_path'=>$base_path);
	}
	else
	{
		$params = array();
	}

	// own controllers currently not supported in 2.0
	if (!file_exists($base_path.DIRECTORY_SEPARATOR.'controller.php') )
	{
		if($type!=$extension) {
			$params = array();
		}
		$extension = "joomleague";
	}
	elseif (!file_exists($base_path.DIRECTORY_SEPARATOR.$extension.'.php'))
	{
		if($type!=$extension) {
			$params = array();
		}
		$extension = "joomleague";
	}

	try
	{
		$controller = JLGController::getInstance(ucfirst($extension), $params);
	}
	catch (Exception $exc)
	{
		//fallback if no extensions controller has been initialized
		$controller	= JLGController::getInstance('joomleague');
	}

	if (is_dir($base_path.DIRECTORY_SEPARATOR.'models')) {
		$model_pathes[] = $base_path.DIRECTORY_SEPARATOR.'models';
	}

	if (is_dir($base_path.DIRECTORY_SEPARATOR.'views')) {
		$view_pathes[] = $base_path.DIRECTORY_SEPARATOR.'views';
	}
}

if(is_null($controller) && !($controller instanceof JLGController)) {
	//fallback if no extensions controller has been initialized
	$controller	= JLGController::getInstance('joomleague');
}

foreach ($model_pathes as $path)
{
	if(!empty($path))
	{
		$controller->addModelPath($path, 'joomleagueModel');
	}
}

foreach ($view_pathes as $path)
{
	if(!empty($path))
	{
		$controller->addViewPath($path, 'joomleagueView');
	}
}
