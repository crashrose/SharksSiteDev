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
# Accordion Block
add_shortcode('accordion', 'accordionShortcode');
function accordionShortcode($atts, $content = null){
	$accordion = "<ul class='yt-accordion'>";
	$accordion = $accordion . parse_shortcode(str_replace(array("<br/>", "<br>", "<br />"), " ", $content));
	$accordion = $accordion . "</ul>";

	return $accordion;
}

add_shortcode('acc_item', 'accItemShortcode');
function accItemShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"title" => ''
	), $atts));

	$acc_item = "<li class='accordion-group'>";
	$acc_item = $acc_item . "<h3 class='accordion-heading'>";
	$acc_item = $acc_item . "<i class='icon-plus-sign'></i>";
	$acc_item = $acc_item . $title . "</h3>";
	$acc_item = $acc_item . "<div class='accordion-inner'>" . parse_shortcode($content) . "</div>";
	$acc_item = $acc_item . "</li>";

	return $acc_item;
}


# Block Quote Block
add_shortcode('quote', 'blockquoteShortcode');
function blockquoteShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"title" => '',
		"align" => 'none',
		'border'=>'#666',
		'color'=>'#666',
		'width'=>'auto',
	), $atts));
	$source_title = (($title != '') ? "<small>".$title. "</small>" : '');
	return '<blockquote class="yt-boxquote pull-'. $align.'" style="width:'.$width.';border-color:'.$border.';color:'.$color.'">' . $content . $source_title. '</blockquote>';
}


# Buttons Block
add_shortcode('button', 'buttonShortcode');
function buttonShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"type"	=> '',
		"size" 	=> '',
		"full" 	=> '',
		"icon" 	=> '',
		"link" 	=> '#',
		"radius" 	=> '3',
		"target" 	=> '',
		"state" => 'Enable',
	), $atts));
	$btn_icon = '<i class="'.(($icon != '') ? 'icon-' . $icon : '').'"></i>';

	return '<a class="btn'.
			(($type != '') ? ' btn-' . $type : '').
			(($size != '') ? ' btn-' . $size : '') .
			(($full != '') ? ' btn-' . $full : '') .
			(($state == 'Disabled'|| $state == 'disabled') ? ' disabled' : '') .
			'" style="border-radius:'.$radius.'px;" href="'.$link.'" target="'.$target.'">'.$btn_icon. $content.'</a>';
}


# Columns Block
add_shortcode('columns', 'columnsShortcode');
function columnsShortcode($atts, $content = null ){
	extract(shortcode_atts(array(
		"background" => '#eee'
	), $atts));
	if($background != '') {
		global $col_background;
		$col_background = $background;
	}
	return '<div class="yt-grid row-fluid ">' . parse_shortcode(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) . '</div>';
}

# Column Block
add_shortcode('column_item', 'columnItemShortcode');
function columnItemShortcode($atts, $content = null ){
	extract(shortcode_atts(array(
		"col" => 4,
		"offset" => '',
	), $atts));
	global $col_background;
	return '<div  style="'.(($col_background != '') ? ' background:' . $col_background : '').'"class="span'. $col . (($offset != '') ? ' offset' . $offset : '') .'">' . $content . '</div>';
}


# Dropcap Block
add_shortcode('dropcap', 'dropcapShortcode');
function dropcapShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"type" 			=> 'none',
		"color" 		=> '#333',
		"background"	=> 'none'
	), $atts));

	return '<div class="yt-dropcap ' . $type . '" style="color:'. $color .'; background-color:' . $background . ';">' . $content . '</div>';
}


# Gallery Block
$gwidth  = 100;
$gheight = 100;

