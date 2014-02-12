<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
//jimport('joomla.plugin.plugin');
class plgSystemYt extends JPlugin {
	/* This event is triggered after the framework has loaded and the application initialise method has been called. */
	function onAfterInitialise() {
		global $app;
		// Include defines
		include_once dirname(__FILE__) . '/includes/core/defines.php';
		// Include function less
		include_once YT_INCLUDES_PATH.J_SEPARATOR.'core'.J_SEPARATOR.'less.php';
		// Include function resize image
		include_once YT_INCLUDES_PATH.J_SEPARATOR.'libs'.J_SEPARATOR.'resize'.J_SEPARATOR.'tool.php';
		// Include function template, render xml
		if($app->isSite()){
			include_once(YT_INCLUDES_PATH.J_SEPARATOR.'site'.J_SEPARATOR.'lib'.J_SEPARATOR.'yt_template.php');
			include_once(YT_INCLUDES_PATH.J_SEPARATOR.'site'.J_SEPARATOR.'lib'.J_SEPARATOR.'yt_renderxml.php');
		}
	}
	function onContentPrepareForm($form, $data){
		// Add param(support Mega menu) for menu item
		if($form->getName()=='com_menus.item'){
			JForm::addFormPath(YT_INCLUDES_PATH.J_SEPARATOR.'libs'.J_SEPARATOR.'menu'.J_SEPARATOR.'params');
			$form->loadFile('params', false);
		}
	}
	function onBeforeRender(){
		/* Current, only include css, js */
		global $app;
		$document = JFactory::getDocument();
		// For backend
		if($app->isAdmin()){
			// Load language Yt Plugin
			$this->loadLanguage();
			// Include for joomla version 2.5.x
			if(J_VERSION=='2'){
				if( (JRequest::getVar('option') != $this->params->get('no_jquery')) || ( is_array($this->params->get('no_jquery')) && !in_array(JRequest::getVar('option'),$this->params->get('no_jquery')) ) ){
					if(!defined('SMART_JQUERY')){
						define('SMART_JQUERY', 1);
						$document->addScript(YT_PLUGIN_URL.'/includes/admin/js/jquery.min.js');
						$document->addScript(YT_PLUGIN_URL.'/includes/admin/js/jquery-noconflict.js');
					}
				}
				if($this->nameOfSJTemplate()){
					$document->addStyleSheet(YT_PLUGIN_URL.'/includes/admin/bootstrap/css/bootstrap.css');
					$document->addStyleSheet(YT_PLUGIN_URL.'/includes/admin/bootstrap/css/bootstrap-responsive.min.css');
					$document->addScript(YT_PLUGIN_URL.'/includes/admin/bootstrap/js/bootstrap.min.js');
					$document->addScript(YT_PLUGIN_URL.'/includes/admin/js/template.js');
				}
			}
			if($this->nameOfSJTemplate()){
				$document->addStyleSheet(JURI::root(true).'/templates/'.$this->nameOfSJTemplate().'/css/pattern.css');
				$document->addStyleSheet(JURI::root(true).'/templates/'.$this->nameOfSJTemplate().'/asset/minicolors/jquery.miniColors.css');
				$document->addStyleSheet(YT_PLUGIN_URL.'/includes/admin/css/style.css');
				$document->addStyleSheet(YT_PLUGIN_URL.'/includes/admin/css/override_bootstrap.css');
				$document->addStyleSheet(YT_PLUGIN_URL.'/includes/admin/css/icomoon/style.css');
				$document->addScript(JURI::root(true).'/templates/'.$this->nameOfSJTemplate().'/asset/minicolors/jquery.miniColors.min.js');
				$document->addCustomTag('
					<script type="text/javascript">
						TMPL_BACKEND = "'.$this->nameOfSJTemplate().'_backend"
					</script>
				');
				$document->addScript(YT_PLUGIN_URL.'/includes/admin/js/yt-backendtemplate.js');
			}
			// For menu SJ Help, Clean cache
			if($this->params->get('show_sjhelp', 0)==1){
				$document->addScript(YT_PLUGIN_URL.'/includes/admin/js/menu-sjhelp.js');
			}
		}
		if($app->isSite() && $this->nameOfSJTemplate()){
			// Include any...
		}
	}
	function onAfterRender() {
		if($this->nameOfSJTemplate()){
			global $app;
			$document = JFactory::getDocument();
			$option   = JRequest::getVar('option', '');
			$task	  = JRequest::getVar('task', '');
			//  Minify
			if($app->isSite() && $document->_type == 'html' && !$app->getCfg('offline') && (!($option == 'com_content' && $task =='edit'))){
				require_once(YT_INCLUDES_PATH.J_SEPARATOR.'libs'.J_SEPARATOR.'yt-minify.php');
				$yt_mini = new YT_Minify;

				if($app->getTemplate(true)->params->get('optimizeCSS', 0)) $yt_mini->optimizecss();
				if($app->getTemplate(true)->params->get('optimizeJS', 0)) $yt_mini->optimizejs();

				if(JRequest::getVar('type') == 'plugin' && JRequest::getVar('action') == 'clearCache')
					$yt_mini->clearCache();
			}
			// Override template backend. New UI
			if($app->isAdmin()){
				$body = JResponse::getBody();
				if(JRequest::getCmd('view') == 'style'){
					// Template Content
					ob_start();
					require_once(YT_INCLUDES_PATH . '/admin/template/default.php');
					$buffer = ob_get_clean(); //var_dump($buffer); die();
					$body1 = preg_replace('@<form\s[^>]*name="adminForm"[^>]*>?.*?</form>@siu', $buffer, $body);
					if( preg_last_error() == PREG_BACKTRACK_LIMIT_ERROR){
						ini_set( 'pcre.backtrack_limit', (int)ini_get( 'pcre.backtrack_limit' )+ 15000 );
						$body1= preg_replace('@<form\s[^>]*name="adminForm"[^>]*>?.*?</form>@siu', $buffer, $body);
					}
				}
				if($body1!=null){
					JResponse::setBody($body1);
				}else{
					die('Error occurred because preg_replace is null');
				}
			}
		}
	}
	// Get template name(only SJ's Template)
	function nameOfSJTemplate(){
		global $app;
		static $yt_templatename;
		if (!isset($yt_templatename)) {
			$yt_templatename = false; // set false
			$app = JFactory::getApplication();
			// get template name
			$name = '';
			if ($app->isAdmin()) {
				// if not login, do nothing
				$user = JFactory::getUser();
				if (!$user->id) return false;
				if(JRequest::getCmd('option') == 'com_templates' && (preg_match('/style\./', JRequest::getCmd('task')) || JRequest::getCmd('view') == 'style' || JRequest::getCmd('view') == 'template')){
					$db       = JFactory::getDBO();
					$query    = $db->getQuery(true);
					$id  = JRequest::getInt('id');
					if (JRequest::getCmd('view') == 'template') {
						$query
							->select('element')
							->from('#__extensions')
							->where('extension_id='.(int)$id . ' AND type=' . $db->quote('template'));
					} else {
						$query
							->select('template')
							->from('#__template_styles')
							->where('id='.(int)$id);
					}
					$db->setQuery($query);
					$name = $db->loadResult();
				}

			} else {
				$db       = JFactory::getDBO();
				$query    = $db->getQuery(true);
				$query
							->select('template')
							->from('#__template_styles')
							->where('home = 1 AND client_id = 0');
				$db->setQuery($query);
				$name = $db->loadResult();
			}

			if ($name) {
				// parse xml
				$filePath = JPath::clean(JPATH_ROOT.'/templates/'.$name.'/templateDetails.xml');
				if (is_file ($filePath)) {
					$xml = JInstaller::parseXMLInstallFile($filePath);
					if (strtolower($xml['group']) == 'yt_framework') {
						$yt_templatename = $name;
					}
				}
			}
		}
		return $yt_templatename;
	}
}