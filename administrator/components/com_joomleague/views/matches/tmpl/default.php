<?php defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');
$jinput = JFactory::getApplication() -> input;
$massadd=$jinput -> get('massadd',0, 'int');
?>

<div id="alt_decision_enter" style="display:<?php echo ($massadd == 0) ? 'none' : 'block'; ?>">
<?php echo $this->loadTemplate('massadd'); ?>
</div>
<?php
echo $this->loadTemplate('matches');
if(count($this->teams) > 1) {
	echo $this->loadTemplate('matrix');
}
?>
