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

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.application.component.controller');

/**
 * Modifies JController to take extensions into account
 *
 * @author julien vonthron
 * @since	1.5
 *
*/
class JLGController extends JControllerLegacy
{

	/**
	 * Overrides method to first lookup into potential extension for the model.
	 * @since	1.5
	 */
	protected function createModel($name, $prefix = '', $config = array())
	{
		// Clean the model name
		$modelName	 = preg_replace( '/[^A-Z0-9_]/i', '', $name );
		$classPrefix = preg_replace( '/[^A-Z0-9_]/i', '', $prefix );

		$result = JLGModel::getInstance($modelName, $classPrefix, $config);

		return $result;
	}

	/**
	 * Overrides method to first lookup into potential extension for the view.
	 * @since	1.5
	 */
	protected function createView($name, $prefix = '', $type = '', $config = array() )
	{
		$jinput = JFactory::getApplication() -> input;
		$extensions=JoomleagueHelper::getExtensions($jinput -> get('p', 0, 'int'));

		foreach ($extensions as $e => $extension)
		{
			$result = null;

			// Clean the view name
			$viewName	 = preg_replace( '/[^A-Z0-9_]/i', '', $name );
			$classPrefix = preg_replace( '/[^A-Z0-9_]/i', '', $prefix );
			$viewType	 = preg_replace( '/[^A-Z0-9_]/i', '', $type );

			// Build the view class name
			$viewClassExtension = $classPrefix . $viewName . ucfirst($extension);

			if (!class_exists($viewClassExtension))
			{
				jimport('joomla.filesystem.path' );
				$path = JPath::find(
						$this->paths['view'],
						$this->createFileName('view', array( 'name' => $viewName, 'type' => $viewType)));
				if ($path)
				{
					require_once $path;

					if (class_exists($viewClassExtension))
					{
						$result = new $viewClassExtension($config);

						return $result;
					}
				}
			}
			else
			{
				$result = new $viewClassExtension($config);

				return $result;
			}
		}

		// Still here ? Then the extension doesn't override this, use regular view
		return parent::createView($name, $prefix, $type, $config);
	}
}
