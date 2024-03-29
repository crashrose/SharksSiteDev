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

jimport( 'joomla.application.component.view');

class JLGView extends JViewLegacy
{
	/**
	 * Sets an entire array of search paths for templates or resources.
	 *
	 * @access protected
	 * @param string $type The type of path to set, typically 'template'.
	 * @param string|array $path The new set of search paths.  If null or
	 * false, resets to the current directory only.
	 */
	function _setPath($type, $path)
	{
		$option     = JApplicationHelper::getComponentName();
		$app		= JFactory::getApplication();
		$jinput = JFactory::getApplication() -> input;
		$p = $jinput -> get('p', 0, 'int');
		$extensions	= JoomleagueHelper::getExtensions($p);
		if (!count($extensions))
		{
			return parent::_setPath($type, $path);
		}

		// clear out the prior search dirs
		$this->_path[$type] = array();

		// actually add the user-specified directories
		$this->_addPath($type, $path);

		// add extensions paths
		if (strtolower($type) == 'template')
		{
			foreach ($extensions as $e => $extension)
			{
				$JLGPATH_EXTENSION =  JPATH_COMPONENT_SITE .DIRECTORY_SEPARATOR. 'extensions' .DIRECTORY_SEPARATOR. $extension;

				// set the alternative template search dir
				if (isset($app))
				{
					if ($app->isAdmin()) {
						$this->_addPath('template', $JLGPATH_EXTENSION .DIRECTORY_SEPARATOR. 'admin' .DIRECTORY_SEPARATOR. 'views' .DIRECTORY_SEPARATOR.$this->getName().DIRECTORY_SEPARATOR.'tmpl');
					}
					else {
						$this->_addPath('template', $JLGPATH_EXTENSION .DIRECTORY_SEPARATOR. 'views' .DIRECTORY_SEPARATOR.$this->getName().DIRECTORY_SEPARATOR.'tmpl');
					}

					// always add the fallback directories as last resort
					$option = preg_replace('/[^A-Z0-9_\.-]/i', '', $option);
					$fallback = JPATH_THEMES .DIRECTORY_SEPARATOR. $app->getTemplate() . '/html/' . $option .DIRECTORY_SEPARATOR. $extension .DIRECTORY_SEPARATOR. $this->getName();
					$this->_addPath('template', $fallback);
				}
			}
		}
	}

