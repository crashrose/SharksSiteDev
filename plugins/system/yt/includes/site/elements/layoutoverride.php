<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldLayoutOverride extends JFormField
{
	public $type = 'LayoutOverride';

	protected function getInput() {
		$options = (array) $this->getOptions();
		$html = '';
		$html .= '<div id="'.str_replace('jform_params_','', $this->id).'_form">';
		$html .= '<span class="">' . JText::_('ItemID:') . '</span>';
		$html .= '<input type="text" id="'.str_replace('jform_params_','', $this->id).'_input" />';
		$html .= '<span class="">' . JText::_('Layout:') . '</span>';
		$html .= JHtml::_('select.genericlist', $options, 'name', '', 'value', 'text', 'default', ''.str_replace('jform_params_','', $this->id).'_select');
		$html .= '<span data-placement="top" rel="tooltip" data-original-title="Apply" title="Apply" class="btn" id="'.str_replace('jform_params_','', $this->id).'_add_btn"><span class="icon-checkmark-2"></span></span>';
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '</textarea>';
		$html .= '<div id="'.str_replace('jform_params_','', $this->id).'_rules"></div>';
		$html .= '</div>';
		
		return $html;
	}

	protected function getOptions() {
		$options = array();
		$path = (string) $this->element['directory'];
		if (!is_dir($path)) $path = JPATH_ROOT.'/'.$path;
		$files = JFolder::files($path, '.xml'); 

		if (is_array($files)) {
			foreach($files as $file) {
				$file = JFile::stripExt($file);
				$options[] = JHtml::_('select.option', $file, $file);
			}
		}

		return array_merge($options);
	}
}
