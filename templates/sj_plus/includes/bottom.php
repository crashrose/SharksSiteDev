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
defined( '_JEXEC' ) or die( 'Restricted access' );
// Body's font-size & font-family
$doc->addStyleDeclaration('body.'.$yt->template.'{font-size:'.$fontSize.'}');
if(trim($fontName)!=''){
	$doc->addStyleDeclaration('body.'.$yt->template.'{font-family:'.$fontName.',sans-serif;}');
}

// Google Font & Element use
if ($googleWebFont != "" && $googleWebFont != " " && strtolower($googleWebFont)!="none") {
	$doc->addStyleSheet('http://fonts.googleapis.com/css?family='.str_replace(" ","+",$googleWebFont).'');
	$googleWebFontFamily = strpos($googleWebFont, ':')?substr($googleWebFont, 0, strpos($googleWebFont, ':')):$googleWebFont;
	if(trim($googleWebFontTargets)!="")
		$doc->addStyleDeclaration('  '.$googleWebFontTargets.'{font-family:'.$googleWebFontFamily.', serif !important}');
}
// Add css... config to <head>...</head>
$doc->addStyleDeclaration('
body.'.$yt->template.'{
	background-color:'.$yt->getParam('bgcolor').' ;
	color:'.$yt->getParam('textcolor').' ;
}

body a{
	color:'.$yt->getParam('linkcolor').' ;
}
#yt_header{background-color:'.$yt->getParam('header-bgcolor').' ;}

#yt_footer{background-color:'.$yt->getParam('footer-bgcolor').' ;}
#yt_spotlight2{background-color:'.$yt->getParam('footer-bgcolor').' ;}

');
// Add class pattern to element wrap
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		/* Begin: add class pattern for element */
		var headerbgimage = '<?php echo $yt->getParam('header-bgimage');?>';
		var footerbgimage = '<?php echo $yt->getParam('footer-bgimage');?>';
		if(headerbgimage){
			$('#yt_header').addClass(headerbgimage);
			
		}
		if(footerbgimage){
			$('#yt_footer').addClass(footerbgimage);
			$('#yt_spotlight2').addClass(footerbgimage);
		}
		/* End: add class pattern for element */
	});
