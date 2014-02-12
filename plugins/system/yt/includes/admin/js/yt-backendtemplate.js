function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

!function ($) {
	$(document).ready(function(){
		/*YtTemplateBackend.switchTab();*/
		$('.nav-tabs li a').bind('click', function(){
			createCookie(TMPL_BACKEND+'_tab', $(this).attr('href').replace('#', '').replace ('_params', ''), 1);
		});
		
		
		
		/* $('#overview_params .update a.btn').bind('click', function(){
			Joomla.submitbutton('update.purge');
			Joomla.submitbutton('update.find');
			alert('dungnv');
		}); */
		
		
		
		
		['overrideLayouts'].each(function(ele) {
			var rules = $('#' + ele + '_rules');
			var textarea = $('textarea#jform_params_' + ele); //jform_params_overrideLayouts 
			//console.log(textarea.html());
			var items = textarea.html().split(" ");
			for(var i = 0; i < items.length; i++) {
				//console.log(items[i]);
				if(items[i] != "") {
					var item = new Element('div');
					//var type = items[i].split('=')[0].test(/^\d+$/) ? 'ItemID' : 'Option';
					item.innerHTML = 'ItemID: <strong>' + items[i].split('=')[0] + '</strong> - Layout: <strong>' + items[i].split('=')[1] + '</strong> <a title="Remove" href="#" class="' + ele + '_remove_rule"> x </a>';
					rules.append(item);
				}
			}
			rules.bind('click', function(e){
				var evt = new Event(e);
				//evt.stop();
				if(e.target.hasClass(ele + '_remove_rule')) {
					var parent = e.target.getParent();
					var values = parent.getElements('strong');
					textarea.text(textarea.html().replace(values[0].innerHTML + "=" + values[1].innerHTML + " ", ''));
					parent.destroy();
				}
			});
			$('#'+ ele + '_add_btn').bind('click', function(){
				var rule = document.id(ele + '_input').value + "=" + ((document.id(ele + '_select')) ? document.id(ele + '_select').value : 'enabled') + " "; //console.log(textarea.html().contains(rule));
				textareaHtml = textarea.html();
				itemID = document.id(ele + '_input').value;
				if(document.id(ele + '_input').value==''){
					alert('Please enter ItemID');
				}else if(textarea.html().contains(rule)) {
					alert('Record already exists');
				}else if(textarea.html().contains(' '+document.id(ele + '_input').value + '=') 
				   || (textarea.html().contains(document.id(ele + '_input').value + '=') && textareaHtml.indexOf(itemID)==0))
				{
					alert('ItemID: '+itemID+' already exists');
				}else {
					textarea.text(textarea.html() + rule);// += rule;
					var item = new Element('div');
					var type = document.id(ele + '_input').value.test(/^\d+$/) ? 'ItemID' : 'Option';
					var value = document.id(ele + '_input').value;
					var layout = document.id(ele + '_select') ? document.id(ele + '_select').value : '';
					item.innerHTML = 'ItemID: <strong>' + value + '</strong> - Layout: <strong>' + layout + '</strong> <a title="Remove" href="#" class="' + ele + '_remove_rule"> x </a>';
					
					rules.append(item);
				}
			});
		});
		
	});
	
	
	
	
	var YTDepend = window.YTDepend = window.YTDepend || { 	
		radio:function(el, arr){
			if(typeof(arr)!=='undefined'){
				checked = $(el+' input:first');
				checked = $(el).find('input:checked');
				value = $(checked).attr('value');
				$(el+' input').click(function(){
					value = $(this).attr('value');
					YTDepend.preparDisplay(arr, value);
					//console.log(value);
				});
				//console.log(value);
				YTDepend.preparDisplay(arr, value);
				
			}
		},
		radio2:function(el, arr){
			if(typeof(arr)!=='undefined'){
				checked = $(el+' input:first');
				checked = $(el).find('input:checked');
				value = $(checked).attr('value');
				$(el+' input').click(function(){
					value = $(this).attr('value');
					YTDepend.preparDisplay2(arr, value);
					//console.log(value);
				});
				//console.log(value);
				YTDepend.preparDisplay2(arr, value);
				
			}
		},
		preparDisplay2: function(arr, value){
			for(i=0; i <arr.length; i++){
				if(arr[i]['1']!=''){
					flag_ele = arr[i]['1'];
					break;
				}
			}
			flag_status = 0;
			for(i=0; i <arr.length; i++){
				if(arr[i]['0']==value){
					arrNew = arr[i]['1'].split(","); 
					for(j=0; j<arrNew.length; j++){
						if(flag_ele == arr[i]['1']){
							flag_status = 1;
						}
						if(arrNew[j]!='') YTDepend.diplayParentRadio(1, '#jform_params_'+arrNew[j]);
					}
				}else{
					arrNew=arr[i]['1'].split(",");
					for(j=0; j<arrNew.length; j++){
						if(arrNew[j]!='' && flag_status==0) YTDepend.diplayParentRadio(0, '#jform_params_'+arrNew[j]);
					}
				}
			}
		},
		preparDisplay: function(arr, value){
			for(i=0; i <arr.length; i++){
				if(arr[i]['0']==value){
					arrNew = arr[i]['1'].split(","); 
					for(j=0; j<arrNew.length; j++){
						if(arrNew[j]!='') YTDepend.diplayParentRadio(1, '#jform_params_'+arrNew[j]);
					}
				}else{
					arrNew=arr[i]['1'].split(",");
					for(j=0; j<arrNew.length; j++){
						if(arrNew[j]!='') YTDepend.diplayParentRadio(0, '#jform_params_'+arrNew[j]);
					}
				}
			}
		},
		diplayParentRadio:function(status, el){
			parent1 = $(el).parent().parent('.control-group');
			if($(parent1).hasClass('control-group')==false){
				parent1 = $(el).parent().parent().parent('.control-group');
			}
			if(status == 1){
				$(parent1).css('display', 'block'); //console.log('Show: '+el);
			}else{ //console.log('dungnv');
				$(parent1).css('display', 'none'); //console.log('Hide: '+el);
			}
		}
	}


}(jQuery);