add_shortcode('gallery', 'galleryShortcode');
function galleryShortcode($atts, $content = null){
	global $gwidth, $gheight, $gcolumns;

	extract(shortcode_atts(array(
		"title" 	=> '',
		"width"		=> 100,
		"height"	=> 100,
		"columns"	=> 3
	), $atts));

	$gwidth  = $width;
	$gheight = $height;
	$gcolumns = $columns;
	//(($startnums && $linenums == 'Yes' ) ? ':' . $startnums : '')
	$gallery = '';
	$gallery .= '<div class="yt-gallery clearfix">';
	$gallery .= ($title !='')? '<h3 class="gallery-title">' . $title . '</h3>' : '' ;
	$gallery .= '<ul class="gallery-list clearfix">' . parse_shortcode(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) . '</ul>';
	$gallery .= '</div>';

	return $gallery;
}

add_shortcode('gallery_item', 'galleryItemShortcode');
function galleryItemShortcode($atts, $content = null){
	global $gwidth, $gheight, $gcolumns;
	//var_dump( $gheight);die();
	extract(shortcode_atts(array(
		"title" => '',
		"src"	=> '',
		"video_addr" => ''
	), $atts));

	if(strpos($video_addr, 'youtube.com')){
		$src_pop = $video_addr;
		if($src=="" || !is_file($src)) $src = 'plugins/system/ytshortcodes/assets/images/youtube.png';
	}elseif(strpos($video_addr, 'vimeo.com')){
		$src_pop = $video_addr;
		if($src=="" || !is_file($src)) $src = 'plugins/system/ytshortcodes/assets/images/vimeo.jpg';
	}else{
		$src_pop = "";
	}
	$src = (is_file($src))?$src:'plugins/system/ytshortcodes/assets/images/no-image.png';
	$src = (strpos($src, "http://") === false) ? JURI::base() . $src : $src;
	if($src_pop ==""){
		$src_pop = $src;
	}
	YTTemplateUtils::getImageResizerHelper(array(
		'background' => '#ffffff',
		'thumbnail_mode' => 'fill'
		)
	);
	$simage = YTTemplateUtils::resize($src, $gwidth, $gheight, array('#ffffff'));

	$gallery_item = "<li class='masonry-brick' style='width:".  floor(100/$gcolumns)."%;'>";
	$gallery_item .="<div class='item-gallery'>";
	$gallery_item .= "<div class='item-gallery-hover'></div>";
	$gallery_item .= "<a title='" . $title . "' href='" . $src_pop . "' data-rel='prettyPhoto[bkpGallery]'>";
	$gallery_item .= "<h3 class='item-gallery-title'>". $title ."</h3><div class='image-overlay'></div>";
	$gallery_item .= "<img src='" . $simage . "' title='" . $title . "' alt='" . $title . "' />";
	$gallery_item .= "</a>";
	$gallery_item .= "</div>";
	$gallery_item .= "</li>";

	return str_replace("<br/>", " ", $gallery_item);
}


# Lightbox Block
add_shortcode('lightbox', 'lightboxShortcode');
function lightboxShortcode($atts){
	JHtml::_('behavior.modal', 'a.modal');
	extract(shortcode_atts(array(
		"src"		=> '#',
		"width"		=> 'auto',
		"height"	=> 'auto',
		"title"		=> '',
		'align'		=> 'none',
		'lightbox'	=> 'on',
		'border'	=> ''
	), $atts));

	$src   =  (strpos($src, "http://") === false) ? JURI::base() . $src : $src;
	$border  = ($border == "No" || $border == "no") ? "no-border" : " " ;
	
	YTTemplateUtils::getImageResizerHelper(array(
		'background' => '#ffffff',
		'thumbnail_mode' => 'fill'
		)
	);
	if($width != "auto" && $height != "auto") {
		$isrc = YTTemplateUtils::resize($src, $width , $height, array('#ffffff'));
	}

	$frame = "<img src='" . $isrc . "' alt='" . $title . "' />";
	//$titles="<h3 class='img-title'>". $title ."</h3> ";
	$titles = ($title != '') ? "<h3 class='img-title'>". $title ."</h3>" : '';
	if($lightbox == 'On' || $lightbox == 'on') {
		$frame = "<a href='" . $src . "' data-rel='prettyPhoto' title='" . $title . "' >" . $frame . $titles. "</a>";
	}

	$frame = "<div class='yt-lightbox curved  image-". $align." ".$border."'>" . $frame . "</div>";

	return $frame;
}


