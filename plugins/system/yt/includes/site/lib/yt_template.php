<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2012 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include class Browser
include_once ('browser.php');
// Class YtTemplate
if (!class_exists('YtFrameworkTemplate')){
abstract class YtFrameworkTemplate {
	var $_tpl = null;
	var $template = '';
	var $layout = '';
	var $browser = '';
	var $override = false;
	var $_params_cookie = array();

	function YtFrameworkTemplate ($template =null, $cookie) {
		$this->_tpl = $template;
		$this->template = $template->template;
		$this->override = $this->isOverrideTemplate(); //var_dump($this->override); 
		//$this->browser = $this->browser();
		$_params_cookie = $cookie;
		foreach ($_params_cookie as $k) {
			$this->_params_cookie[$k] = $this->_tpl->params->get($k);
		}
		$this->getUserSetting();

		if(is_file(JPATH_ROOT.'/templates/'.$this->template.'/less/color/'. $this->getParam('templateColor').'.less')){
			$colorcontent1 = JFile::read('templates/'.$this->template.'/less/color/variables_color.less');
			$colorcontent2 = JFile::read('templates/'.$this->template.'/less/color/'. $this->getParam('templateColor').'.less');
			if($colorcontent1 != $colorcontent2){
				JFile::write(JPATH_ROOT.'/templates/'.$this->template.'/less/color/variables_color.less', $colorcontent2);
			}
		}
	}
	// Get setting of user
	/* Save setting of user on frontend to cookie*/
	function getUserSetting(){
		$exp = time() + 60*60*24*355;
		if (isset($_COOKIE[$this->template.'_tpl']) && $_COOKIE[$this->template.'_tpl'] == $this->template){
			foreach($this->_params_cookie as $k=>$v) {
				$kc = $this->template.'_'.$k;
				if (JRequest::getVar($k)!= null){
					$v = JRequest::getVar($k);
					@setcookie ($kc, $v, $exp, '/');
				}else{
					if (isset($_COOKIE[$kc])){
						$v = $_COOKIE[$kc];
					}
				}
				$this->setParam($k, $v);
			}
		}else{
			@setcookie ($this->template.'_tpl', $this->template, $exp, '/');
		}
		return $this;
	}
	// Get param template
	function getParam ($param, $default='') {
		if (isset($this->_params_cookie[$param]) && $this->override==false) {
			return $this->_params_cookie[$param];
		}
		return $this->_tpl->params->get($param, $default);
	}
	// Set param template
	function setParam ($param, $value) {
		$this->_params_cookie[$param] = $value;
	}
	// Set cookie for param
	function set_cookie($name, $value = "") {
		$expires = time() + 60*60*24*365;
		setcookie($name, $value, $expires,"/","");
	}
	// Get cookie of param
	function get_cookie($item) {
		if (isset($_COOKIE[$item]))
			return urldecode($_COOKIE[$item]);
		else
			return false;
	}
	// Return url of site
	function baseurl(){
		 return JURI::base();
	}
	// Return url of template
	function templateurl() {
		return JURI::base()."templates/".$this->template.'/';
	}
	// Check page is home page or not
	function isHomePage(){
		$db  = JFactory::getDBO();
		$db->setQuery("SELECT home FROM #__menu WHERE id=" . intval(JRequest::getCmd( 'Itemid' )));
		$db->query();
		return  $db->loadResult();
	}
	function isOverrideTemplate(){
		if(JRequest::getVar('tmpl')!='component'){ //var_dump(JSite::getMenu()->getActive()); die();
			$menuid = '';
			if(is_object(JSite::getMenu()->getActive())) $menuid = JSite::getMenu()->getActive()->id;
			$db = JFactory::getDBO();
			if($menuid!=''){
				$query = "SELECT template_style_id FROM #__menu WHERE id = ".$menuid;
				$db->setQuery($query);
				$templateIdActive = $db->loadResult();

				$query = "SELECT id FROM #__template_styles WHERE home = 1 AND client_id = 0";
				$db->setQuery($query);
				$templateIdDefault = $db->loadResult(); //echo $templateIdDefault.' vs '.$templateIdActive; //die();

				if($templateIdActive > 0){
					return true;
				}else{
					return false;
				}
			}
		}
		return false;
	}
	function ytStyleSheet($url){
		$doc = JFactory::getDocument();
		if(!file_exists($url) && (strpos($url, 'http:')== false || strpos($url, 'https:')== false))
			$url = 'templates/'.$this->template.'/'.$url;
		$lessurl = str_replace('.css', '.less', str_replace('/css/', '/less/', $url));
		if(($this->getParam('developing', 0)==1 || JRequest::getVar('less2css')=='all') && file_exists($lessurl)){
			YTLess::addStyleSheet($lessurl);
		}elseif(file_exists($url)){
			$doc->addStyleSheet($url);
		}elseif(basename($url)=='template.css'){
			$doc->addStyleSheet(str_replace('template.css', 'template-'.$this->getParam('templateColor').'.css', $url));
		}else{
			die($url.' not exists');
		}
	}
	// Render logo
	function getLogo(){
		$app = JFactory::getApplication();
		if ($this->getParam('logoType')=='image'):  
			if($this->getParam('overrideLogoImage')!=''):
				$url = $this->baseurl().$this->getParam('overrideLogoImage');
			else:
				if(is_file('templates/'.$this->template.'/images/'.$this->getParam('templateColor').'/logo.png')){
					$url = $this->templateurl().'images/'.$this->getParam('templateColor').'/logo.png';
				}else{
					$url = $this->templateurl().'images/logo.png';
				}
			endif;
		?>
            <h1 class="logo">
                <a href="index.php" title="<?php echo $app->getCfg('sitename'); ?>">
                	<img alt="<?php echo $app->getCfg('sitename'); ?>" src="<?php echo $url; ?>"/>
                </a>
            </h1>
        <?php
		else:
            $logoText = (trim($this->getParam('logoText'))=='') ? $app->getCfg('sitename') : $this->getParam('logoText');
            $sloganText = (trim($this->getParam('sloganText'))=='') ? JText::_('SITE SLOGAN') : $this->getParam('sloganText');	?>
            <h1 class="logo-text">
                <a href="index.php" title="<?php echo $app->getCfg('sitename'); ?>"><span><?php echo $logoText; ?></span></a>
            </h1>
            <p class="site-slogan"><?php echo $sloganText;?></p>
        <?php 
		endif;
	}
	// Render menu
	function getMenu(){
		$menubase = J_TEMPLATEDIR.J_SEPARATOR.'menusys';
		include_once $menubase .J_SEPARATOR.'ytloader.php';
		if(isset($_COOKIE[$this->template.'_direction'])){
			$direction = $_COOKIE[$this->template.'_direction'];
		}else{
			$direction = $this->getParam('direction');
		}
		$browser = new Browser();
		$templateMenuBase = new YTMenuBase(
		array(
			'menutype'	=> $this->getParam('menutype'),
			'menustyle'	=> $this->getParam('menustyle'),
			'moofxduration'	=> $this->getParam('moofxduration'),
			'moofx'		=> $this->getParam('moofx'),
			'jsdropline'=> $this->getParam('jsdropline', 0),
			'activeslider'=> $this->getParam('activeslider', 0),
			'startlevel'=> $this->getParam('startlevel',0),
			'endlevel'	=> $this->getParam('endlevel',9),
			'direction'	=> $direction,
			'basepath'	=> str_replace('\\', '/', $menubase)
		));
		$templateMenuBase->getMenu()->getContent();	
		$templateMenuBase = new YTMenuBase(
		array(
			'menutype'	=> $this->getParam('menutype'),
			'menustyle'	=> 'mobile',
			'startlevel'=> $this->getParam('startlevel',0),
			'endlevel'	=> $this->getParam('endlevel',9),
			'direction'	=> $direction,
			'basepath'	=> str_replace('\\', '/', $menubase)
		));
		$templateMenuBase->getMenu()->getContent();
	}
	// render possition has attribute group in positions of block
	function renPositionsGroup($position, $type='', $special = null){
		$elStyle   = '';
		$class     = '';
		$more_attr = '';
		$doc       = JFactory::getDocument();
		// Element style
		$elStyle  .= ($position['height']!='')?'height:'.$position['height'].';':'';
		if ( $elStyle!='' ) {
			$elStyle = ' style="'.$elStyle.'"';
		}
		if($position['group']=='main'){
			$prefx = $special['mainprefix'];
		}else{
			$prefx = '';
		}
		// Element class
		if(isset($position[$prefx.'class']) && $position[$prefx.'class']!=''){
			$class .= ' class="'.$position[$prefx.'class'].'"';
		}
		// Element attribute
		
		$more_attr .= (isset($position[$prefx.'data-wide']))?' data-wide="'.$position[$prefx.'data-wide'].'"':'';
		$more_attr .= (isset($position[$prefx.'data-normal']))?' data-normal="'.$position[$prefx.'data-normal'].'"':'';
		$more_attr .= (isset($position[$prefx.'data-tablet']))?' data-tablet="'.$position[$prefx.'data-tablet'].'"':'';
		$more_attr .= (isset($position[$prefx.'data-stablet']))?' data-stablet="'.$position[$prefx.'data-stablet'].'"':'';
		$more_attr .= (isset($position[$prefx.'data-mobile']))?' data-mobile="'.$position[$prefx.'data-mobile'].'"':'';
		
		if ( $position['type'] == 'modules' ) { 
			$has_suffix = false;
			if ( isset($position['group']) && $position['group'] == 'main' && $this->getParam('layoutsuffix') != '' )
				if ( $doc->countModules($position['value'] . '-' . $this->getParam('layoutsuffix')) )
					$has_suffix = true;
			if ( $has_suffix ) {
				$this->renModulePos($position, $elStyle, $class, $more_attr, $position['value'] . '-' . $this->getParam('layoutsuffix'));
			} else {
				if ( $doc->countModules($position['value']) )
					$this->renModulePos($position, $elStyle, $class, $more_attr, '');
			}	
		} elseif ($position['type'] == 'component' && $type=='main'){ 
			if ( $this->getParam('hideComponentHomePage')=='1'
				&& $this->isHomePage() ){
			?>
            	<span style="display:none">Hide Main content block</span>
            <?php
			} else {
				$this->renComponent($elStyle, $class, $more_attr);
			}
		} elseif ( $position['type'] == 'html' ) { 
			$this->renHTMLPos($position, $elStyle, $class, $more_attr);
		} elseif ( $position['type'] == 'feature' ) {
			$this->renFeaturePos($position, $elStyle, $class, $more_attr);
		} elseif ( $position['type']=='message' ) { ?>
        	<div<?php echo $class; ?>>
				<jdoc:include type="message" />
            </div>
        <?php
		}
	}
	// render possition no attribute group in positions of block nomarl
	function renPositionsNormal($positions, $countModules){
		$doc = JFactory::getDocument();
		$countend = 0;
		foreach( $positions as $position ){
			$elStyle   = '';
			$class     = '';
			$more_attr = '';
			// Element style
			
			if($elStyle!="")
				$elStyle = " style='".$elStyle."'";
			if($position['type'] == 'modules'){
				if($doc->countModules($position['value'])>0)
					$countend ++;
			}else{
				$countend ++;
			}
			// Element class
			if($position['class']!=''){
				$class .= ' class="'.$position['class'].'"';
			}
			// Element attribute
			$more_attr .= (isset($position['data-wide']))?' data-wide="'.$position['data-wide'].'"':'';
			$more_attr .= (isset($position['data-normal']))?' data-normal="'.$position['data-normal'].'"':'';
			$more_attr .= (isset($position['data-tablet']))?' data-tablet="'.$position['data-tablet'].'"':'';
			$more_attr .= (isset($position['data-stablet']))?' data-stablet="'.$position['data-stablet'].'"':'';
			$more_attr .= (isset($position['data-mobile']))?' data-mobile="'.$position['data-mobile'].'"':'';
			
			if($position['type'] == 'modules'){
				if( $doc->countModules($position['value']) )
					$this->renModulePos($position, $elStyle, $class, $more_attr);
			}elseif($position['type'] == 'html'){
				$this->renHTMLPos($position, $elStyle, $class, $more_attr);
			}elseif($position['type'] == 'feature'){
				$this->renFeaturePos($position, $elStyle, $class, $more_attr);
			}elseif($position['type']=='message'){ ?>
            	<div<?php echo $class; ?>>
                	<jdoc:include type="message" />
                </div>
            <?php
            }
		}
	}
	// render possition no attribute group in positions of block content
	function renPositionsContentNoGroup($position){
		$doc       = &JFactory::getDocument();
		$elStyle   = '';
		$class     = '';
		$more_attr = '';
		// Element style
		if($position['height']!=""){
			if($elStyle!=""){
				$elStyle .= 'height:'.$position['height'].";";
			}else{
				$elStyle .= 'height:'.$position['height'].";";
			}
		}
		if($elStyle!="")
			$elStyle = " style='".$elStyle."'";
		// Element class
		if($position['class']!=''){
			$class .= ' class="'.$position['class'].'"';
		}
		// Element attribute
		$more_attr .= (isset($position['data-wide']))?' data-wide="'.$position['data-wide'].'"':'';
		$more_attr .= (isset($position['data-normal']))?' data-normal="'.$position['data-normal'].'"':'';
		$more_attr .= (isset($position['data-tablet']))?' data-tablet="'.$position['data-tablet'].'"':'';
		$more_attr .= (isset($position['data-stablet']))?' data-stablet="'.$position['data-stablet'].'"':'';
		$more_attr .= (isset($position['data-mobile']))?' data-mobile="'.$position['data-mobile'].'"':'';
		
		if($position['type'] == 'modules'){
			if( $doc->countModules($position['value']) ){
				$this->renModulePos($position, $elStyle, $class);
			}
		}elseif($position['type'] == 'html'){
			$this->renHTMLPos($position, $elStyle, $class, $more_attr);
		}elseif($position['type'] == 'feature'){
			$this->renFeaturePos($position, $elStyle, $class, $more_attr);
		}elseif($position['type']=='message'){ ?>
        	<div<?php echo $class; ?>>
				<jdoc:include type="message" />
            </div>
		<?php
		}
	}
	//render position with type: modules
	function renModulePos ($position, $elementstyle, $elementclass='', $more_attr='', $positionnamesuffix='', $yorn='1' ) {
		if($yorn == '1'){
		?>
		<div id="<?php echo $position['value']; ?>"<?php echo $elementstyle; ?><?php echo $elementclass; ?><?php echo $more_attr;?>>
			<!--<div class="yt-position-inner">-->
				<jdoc:include type="modules" name="<?php echo ($positionnamesuffix=='')?$position['value']:$positionnamesuffix; ?>" style="<?php echo $position['style'];?>" />
			<!--</div>-->
		</div>
		<?php
		}else{ ?>
			<jdoc:include type="modules" name="<?php echo ($positionnamesuffix=='')?$position['value']:$positionnamesuffix; ?>" style="<?php echo $position['style'];?>" />
        <?php    
		}
	}
	//render position with type: html
	function renHTMLPos ($position, $elementstyle, $elementclass='', $more_attr='' ) {
		?>
		<div<?php echo $elementclass; ?><?php echo $elementstyle; ?><?php echo $more_attr; ?>>
			<?php echo $position['value']; ?>
        </div>
		<?php
	}
	//render position with type: feature
	function renFeaturePos ($position, $elementstyle, $elementclass='', $more_attr='' ) {
		?>
		<div id="<?php echo "yt_".strtolower(substr($position['value'], 1))."position";?>"<?php echo $elementclass; ?><?php echo $elementstyle; ?><?php echo $more_attr; ?>>
			<?php
            if($position['value'] == '@logo'){
                echo $this->getLogo();
            }elseif($position['value'] == '@fontsize'){
                echo $this->getControlFontSize();
            }elseif($position['value'] == '@menu'){
                 $this->getMenu();
            }elseif($position['value'] == '@linkFooter'){
                $this->getLinkFooter();
            }elseif($position['value'] == '@copyright'){
                $this->getCopyright();
            }
            ?>
        </div>
		<?php
	}
	//render position with type: component
	function renComponent ($elementstyle, $elementclass='', $more_attr='') {
		?>
        <div id="yt_component"<?php echo $elementclass; ?><?php echo $elementstyle; ?><?php echo $more_attr; ?>>
            <div class="component-inner"><div class="component-inner2">
                <jdoc:include type="component" />
            </div></div>
        </div>
		<?php 
	}
	
	
	
	
	// Check version of IE
	/* Return version of IE */
	function ieversion() {
		preg_match('/MSIE ([0-9]\.[0-9])/', $_SERVER['HTTP_USER_AGENT'], $reg);
		if(!isset($reg[1])) {
			return -1;
		} else {
			return floatval($reg[1]);
		}
	}
}
}
?>