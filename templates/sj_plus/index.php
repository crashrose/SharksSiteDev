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
// Check yt plugin
if(!defined('YT_FRAMEWORK')){
	throw new Exception(JText::_('INSTALL_YT_PLUGIN'));
}
if(!defined('J_TEMPLATEDIR')){
	define('J_TEMPLATEDIR', JPATH_SITE.J_SEPARATOR.'templates'.J_SEPARATOR.$this->template);
}

// Include file: frame_inc.php
include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'frame_inc.php');
// Check direction for html
$dir = ($yt->getParam('direction') == 'rtl') ? ' dir="rtl"' : '';
?>
<!DOCTYPE html>
<html<?php echo $dir; ?> lang="<?php echo $this->language; ?>">
<head>
	<jdoc:include type="head" />
	<?php
	$browser = new Browser(); ?>
    <meta name="HandheldFriendly" content="true"/>
	<meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <?php if ($browser->getBrowser()== Browser::BROWSER_IPHONE ){?>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-touch-fullscreen" content="yes" />
    <?php }
	// Include css, js
	include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'head.php');
	?>
</head>
<?php
	//
	$cls_body = '';
	//render a class for home page
	$cls_body .= $yt->isHomePage() ? 'homepage ' : '';
	//add a class for each component
	$cls_body .= (JRequest::getVar('option')!= null) ? JRequest::getVar('option') .' ' : '';
	//add a view class which helps you easy to style
	$cls_body .= (JRequest::getVar('view')!= null) ? 'view-' . JRequest::getVar('view') . ' ' : '';
	//for stype. With each style, we will use one class
	$cls_body .= $yt->getParam('templateColor').' ';
	//for RTL direction
	$cls_body .= ($yt->getParam('direction') == 'rtl') ? 'rtl' . ' ' : '';
	//add a class according to the template name
	$cls_body .= $yt->template. ' ';
	
	$cls_body .= 'layout_'.$layout. ' ';
	// class slideshow
	$cls_body .=  ($doc->countModules('slideshow'))?'':'no-slider ';
	$cls_body .=  ' yt-jv'.J_VERSION;
?>
<body id="bd" class="<?php echo $cls_body; ?>" onLoad="prettyPrint()">
	<jdoc:include type="modules" name="debug" />
	<section id="yt_wrapper">
		<a id="top" name="scroll-to-top"></a>
		<?php
		/*render blocks. for positions of blocks, please refer layouts folder. */
		foreach($yt_render->arr_TB as $tagBD) {
			//BEGIN Check if position not empty
			if( $tagBD["countModules"] > 0 ) {
				// BEGIN: Content Area
				if( ($tagBD["name"] == 'content') ) {
					//class for content area
					$cls_content  = $tagBD['class_content'];
					$cls_content  .= ' block';
					echo "<{$tagBD['html5tag']} id=\"{$tagBD['id']}\" class=\"{$cls_content}\">";
					?>
						<div class="yt-main">
							<div class="yt-main-in1 container">
								<div class="yt-main-in2 row-fluid">
        							<?php
									$countL = $countR = $countM = 0;
									// BEGIN: foreach position of block content
									// IMPORTANT: Please do not edit this block
									foreach($tagBD['positions'] as $position):
										include(J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'block-content.php');
									endforeach;
									// END: foreach position of block content
									?>
								</div>
							</div>
						</div>
                    <?php
					echo "</{$tagBD['html5tag']}>";
					?>
					<?php
				// END: Content Area
				// BEGIN: For other blocks
				} elseif ($tagBD["name"] != 'content'){
                    echo "<{$tagBD['html5tag']} id=\"{$tagBD['id']}\" class=\"block\">";
					?>
						<div class="yt-main">
							<div class="yt-main-in1 container">
								<div class="yt-main-in2 row-fluid">
								<?php
								if( !empty($tagBD["hasGroup"]) && $tagBD["hasGroup"] == "1"){
									// BEGIN: For Group attribute
									$flag = '';
									$openG = 0;
									$c = 0;
									foreach( $tagBD['positions'] as $posFG ):
										$c = $c + 1;
										if( $posFG['group'] != "" && $posFG['group'] != $flag){
											$flag = $posFG['group'];
											if ($openG == 0) {
												$openG = 1;
												$groupnormal = 'group-' . $flag.$tagBD['class_groupnormal'];
												echo '<div class="' . $groupnormal . ' ' . $yt_render->arr_GI[$posFG['group']]['class'] . '">' ;
												echo $yt->renPositionsGroup($posFG);
												if($c == count( $tagBD['positions']) ) {
													echo '</div>';
												}
											} else {
												$openG = 0;
												$groupnormal = 'group-' . $flag;
												echo '</div>';
												echo '<div class="' . $groupnormal . ' '. $yt_render->arr_GI[$posFG['group']]['class'] . '">' ;
												echo $yt->renPositionsGroup($posFG);
											}
										} elseif ($posFG['group'] != "" && $posFG['group'] == $flag){
											echo $yt->renPositionsGroup($posFG);
											if($c == count( $tagBD['positions']) ) {
												echo '</div>';
											}
										}elseif($posFG['group']==""){
											if($openG ==1){
												$openG = 0;
												echo '</div>';
											}
											echo $yt->renPositionsGroup($posFG);
										}
									endforeach;
									// END: For Group attribute
								}else{ 
									// BEGIN: for Tags without group attribute
									if(isset($tagBD['positions'])){
										echo $yt->renPositionsNormal($tagBD['positions'], $tagBD["countModules"]);
									}
									// END: for Tags without group attribute
								}
								?>
								</div>
							</div>
						</div>
                    <?php
					echo "</{$tagBD['html5tag']}>";
					?>
			<?php
			   }
			   // END: For other blocks
			}
			// END Check if position not empty
		}
		//END: For
		?>
        <?php
		include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'special-position.php');
		include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'bottom.php');
		?>
	</section>
</body>
</html>