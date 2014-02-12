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
defined('_JEXEC') or die;
jimport('joomla.updater.update');

// Get array Template info, Framework info
$t_filePath = JPath::clean(JPATH_ROOT.'/templates/'.$this->nameOfSJTemplate().'/templateDetails.xml');
$f_filePath = JPath::clean(JPATH_ROOT.'/'.YT_PLUGIN_REL_URL.'/'.YT_PLUGIN.'.xml');
if (is_file ($t_filePath)) {
    $t_xml = JInstaller::parseXMLInstallFile($t_filePath);
}
if (is_file ($f_filePath)) {
    $f_xml = JInstaller::parseXMLInstallFile($f_filePath);
}
// Template name
$t_name = $this->nameOfSJTemplate();
// Framework name
$f_name = YT_PLUGIN;
// Template has new version
$t_hasnew = false;
// Template curent version, template new version
$t_curVersion = $t_newVersion = $t_xml['version'];
// Framework has new version
$f_hasnew = false;
// Framework curent version, framework new version
$f_curVersion = $f_newVersion = $f_xml['version'];

// Get object template styles
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
	->select('id, title')
	->from('#__template_styles')
	->where('template='. $db->quote($t_name));
$db->setQuery($query);
$styles = $db->loadObjectList();

// Check more for Template version, Framework version
$query = $db->getQuery(true);
$query
  ->select('*')
  ->from('#__updates')
  ->where('(element = ' . $db->q($t_name) . ') OR (element = ' . $db->q($f_name) . ')');
$db->setQuery($query);
$results = $db->loadObjectList('element');
//var_dump($results); die();
if(count($results)){
  if(isset($results[$t_name])){
    $t_hasnew = true;
    $t_newVersion = $results[$t_name]->version;
  }
  if(isset($results[$f_name])){
    $f_hasnew = true;
    $f_newVersion = $results[$f_name]->version;
  }
}
$hasperm = JFactory::getUser()->authorise('core.manage', 'com_installer');

?>
<div class="controls-row row-fluid">
    <div class="left-overview span6">
        <div class="control-group row-fluid">
            <div class="control-label span3">
                <label class="hasTip" title="<?php echo JText::_('SELECT_STYLE_LABEL'); ?>::<?php echo JText::_('SELECT_STYLE_DESC'); ?>"><?php echo JText::_('SELECT_STYLE_LABEL'); ?></label>
            </div>
            <div class="controls span8">
                <?php echo JHTML::_('select.genericlist', $styles, 'yt-styles-list', 'autocomplete="off"', 'id', 'title', JRequest::getInt('id')); ?>
            </div>
        </div>
        <div class="control-group row-fluid">
            <div class="control-label span3">
                <?php echo $form->getLabel('title'); ?>
            </div>
            <div class="controls span8">
                <?php echo $form->getInput('title'); ?>
            </div>
        </div>
        <div class="control-group row-fluid">
            <div class="control-label span3">
                <?php echo $form->getLabel('template'); ?>
            </div>
            <div class="controls span8">
                <?php echo $form->getInput('template'); ?>
            </div>
        </div>
        <div class="control-group row-fluid">
            <div class="control-label span3">
                <?php echo $form->getLabel('client_id'); ?>
            </div>
            <div class="controls span8">
                <?php echo $form->getInput('client_id'); ?>
                <input type="text" size="35" value="<?php echo $form->getValue('client_id') == 0 ? JText::_('JSITE') : JText::_('JADMINISTRATOR'); ?>	" class="inputbox readonly" readonly="readonly" />
            </div>
        </div>
        <div class="control-group row-fluid">
            <div class="control-label span3">
                <?php echo $form->getLabel('home'); ?>
            </div>
            <div class="controls span8">
                <?php echo $form->getInput('home'); ?>
            </div>
        </div>
        <?php if ($form->getInput('id')) : ?>
            <div class="control-group row-fluid">
                <div class="control-label span3">
                    <?php echo $form->getLabel('id'); ?>
                </div>
                <div class="controls span8">
                    <span class="disabled"><?php echo $form->getInput('id'); ?></span>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="right-overview span6">
         <div class="control-group row-fluid">
            <div class="controls span12">
            	<?php include_once 'template_desc.html'; ?>
            </div>
        </div>
    </div>
