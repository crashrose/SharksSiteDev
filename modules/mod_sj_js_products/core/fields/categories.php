<?php
defined('_JEXEC') or die('Restricted access');
error_reporting(error_reporting() & ~E_NOTICE);
if(file_exists(JPATH_SITE.'/components/com_jshopping/lib/factory.php') && file_exists(JPATH_SITE.'/components/com_jshopping/lib/functions.php')){
	require_once (JPATH_SITE.'/components/com_jshopping/lib/factory.php'); 
	require_once (JPATH_SITE.'/components/com_jshopping/lib/functions.php');
	class JFormFieldCategories extends JFormField {
	  public $type = 'categories';
	  
	  protected function getInput(){
			$tmp = new stdClass();  
			$tmp->category_id = "";
			$tmp->name = JText::_('JALL');
			$categories_1  = array($tmp);
			$categories_select =array_merge($categories_1 , buildTreeCategory(0)); 
			$ctrl  =  $this->name;
			$ctrl .= '[]';
			$value = empty($this->value) ? '' : $this->value;
	  return JHTML::_('select.genericlist', $categories_select, $ctrl,'class="inputbox" multiple="multiple"','category_id','name', $value );
	  }
	}
}else{ echo JText::_("Please install Joomshopping component befor using module");}
?>

