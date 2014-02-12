<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldYtColor extends JFormField
{
	public $type = 'YtColor';

	protected function getInput() {
		$html = '';
		$html .= '
		<div class="ytcolor-wrap" id="'.$this->id.'_wrap">
			<input type="text" value="'.$this->value.'" name="'.$this->name.'" class="color-picker miniColors" id="'.$this->id.'" autocomplete="off" size="8" maxlength="8">
		</div>
		<script language="javascript" type="text/javascript">
		jQuery(document).ready(function($){
			$("#'.$this->id.'_wrap input.color-picker").miniColors({
				change: function(hex, rgb) {
					
				}
			});
		});
		</script>';
		
		
		return $html;
	}
}
