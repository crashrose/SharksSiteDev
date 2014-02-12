// JavaScript Document

jQuery(document).ready(function($){
	$(".cp_select").each(function(){
		$(this).wrap('<div class="selectbox"/>');
		$(this).after("<span class='selecttext'></span><span class='select-arrow'></span>");
		var val = $(this).children("option:selected").text();
		$(this).next(".selecttext").text(val);
		$(this).change(function(){
		var val = $(this).children("option:selected").text();
		$(this).next(".selecttext").text(val);
		});
	}); 
	
	/* Begin: Show o hide cpanel */  
	$('#cpanel_btn').click(function(){
		widthC = $('#cpanel_wrapper').width()+20;
		if($('#cpanel_btn i').attr('class') == 'icon-hand-left'){
			$('#cpanel_wrapper').animate({
				'right':-widthC
			}, 200, function(){
				$('#cpanel_wrapper').show().animate({
					'right':'0px'
				});
			});
		
			$("#yt_wrapper").addClass("expanded")
			$('#cpanel_btn i').attr('class', 'icon-hand-right');
		}else if($('#cpanel_btn i').attr('class')=='icon-hand-right'){
			$('#cpanel_wrapper').animate({
				'right':'0px'  
			}, 200, function(){
				$('#cpanel_wrapper').show().animate({
					'right':-widthC
				});
			});
			$("#yt_wrapper").removeClass("expanded")
			$('#cpanel_btn i').attr('class', 'icon-hand-left');
		}
	});
	/* End: Show o hide cpanel */
	
	$("#ytcpanel_accordion .accordion-group").each(function() {
		if($(this).index() > 1) {
			$(this).children(".collapse").css('height', '0');
		}
		else {
			$(this).find(".accordion-heading").addClass('active');
		}
		$(this).children(".accordion-heading").bind("click", function() {
			$(this).addClass(function() {
				if($(this).hasClass("active")) return "";
				return "active";
			});
	
			$(this).parent().siblings(".accordion-group").find(".accordion-heading.active").removeClass("active");
		});
	});
	
	
	$("#cpanel_wrapper span,#cpanel_wrapper a, .hasTooltip").tooltip({
                  'selector': '',
                  'placement': 'top'
                });
	$(".switch-layout").tooltip({
			  'selector': '',
			  'placement': 'left'
			});
	$("[rel^='tooltip']").tooltip({
			  'selector': '',
			  'placement': 'top'
			});
			
	// animate		
	$(".yt-socialbt2 a").hover(function() {
        $(this).addClass("animated bounce");
		},function(){
		$(this).removeClass("animated bounce");
    });
	
});

function onCPResetDefault(_cookie){
	for (i=0;i<_cookie.length;i++) { 
		if(getCookie(TMPL_NAME+'_'+_cookie[i])!=undefined){
			createCookie (TMPL_NAME+'_'+_cookie[i], '', -1);
		}
	}
	window.location.reload(true);
}

function onCPApply () {
	var elems = document.getElementById('cpanel_wrapper').getElementsByTagName ('*');
	var usersetting = {};
	for (i=0;i<elems.length;i++) {
		var el = elems[i]; 
	    if (el.name && (match=el.name.match(/^ytcpanel_(.*)$/))) {
	        var name = match[1];	        
	        var value = '';
	        if (el.tagName.toLowerCase() == 'input' && (el.type.toLowerCase()=='radio' || el.type.toLowerCase()=='checkbox')) {
	        	if (el.checked) value = el.value;
	        } else {
	        	value = el.value;
	        }
			if(value.trim()){
				if (usersetting[name]) {
					if (value) usersetting[name] = value + ',' + usersetting[name];
				} else {
					usersetting[name] = value;
				}
			}
	    }
	}
	
	for (var k in usersetting) {
		name = TMPL_NAME + '_' + k; //alert(name);
		value = usersetting[k];
		createCookie(name, value, 365);
	}
	
	window.location.reload(true);
}