# List Block
add_shortcode('list', 'listShortcode');
function listShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"type" => 'check',
		"color" => ''
	), $atts));
	if($color != '') {
		global $list_color;
		$list_color = $color;
	}
	$color =(($color != '')? 'color:'.$color : "");
	return '<ul class="yt-list type-' . $type . '" style="'.$color.'">'. parse_shortcode(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) . '</ul>';
}

add_shortcode('list_item', 'listItemShortcode');
function listItemShortcode($atts, $content = null ){
	global $list_color;
	extract(shortcode_atts(array(
		"offset" => ''
	), $atts));
	if($list_color!=''){
		return '<li ><span>' . $content . '</span></li>';
	}else{
		return '<li >' . $content . '</li>';
	}
}

# List Icons
add_shortcode('icon', 'iconShortcode');
function iconShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"name" => 'twitter',
		"size" => '',
		"color" => '',
		"align"=> ''
	), $atts));

	return '<i class="icon-'.$name." pull-".$align.' " style="font-size:'.$size.'px;color:'.$color.';"></i>';
}

# Message Block
add_shortcode('message_box', 'messageBoxShortcode');
function messageBoxShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"title" =>'',
		"type" =>'error',
		"close" => "Yes",

	), $atts));

	$message_box = '<div class="alert alert-block alert-'.$type.' fade in">';
	$message_box .= ($close == "Yes" || $close == "yes")
				  ? '<button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>'
				  : "";
	$message_title=(($title != '')? '<h3 class="alert-heading">' . $title . '</h3>' : "");

	$message_box = $message_box . $message_title;
	$message_box = $message_box . '<div class="alert-content">' . $content . '</div>';
	$message_box = $message_box . '</div>';

	return $message_box;
}


# Social Block
add_shortcode('social', 'socialShortcode');
function socialShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"title" =>'',
		"type" 		=> 'facebook',
		"size"	=> 'default',
		"style"	=> '',
		"color"	=> ''
	), $atts));
	$social_title=(($title != '')? '<span>' . $title . '</span>' : "");
	$class_title =(($title != '')? 'text' : "");
	$social_color=(($color == "Yes" || $color == "yes")? 'color' : "");

	$social = '<div class="yt-socialbt"><a rel="tooltip" target="_blank" class="sb '.$type." ". $size." ".$class_title." ".$style." ".$social_color.'" title="' . $type . '" href="' . $content . '">';
	$social = $social . '<i class="icon '.$type.'"></i>'.$social_title.' </a></div>';

	return $social;
}


# Tabs Block
$tab_array = array();
add_shortcode('tabs', 'tabShortcode');
function tabShortcode($atts, $content = null){
	global $tab_array;
	global $index_tab;
	extract(shortcode_atts(array(
		"style"	=> '',
		"type"	=> ''
	), $atts));

	parse_shortcode($content);
	$tabs_style =(($style != '')? "style-".$style : "");
	$num = count($tab_array);
	$tab = "<div class='yt-tabs ".$tabs_style." ".$type."'><ul class='nav-tabs'>";

	for($i = 0; $i < $num; $i ++) {
		$active = ($i == 0) ? 'active' : '';
		$tab_id = str_replace(' ', '-', $tab_array[$i]["title"]);

		$tab = $tab . '<li><a href="#' . $tab_id  . $index_tab . '" class="';
		$tab = $tab . $active .'" >' . $tab_array[$i]["title"] . '</a></li>';
	}

	$tab = $tab . "</ul>";
	$tab = $tab . "<div class='tab-content'>";

	for($i = 0; $i < $num; $i ++) {
		$active = ($i == 0) ? 'active' : '';
		$tab_id = str_replace(' ', '-', $tab_array[$i]["title"]);

		$tab = $tab . '<div id="' . $tab_id . $index_tab . '" class="clearfix ';
		$tab = $tab . $active . '" >' . $tab_array[$i]["content"] . '</div>';
	}
	$index_tab ++;
	$tab = $tab . "</div></div>";
	$tab_array= array();
	return $tab;
}
add_shortcode('tab_item', 'tabItemShortcode');
function tabItemShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"title" => '',

	), $atts));

	global $tab_array;

	$tab_array[] = array("title" => $title , "content" => parse_shortcode($content));
}


