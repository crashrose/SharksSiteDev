<?php
/**
 * 
 */
jimport ( 'joomla.language.language' );
class JLGLanguage extends JLanguage {
	public $strings = array ();
	
	public function getStrings(){
		$this->strings = array();
		$langpaths = JFactory::getLanguage()->getPaths();
		foreach($langpaths as $lang=>$paths){
			foreach ($paths as $path=>$value){
				if(strpos(strtoupper($path),"JOOMLEAGUE")!==false){
					$this->loadLanguage($path);
				}
			}
			
		
		}
		return $this->strings;
	}
	
	function __contruct($lang = null, $debug = false){
		
		 $strings = array();
	return parent::__contruct($lang, $debug);
	}
	

}