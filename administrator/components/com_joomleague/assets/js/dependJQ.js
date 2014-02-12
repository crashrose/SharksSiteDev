/**
 * @copyright	Copyright (C) 2005-2014 joomleague.at. All rights reserved.
 * @license	GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

/**
 * javascript for dependant element xml parameter
 * 
 * 
 */

// add update of field when fields it depends on change.
jQuery(document).ready(function(){
	jQuery('.mdepend').click(function() {
		// rebuild hidden field list
		var sel = new Array();
		var i = 0;
		jQuery('option', this).each(function(el) {
			if (el.attr('selected')) {
				sel[i++] = el.val();
			}
		});
		jQuery(this).parent('input').val(sel.join("|"));
	});

	jQuery('.depend').each(function() {
		
		var myelement = jQuery(this);
		var depends = myelement.attr('depends');
		var prefix = getElementIdPrefix(myelement);
		

		// Attach update_depend to the change event of all elements it depends upon,
		// so that when (one of) the dependencies change, the element is refreshed. 
		depends.split(',').each(function(el) {
			jQuery('#'+prefix + el).change(function(event) {
				update_depend(myelement);
			});
		});

		// Refresh the element also after the page is loaded (to fill the element)
		update_depend(myelement);
	});
});

// update dependant element function
function update_depend(element) {
	var combo = element;
	var prefix = getElementIdPrefix(element);
	
	var required = element.attr('required') || 'false';
	required = (required=='true') ? "&required=true" : "&required=false" ;
	var selectedItems = combo.attr('current').split('|');
	var depends = combo.attr('depends').split(',');
	var dependquery = '';
	depends.each(function(str) {
		dependquery += '&' + str + '=' + jQuery('#'+prefix + str).val();
	});

	var task = combo.attr('task');
	var postStr = '';
	var url = 'index.php?option=com_joomleague&format=json&task=ajax.' + task 
			+ required + dependquery;
	
//	combo.load(url,function(response){
//		console.log(response);	
//		
//	});
	//var options = []
	console.log(url);
	jQuery.post(url, null, function(result){
			var headingLine = null;
			if (combo.attr('isrequired') == 0) {
				// In case the element is not mandatory, then first option is 'select': keep it
				// Remark : the old solution options.unshift(combo.options[0]); does not work properly
				//          It seems to result in problems in the mootools library.
				//          Therefore a different approach is taken.
				headingLine = {value: '', text: '- Select -'};
			}
			//console.log(result);
			curSelected = combo.attr('current');
			combo.empty();
			if (headingLine != null) {
		        combo.append( // Append an object to the inside of the select box
		                $("<option></option>") 
		                    .text(headingLine.text)
		                    .val(headingLine.value)
		                    );
			}
			//var resultslist = jQuery('#'+combo.attr('id')+'_chzn ul');
			
			
			result.each(function(item) {
				if (typeof item == "undefined") return;
				var sel;
				if (curSelected != null && curSelected == item.value) {
					sel = " selected ";
				}
				
		        combo.append( // Append an object to the inside of the select box
		                jQuery('<option></option>') 
		                    .text(item.text)
		                    .val(item.value)
		                    .attr('selected',sel)
		            );
		        
		        jQuery(combo).trigger('liszt:updated');
			});
			
			// Make sure to inform others who are dependent on us, so they also update
			combo.change();
			// For mdepend make sure that the hidden input is updated
			combo.click();
			
		
	
	});
	
}

/** The element IDs can be either "jform_request_" (for menu items) or "jform_params_" (for modules)
 *  This function will check if we have to do with menu items or modules, and return the right
 *  prefix to be used for element-IDs */ 
function getElementIdPrefix(el) {
	var id = el.attr('id');
	var infix = id.replace(/^jform_(\w+)_.*$/, "$1");
	return infix.match("request") ? "jform_request_" : "jform_params_";
}