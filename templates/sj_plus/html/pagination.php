<?php
function pagination_list_footer($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<div class=\"list-footer\">\n";

	if ($lang->isRTL())
	{
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	}
	else
	{
		$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
	}

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";

	return $html;
}

function pagination_list_render($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<ul class=\"pagination\">";
	//$html .= '<li>&laquo;</li>';
	// Reverse output rendering for right-to-left display
	if($lang->isRTL())
	{
		$html .= $list['start']['data'];
		$html .= $list['previous']['data'];

		$list['pages'] = array_reverse( $list['pages'] );

		foreach( $list['pages'] as $page ) {
			if($page['data']['active']) {
				//  $html .= '<strong>';
			}

			$html .= $page['data'];

			if($page['data']['active']) {
				// $html .= '</strong>';
			}
		}

		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
		// $html .= '&#171;';
	}
	else
	{
		$html .= $list['start']['data'];
		$html .= $list['previous']['data'];

		foreach( $list['pages'] as $page )
		{
			if($page['data']['active']) {
				// $html .= '<strong>';
			}

			$html .= $page['data'];

			if($page['data']['active']) {
				//  $html .= '</strong>';
			}
		}

		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
		// $html .= '&#171;';

	}
	//$html .= '<li>&raquo;</li>';
	$html .= "</ul>";
	return $html;
}

function pagination_item_active(&$item) {
	if((int)$item->text > 0){
		$class=" class='link'";
	}else{
		$class="";
	}
	if(strtoupper($item->text)=='END'){
		$liclass=' class="end"';
	}else{$liclass='';}
	return "<li".$liclass.">&nbsp;<a href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a>&nbsp;</li>";
}

function pagination_item_inactive(&$item) {
	
	if((int)$item->text > 0){
		$class=" class='active'";
	}else{
		$class="";
	}
	
	return "<li>&nbsp;<span".$class."><span>".$item->text."</span></span>&nbsp;</li>";
}
?>
