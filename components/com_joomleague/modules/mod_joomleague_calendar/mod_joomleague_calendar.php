<?php
/**
 * @version    1.2.2.1
 * @package    Blog Calendar
 * @author   Justo Gonzalez de Rivera
 * @license    GNU/GPL
 * modified by johncage for use with joomleague
 * @version    1.5.0.1
 */


// no direct access

// Include the syndicate functions only once

require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joomleague'.DIRECTORY_SEPARATOR.'joomleague.core.php');

JHtml::_('behavior.tooltip');
$jinput = JFactory::getApplication() -> input;
$ajax= $jinput -> get('ajaxCalMod',0,'int');
$ajaxmod= $jinput -> get('ajaxmodid',0,'int');
if(!$params->get('cal_start_date')){
	$year = $jinput -> get('year',date('Y'), 'int');    /*if there is no date requested, use the current month*/
	$month  = $jinput -> get('month',date('m'), 'int');
	$day  = $jinput -> get('day',0, 'int');
}
else{
	$startDate= new JDate($params->get('cal_start_date'));
	$year = $jinput -> get('year', $startDate->toFormat('%Y'), 'int');
	$month  = $jinput -> get('month', $startDate->toFormat('%m'), 'int');
	$day  = $ajax? '' : $jinput -> get('day', $startDate->toFormat('%d'), 'int');
}
$helper = new modJLCalendarHelper;
$doc = JFactory::getDocument();
$lightbox    = $params->get('lightbox', 1);

JHtml::_('jquery.framework');
JHtml::_('behavior.modal');
if ($lightbox ==1 && (!isset($_GET['format']) OR ($_GET['format'] != 'pdf'))) {
	$doc->addScriptDeclaration(";
      window.addEvent('domready', function() {
          $$('a.jlcmodal".$module->id."').each(function(el) {
            el.addEvent('click', function(e) {
              new Event(e).stop();
              SqueezeBox.fromElement(el);
            });
          });
      });
      ");
}
$inject_container = ($params->get('inject', 0)==1)?$params->get('inject_container', 'joomleague'):'';
$doc->addScriptDeclaration(';
    jlcinjectcontainer['.$module->id.'] = \''.$inject_container.'\';
    jlcmodal['.$module->id.'] = \''.$lightbox.'\';
      ');

if (!defined('JLC_MODULESCRIPTLOADED')) {
	$doc->addScript( JUri::base().'modules/mod_joomleague_calendar/assets/js/mod_joomleague_calendar.js' );
	$doc->addScriptDeclaration(';
    var calendar_baseurl=\''. JUri::base() . '\';
      ');
	$doc->addStyleSheet(JUri::base().'modules/mod_joomleague_calendar/assets/css/mod_joomleague_calender.css');
	define('JLC_MODULESCRIPTLOADED', 1);
}
$calendar = $helper->showCal($params,$year,$month,$ajax,$module->id);

require(JModuleHelper::getLayoutPath('mod_joomleague_calendar'));

?>