# Testimonial Block
add_shortcode('testimonial', 'testimonialShortcode');
function testimonialShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"author" => '',
		"position" => '',
		"avatar" => '',
		"style" => ''
	), $atts));
	
	$testimonial_avatar = '<div class="testimonial-avatar">' ;
	if($avatar != '') {$testimonial_avatar .='<img src="' . $avatar . '"/> ';}
	$testimonial_avatar .= '<small class="testimonial-author">';
	$testimonial_avatar .= '<i class="icon-user"></i>' . $author . ', ';
	$testimonial_avatar .= '<cite class="testimonial-author-position">' . $position . '</cite>';
	$testimonial_avatar .= '</small>';
	$testimonial_avatar .= '</div>';
	$testimonial = '<blockquote class="yt-testimonial '.(($avatar != '')? 'tm-avatar '.$style : " ").'">';
	$testimonial .= '<p>' .$content. '</p>';
	$testimonial .= $testimonial_avatar;
	$testimonial .= '</blockquote>';
	
	return $testimonial;
}


# Toggle Block
add_shortcode('toggle_box', 'toggleBoxShortcode');
function toggleBoxShortcode($atts, $content = null){
	$toggle_box = "<ul class='yt-toggle-box'>";
	$toggle_box = $toggle_box . parse_shortcode(str_replace(array("<br/>", "<br>", "<br />"), " ", $content));
	$toggle_box = $toggle_box . "</ul>";

	return $toggle_box;
}
add_shortcode('toggle_item', 'toggleItemShortcode');
function toggleItemShortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		"title"  => '',
		"icon"  => '',
		"active"  => ''
	), $atts));
	//echo 'dung: '; var_dump($active); echo '<br/>';
	$toggle_active=((strtoupper($active) == 'YES') ? 'active' : '');
	$icon_active=(($icon !='')? '<i class="icon-'.$icon.'"></i>' :'');
	
	$toggle_item = "<li class='yt-divider'>";
	$toggle_item = $toggle_item . "<h3 class='toggle-box-head ".$toggle_active."'>";
	$toggle_item = $toggle_item . $icon_active;
	$toggle_item = $toggle_item . "<span></span>"; 
	$toggle_item = $toggle_item . $title . "</h3>";
	$toggle_item = $toggle_item . "<div class='toggle-box-content ".$toggle_active."'>" . parse_shortcode($content) . "</div>";
	$toggle_item = $toggle_item . "</li>";

	return $toggle_item;
}


# Vimeo Block
add_shortcode('vimeo', 'vimeoShortcode');
function vimeoShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"height" => '300',
		"width"  => '400',
		"align"  => 'none',
	), $atts));

	preg_match('/http:\/\/vimeo.com\/(\d+)$/', $content, $id);

	$vimeo = '<div class="yt-vimeo pull-'.$align.'" style="max-width:' . $width . 'px;" >';
	$vimeo = $vimeo . '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" ></iframe>';
	$vimeo = $vimeo . '</div>';

	return $vimeo;
}

# Youtube
add_shortcode('youtube', 'youtubeShortcode');
function youtubeShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"height" => '400',
		"width"  => '300',
		"align"  => 'none'
	), $atts));

	preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $content, $id);

	$youtube = '<div class="yt-youtube pull-'.$align.'" style="max-width:' . $width . 'px;" >';
	$youtube = $youtube . '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent" width="' . $width . '" height="' . $height . '" frameborder="0" allowfullscreen></iframe>';
	$youtube = $youtube . '</div>';

	return $youtube;
}

# Divider
add_shortcode('divider', 'dividerShortcode');
function dividerShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"type" => '',
		"margin" => '',
	), $atts));

	$divider = '<div class="yt-divider '.$type.'" style="margin:'.$margin.'"></div>';

	return $divider;
}