	public function display($tpl = null )
	{
		$jinput = JFactory::getApplication() -> input;
		$option = $jinput -> get('option', '', 'string');
		$app		= JFactory::getApplication();
		$document	= JFactory::getDocument();
		$version 	= urlencode(JoomleagueHelper::getVersion());
		//support for global client side lang res
		JHtml::_('behavior.formvalidation');
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');
		$lang 		= new JLGLanguage;
		$strings 		= $lang->getStrings();

		foreach ($strings as $key => $value) {
			if($app->isAdmin()) {
				if(strpos($key, 'COM_JOOMLEAGUE_ADMIN_'.strtoupper($this->getName()).'_CSJS') !== false) {
					JText::script($key, true);
				}
			} else {
				if(strpos($key, 'COM_JOOMLEAGUE_'.strtoupper($this->getName()).'_CSJS_')  !== false) {
					JText::script($key, true);
				}
			}
		}
		//General Joomleague CSS include
		$file = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'joomleague.css';
		if(file_exists(JPath::clean($file))) {
			$document->addStyleSheet( $this->baseurl . '/components/'.$option.'/assets/css/joomleague.css?v=' . $version );
		}
		//Genereal CSS include per view
		$file = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$this->getName().'.css';
		if(file_exists(JPath::clean($file))) {
			//add css file
			$document->addStyleSheet(  $this->baseurl . '/components/'.$option.'/assets/css/'.$this->getName().'.css?v=' . $version );
		}
		//General Joomleague JS include
		$file = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'joomleague.js';
		if(file_exists(JPath::clean($file))) {
			$js = $this->baseurl . '/components/'.$option.'/assets/js/joomleague.js?v=' . $version;
			$document->addScript($js);
		}
		//General JS include per view
		$file = JPATH_COMPONENT.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.$this->getName().'.js';
		if(file_exists(JPath::clean($file))) {
			$js = $this->baseurl . '/components/'.$option.'/assets/js/'.$this->getName().'.js?v=' . $version;
			$document->addScript($js);
		}


		//extension management
		$extensions=JoomleagueHelper::getExtensions($jinput -> get('p', 0, 'int'));

		foreach ($extensions as $e => $extension) {
			$JLGPATH_EXTENSION =  JPATH_COMPONENT_SITE .DIRECTORY_SEPARATOR. 'extensions' .DIRECTORY_SEPARATOR. $extension;

			//General extension CSS include
			$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$extension.'.css';
			if(file_exists(JPath::clean($file))) {
				$document->addStyleSheet(  $this->baseurl . '/components/'.$option.'/extensions/' . $extension . '/assets/css/' . $extension . '.css?v=' . $version );
			}
			//CSS override
			$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$this->getName().'.css';
			if(file_exists(JPath::clean($file))) {
				//add css file
				$document->addStyleSheet(  $this->baseurl . '/components/'.$option.'/extensions/' . $extension . '/assets/css/'.$this->getName().'.css?v=' . $version );
			}
			//General extension JS include
			$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.$extension.'.js';
			if(file_exists(JPath::clean($file))) {
				//add js file
				$document->addScript(  $this->baseurl . '/components/'.$option.'/extensions/' . $extension . '/assets/js/' . $extension . '.js?v=' . $version );
			}
			//JS override
			$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.$this->getName().'.js';
			if(file_exists(JPath::clean($file))) {
				//add js file
				$document->addScript(  $this->baseurl . '/components/'.$option.'/extensions/' . $extension . '/assets/js/'.$this->getName().'.js?v=' . $version );
			}
			if($app->isAdmin()) {
				$JLGPATH_EXTENSION =  JPATH_COMPONENT_SITE .DIRECTORY_SEPARATOR. 'extensions' .DIRECTORY_SEPARATOR. $extension .DIRECTORY_SEPARATOR. 'admin';

				//General extension CSS include
				$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$extension.'.css';
				if(file_exists(JPath::clean($file))) {
					$document->addStyleSheet(  $this->baseurl . '/../components/'.$option.'/extensions/' . $extension . '/admin/assets/css/' . $extension . '.css?v=' . $version );
				}
				//CSS override
				$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$this->getName().'.css';
				if(file_exists(JPath::clean($file))) {
					//add css file
					$document->addStyleSheet(  $this->baseurl . '/../components/'.$option.'/extensions/' . $extension . '/admin/assets/css/'.$this->getName().'.css?v=' . $version );
				}
				//General extension JS include
				$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.$extension.'.js';
				if(file_exists(JPath::clean($file))) {
					//add js file
					$document->addScript(  $this->baseurl . '/../components/'.$option.'/extensions/' . $extension . '/admin/assets/js/' . $extension . '.js?v=' . $version );
				}
				//JS override
				$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.$this->getName().'.js';
				if(file_exists(JPath::clean($file))) {
					//add js file
					$document->addScript(  $this->baseurl . '/../components/'.$option.'/extensions/' . $extension . '/admin/assets/js/'.$this->getName().'.js?v=' . $version);
				}
			}
		}
		parent::display( $tpl );
	}

	/**
	 * support for extensions which can overload extended data
	 * @param string $data
	 * @param string $file
	 * @return object
	 */
	function getExtended($data='', $file, $format='ini')
	{
		$jinput = JFactory::getApplication() -> input;
		$p = $jinput -> get('p', 0, 'int');
		$xmlfile=JLG_PATH_ADMIN.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'extended'.DIRECTORY_SEPARATOR.$file.'.xml';
		//extension management
		$extensions = JoomleagueHelper::getExtensions($p);
		foreach ($extensions as $e => $extension) {
			$JLGPATH_EXTENSION = JPATH_COMPONENT_SITE.DIRECTORY_SEPARATOR.'extensions'.DIRECTORY_SEPARATOR.$extension.DIRECTORY_SEPARATOR.'admin';
			//General extension extended xml
			$file = $JLGPATH_EXTENSION.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'extended'.DIRECTORY_SEPARATOR.$file.'.xml';
			if(file_exists(JPath::clean($file))) {
				$xmlfile = $file;
				break; //first extension file will win
			}
		}
		/*
		 * extended data
		*/
		$jRegistry = new JRegistry;
		$jRegistry->loadString($data, $format);
		$extended = JForm::getInstance('extended', $xmlfile,
				array('control'=> 'extended'),
				false, '/config');
		$extended->bind($jRegistry);
		return $extended;
	}
}