</script>
<?php
// Include cpanel
if($showCpanel) {
	include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'cpanel.php');
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		miniColorsCPanel('.body-backgroud-color .color-picker', 'body', 'background-color');
		miniColorsCPanel('.link-color .color-picker', 'body a', 'color');
		miniColorsCPanel('.text-color .color-picker', 'body', 'color');
		miniColorsCPanel('.header-backgroud-color .color-picker', Array('#yt_header'), 'background-color');
		miniColorsCPanel('.footer-backgroud-color .color-picker', Array('#yt_footer', '#yt_spotlight2'), 'background-color');
		patternClick('.header-backgroud-image .pattern', 'header-bgimage', Array('#yt_header'));
		patternClick('.footer-backgroud-image .pattern', 'footer-bgimage', Array('#yt_footer', '#yt_spotlight2'));
		
		var array 				= Array('bgcolor','linkcolor','textcolor','header-bgcolor','header-bgimage','footer-bgcolor','footer-bgimage');
		var array_blue          = Array('#ffffff','#0083e8','#666666','#f1f1f1','pattern1','#141414','pattern4');
		var array_red 	        = Array('#ffffff','#cc032a','#666666','#f1f1f1','pattern1','#141414','pattern4');
		var array_oranges       = Array('#ffffff','#FF7E00','#666666','#f1f1f1','pattern1','#141414','pattern4');
		var array_green         = Array('#ffffff','#62a400','#666666','#f1f1f1','pattern1','#141414','pattern4');
		var array_purple        = Array('#ffffff','#8b0dc8','#666666','#f1f1f1','pattern1','#141414','pattern4');
		var array_pink          = Array('#ffffff','#a31f82','#666666','#f1f1f1','pattern1','#141414','pattern4');
		
		//1.Color Blue
		$('.theme-color.blue').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_blue);
			onCPApply();
		});
		
		//2.Color Red
		$('.theme-color.red').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_red);
			onCPApply();
		});
		
		//3.Color Oranges
		$('.theme-color.oranges').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_oranges);
			onCPApply();
		});
		
		//4.Color Green
		$('.theme-color.green').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_green);
			onCPApply();
		});
		
		//5.Color Purple
		$('.theme-color.purple').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_purple);
			onCPApply();
		});
		
		//6.Color Pink
		$('.theme-color.pink').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_pink);
			onCPApply();
		});
		/* miniColorsCPanel */
		function miniColorsCPanel(elC, elT, selector){
			$(elC).miniColors({
				change: function(hex, rgb) {
					if(typeof(elT)!='string'){
						for(i=0;i<elT.length;i++){
							$(elT[i]).css(selector, hex);
						}
					}else{
						$(elT).css(selector, hex); 
					}
					createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
				}
			});
		}
		/* Begin: Set click pattern */
		function patternClick(elC, paramCookie, elT){
			$(elC).click(function(){
				oldvalue = $(this).parent().find('.active').html();
				$(elC).removeClass('active');
				$(this).addClass('active');
				value = $(this).html();
				if(elT.length > 0){
					for($i=0; $i < elT.length; $i++){
						$(elT[$i]).removeClass(oldvalue);
						$(elT[$i]).addClass(value);
					}
				}
				if(paramCookie){
					$('input[name$="ytcpanel_'+paramCookie+'"]').attr('value', value);
					createCookie(TMPL_NAME+'_'+paramCookie, value, 365);
				}
			});
		}
		function setCpanelValues(array){
			if(array['0']){
				$('.body-backgroud-color input.miniColors').attr('value', array['0']);
				$('.body-backgroud-color a.miniColors-trigger').css('background-color', array['0']);
				$('input.ytcpanel_bgcolor').attr('value', array['0']);
			}
			if(array['1']){
				$('.link-color input.miniColors').attr('value', array['1']);
				$('.link-color a.miniColors-trigger').css('background-color', array['1']);
				$('input.ytcpanel_linkcolor').attr('value', array['1']);
			}
			if(array['2']){
				$('.text-color input.miniColors').attr('value', array['2']);
				$('.text-color a.miniColors-trigger').css('background-color', array['2']);
				$('input.ytcpanel_textcolor').attr('value', array['2']);
			}
			if(array['3']){
				$('.header-backgroud-color input.miniColors').attr('value', array['3']);
				$('.header-backgroud-color a.miniColors-trigger').css('background-color', array['3']);
				$('input.ytcpanel_header-bgcolor').attr('value', array['3']);
			}
			if(array['4']){
				$('.header-backgroud-image .pattern').removeClass('active');
				$('.header-backgroud-image .pattern.'+array['4']).addClass('active');
				$('input[name$="ytcpanel_header-bgimage"]').attr('value', array['4']);
			}
			
			if(array['5']){
				$('.footer-backgroud-color input.miniColors').attr('value', array['5']);
				$('.footer-backgroud-color a.miniColors-trigger').css('background-color', array['5']);
				$('input.ytcpanel_footer-bgcolor').attr('value', array['5']);
			}
			if(array['6']){
				$('.footer-backgroud-image .pattern').removeClass('active');
				$('.footer-backgroud-image .pattern.'+array['6']).addClass('active');
				$('input[name$="ytcpanel_footer-bgimage"]').attr('value', array['6']);
			}
		}
	});
	</script>
	<?php
}
// Show back to top
if( $yt->getParam('showBacktotop') ) { ?>
    <a id="yt-totop" class="backtotop" href="#"><i class="icon-angle-up"></i></a>

    <script type="text/javascript">
        jQuery(".backtotop").addClass("hidden-top");
			jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() === 0) {
				jQuery(".backtotop").addClass("hidden-top")
			} else {
				jQuery(".backtotop").removeClass("hidden-top")
			}
		});

		jQuery('.backtotop').click(function () {
			jQuery('body,html').animate({
					scrollTop:0
				}, 1200);
			return false;
		});
    </script>
<?php
}
?>