<?php
defined('JPATH_BASE') or die;

class JFormFieldYtless2css extends JFormField{

	protected $type = 'ytless2css';

	protected function getInput() {
		$url = str_replace("/administrator", "", JURI::base()).'?less2css=all&compile=server';
		$html  = '<a id="'.$this->id.'" name="'.$this->name.'" href="javascript:void(0)" class="btn less2css"><span class="icon-disk"></span> Convert</a>';
		$html .= '<span style="padding: 0 8px" id="less2css_result"></span>';
		$html .= '
		<script language="javascript" type="text/javascript">
		jQuery(document).ready(function($){
			$("a#'.$this->id.'").click(function(){
				$("#less2css_result").html("Converting...");
				new Request({url: "../index.php?less2css=all&compile=server", method:"post",
					onSuccess: function(result){
						$("#less2css_result").html("Convert successful!");
					},
					onFailure: function(){
						alert("Error ...");
					}
				}).send();

				/*
				var request = $.ajax({
					url: "'.$url.'",
					type: "POST"
				});
				request.done(function(msg) {
					$("#less2css_result").html("Convert successful!");
				});
				request.fail(function(jqXHR, textStatus) {
					alert( "Request failed: " + textStatus );
				});
				*/
			});
		});
		</script>
		';
		return $html;
	}
}