</div>
<div class="controls-row row-fluid wrap-info">
	<!-- Framework info -->
    <div class="left-overview span6">
        <h2 class="framework-name"><?php echo str_replace('_', ' ', $f_xml['name']); ?></h2>
        <div class="info">
        	<dl>
                <dt><?php echo JText::_('Name')?>:</dt>
                <dd><?php echo $f_xml['name'] ?></dd>
                <dt><?php echo JText::_('Version')?>:</dt>
                <dd><?php echo $f_xml['version'] ?></dd>
                <dt><?php echo JText::_('Create date')?>:</dt>
                <dd><?php echo $f_xml['creationDate'] ?></dd>
                <dt><?php echo JText::_('Author')?>:</dt>
                <dd><a href="<?php echo $f_xml['authorUrl'] ?>" title="<?php echo $f_xml['author'] ?>"><?php echo $f_xml['author'] ?></a></dd>
            </dl>
        </div>
        <div class="update<?php echo ($f_hasnew)?' notice':'' ?>">
        	<h4><?php echo $f_hasnew ? JText::sprintf('FRAMEWORK_NEW_HEADING', $f_xml['name']):JText::sprintf('FRAMEWORK_HEADING', $f_xml['name'])?></h4>
        	<p><?php echo $f_hasnew ? JText::sprintf('FRAMEWORK_NEW_MESSAGE', $f_xml['name'], $f_newVersion) : JText::sprintf('FRAMEWORK_MESSAGE', $f_curVersion) ?></p>
        	<?php if($hasperm): ?>
          	<a class="btn" href="<?php JURI::base() ?>index.php?option=com_installer&view=update" title="<?php echo JText::_( $f_hasnew ? 'GO_UPDATE' : 'CHECK_UPDATE') ?>">
            <?php if($f_hasnew) {?>
            <i class="icon-download"></i>
            <?php } else{ ?>
            <i class="icon-refresh"></i>
			<?php } ?>
			<?php echo JText::_( $f_hasnew ? 'GO_UPDATE' : 'CHECK_UPDATE') ?>
            </a>
          <?php endif; ?>
        </div>
    </div>
    <!-- Template info -->
    <div class="right-overview span6">
        <h2 class="template-name"><?php echo str_replace('_', ' ', $t_xml['name']); ?></h2>
        <div class="info">
        	<dl>
                <dt><?php echo JText::_('Name')?>:</dt>
                <dd><?php echo $t_xml['name'] ?></dd>
                <dt><?php echo JText::_('Version')?>:</dt>
                <dd><?php echo $t_xml['version'] ?></dd>
                <dt><?php echo JText::_('Create date')?>:</dt>
                <dd><?php echo $t_xml['creationDate'] ?></dd>
                <dt><?php echo JText::_('Author')?>:</dt>
                <dd><a href="<?php echo $t_xml['authorUrl'] ?>" title="<?php echo $t_xml['author'] ?>"><?php echo $t_xml['author'] ?></a></dd>
            </dl>
        </div>
        <div class="update<?php echo ($t_hasnew)?' notice':'' ?>">
        	<h4><?php  echo $t_hasnew ? JText::sprintf('TEMPLATE_NEW_HEADING', $t_xml['name']):JText::sprintf('TEMPLATE_HEADING', $t_xml['name'])?></h4>
        	<p><?php echo $t_hasnew ? JText::sprintf('TEMPLATE_NEW_MESSAGE', $t_xml['name'], $t_newVersion) : JText::sprintf('TEMPLATE_MESSAGE', $t_curVersion) ?></p>
        	<?php if($hasperm): ?>
            <?php if($t_hasnew) { ?>
            <?php } else{ ?>
            <a class="btn" href="<?php JURI::base() ?>index.php?option=com_installer&view=update" title="<?php echo JText::_( $t_hasnew ? 'GO_UPDATE' : 'CHECK_UPDATE') ?>">
                <i class="icon-refresh"></i><?php echo JText::_( $t_hasnew ? 'GO_UPDATE' : 'CHECK_UPDATE') ?>
            </a>
			<?php } ?>
            <!--<span class="hasTip btn btn-warning" title="<?php echo JText::_('TEMPLATE_QUEST_LABEL'); ?>::<?php echo JText::sprintf('TEMPLATE_QUEST_DESC', $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name']); ?>">
                <i class="icon-question-sign"></i>   <?php echo JText::_('Notice'); ?>
            </span> -->
            <span id="dungnv" class="btn btn-warning" title="" data-content="<?php echo JText::sprintf('TEMPLATE_QUEST_DESC', $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name'], $t_xml['name']); ?>" data-placement="top" data-toggle="popover" data-original-title="<?php echo JText::_('TEMPLATE_QUEST_LABEL'); ?>"><i class="icon-question-sign"></i><?php echo JText::_('Notice'); ?></span>
            <script>
				jQuery(function ($){ 
					jQuery("#dungnv").popover();
				});
			</script>
          <?php endif; ?>
        </div>
    </div>
</div>