# Space
add_shortcode('space', 'spaceShortcode');
function spaceShortcode($atts){
	extract(shortcode_atts(array(
		"height" => '20'
	), $atts));

	return "<div style='clear:both; height:" . $height . "px;' ></div>";
}

# Clear Floated 
add_shortcode('clear', 'clearShortcode');
function clearShortcode($atts){
	extract(shortcode_atts(array(
		"height" => '20'
	), $atts));

	return "<div class='clearfix' ></div>";
}

# Line Break
add_shortcode('br', 'brShortcode');
function brShortcode($atts){
	extract(shortcode_atts(array(
		"height" => '20'
	), $atts));

	return "</br>";
}

# Google fonts
add_shortcode('googlefont', 'googlefontShortcode');
function googlefontShortcode($atts, $content = null){
	extract(shortcode_atts(array(
		"font" => '',
		"size" => '',
		"color" => '',
		"align" => '',
		"font_weight" => '',
		"margin" => '',
	), $atts));
	$style = " style='";
	if($font!="")
		$style .= "font-family:{$font};";

	if($size!="")
		$style .= "font-size:{$size}px;";
	if($color!="")
		$style .= "color:{$color};";
	if($font_weight!="")
		$style .="font-weight:{$font_weight};";
	if($align!="")
		$style .="text-align:{$align};";
	if($margin!="")
		$style .="margin:{$margin};";

	$style .="'";
	$googlefont ="<link href='http://fonts.googleapis.com/css?family={$font}' rel='stylesheet' type='text/css'>";
	$googlefont .= '<h3 class="googlefont"'.$style.'>'.$content.'</h3>';

	return $googlefont;
}


# SyntaxHighlighter
add_shortcode('highlighter', 'highlighterShortcode');
function highlighterShortcode($atts, $content){
	$text    = '';
	$script  = '';

	extract(shortcode_atts(array(
			"label"		=> '',
			"linenums" 	=> 'Yes',
			"startnums" => 0
			
	), $atts));
	$highli_lang=(($label != '') ? '' . $label : '');
	$text = '<pre title="'.$highli_lang.'"class="highlighter prettyprint '.(($linenums == 'Yes' || $linenums == 'yes' ) ? ' linenums' : '')
		  . (($startnums && $linenums == 'Yes' || $startnums && $linenums == 'yes') ? ':' . $startnums : '').'">'
		  . $content
		  . '</pre>'
		  . $script;

	return $text;
}


# Pricing Tables
$pcolumns = 3;
add_shortcode('pricing', 'pricingShortcode');
function pricingShortcode($atts, $content = null ){
	global $pcolumns;

	extract(shortcode_atts(array(
		"columns" 			=> '3',
		"width" 		=> '',
		"style" 		=> ''
	), $atts));

	$pcolumns	= $columns;
	$class 		= 'yt-pricing block col-' . $columns.' pricing-'.$style;

	return '<div class="'.$class.'"  style="width:'.$width.';" >' . parse_shortcode(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) . '</div>';
}


# Pricing Tables
add_shortcode('plan', 'planLineShortcode');
function planLineShortcode($atts, $content = null ){
	global $pcolumns;

	extract(shortcode_atts(array(
		"title" 		=> '',
		"button_link" 	=> '',
		"button_label" 	=> '',
		"price" 		=> '',
		"featured" 		=> '',

		"per"			=> 'month',
	), $atts));

	return  '<div class="column span' . round(12/$pcolumns) . (('true' == strtolower($featured)) ? ' featured' : '') .'">' .
				'<div class="pricing-basic"><span>' . $title . '</span></div>' .
				'<div class="pricing-money block"><h2>' . $price . '</h2><h4 >per ' . $per . '</h4></div>' .
				parse_shortcode(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) .
				'<div class="pricing-bottom"><a class="signup" href="' . $button_link . '">' . $button_label . '</a></div>' .
			 '</div>';
}