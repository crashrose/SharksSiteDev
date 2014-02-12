<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldYtFieldset extends JFormField
{
	public $type = 'YtFieldset';

	protected function getInput() {
		$status = (string)$this->element['status'];
		$html = '';
		if($status==1){
			$html .='
				<fieldset class="yt-fieldset">
				  <legend>'.JText::_($this->element['legend']).'</legend>
			';
			if($this->element['legend']=='FIELDSET_CSS'){
				$html .='<div class =\'less2css\'>';
				$html .='<div class =\'less2css-info\'><span class=\'icon-info-2\'></span>  '.JText::_('LESS2CSS_INFO');
				$html .='<a href=\'#myModal\' id=\'less2css_modal\' role=\'button\' class=\'link\' data-toggle=\'modal\'>Click here</a>';
				$html .='</div>';
				$html .='</div>';
				$html .='
			    <div id=\'myModal\' class=\'modal hide fade\' tabindex=\'-1\' role=\'dialog\' aria-labelledby=\'myModalLabel\' aria-hidden=\'true\'>
				    <div class=\'modal-header\'>
				    <button type=\'button\' class=\'close\' data-dismiss=\'modal\' aria-hidden=\'true\'>×</button>
				    <h4 id=\'myModalLabel\'>'.Jtext::_('LESS2CSS_TITLE').'</h4>
				    <div class =\'less2css-warning\'><span class=\'icon-warning\'></span>  '.JText::_('LESS2CSS_WARNING').'</div>
				    </div>
				    <div class=\'modal-body\'>
				    <p style=\'text-align:center\' id=\'less2css_result\'></p>
				    <div style=\'text-align:center\'>
				    <span class=\'btn btn-primary less2css\'>Yes</span>
				    <span class=\'btn\' data-dismiss=\'modal\' aria-hidden=\'true\'>No</span>
				    </div>
			   		</div>
			    </div>
			    <script language=\'javascript\' type=\'text/javascript\'>
					jQuery(document).ready(function($){
						$(\'a#less2css_modal\').click(function(){
							$(\'#less2css_result\').html(\' \');
						})
						$(\'.less2css.btn\').click(function(){
							$(\'#less2css_result\').html(\'Converting...\');
							new Request({url: \'../index.php?less2css=all&compile=server\', method:\'post\',
								onSuccess: function(result){
									$(\'#less2css_result\').html(\'Convert successful!\');
								},
								onFailure: function(){
									$(\'#less2css_result\').html(\'Convert successful!\');
								}
							}).send();
						});
					})
				</script>
				';
			}
		}else{
			$html .='
				</fieldset>
			';
		}
		//echo 'dungnv'; var_dump($html); die();
		return $html;
	}
}
