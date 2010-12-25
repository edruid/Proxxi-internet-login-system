var display_list=new Array();

function toggle(id) {
	var elem=document.getElementById(id);
	if(elem.style.display=='none') {
		elem.style.display=display_list[id];
	} else {
		display_list[id]=elem.style.display;
		elem.style.display='none';
	}
}

function set_display(id,value) {
	display_list[id]=value;
}

function set_focus(id) {
	var elem=document.getElementById(id);
	elem.focus();
}

function ajax_create() {
	var xmlHttp;
	try {
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e) {
		// Internet Explorer
		try {
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {
				//alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	return xmlHttp;
}

function toggle_disable(element, enabled) {
	if(enabled) {
		element.disabled = "";
	} else {
		element.disabled = "disabled";
	}
}

function toggle_hidden(node) {
	if(node.className.match(/\bhidden\b/)){
		node.className = node.className.replace(/\bhidden\b/, '');
	} else {
		node.className += ' hidden';
	}
}

function fieldset_hider() {
	var legends = document.getElementsByTagName('legend');
	for(var i=0; i<legends.length; ++i) {
		legends[i].onclick = function() {toggle_hidden(this.parentNode)};
	}
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof oldonload != 'function') {
		window.onload = func;
	} else {
		window.onload = function() {
			if (oldonload) {
				oldonload();
			}
			func();
		}
	}
}

addLoadEvent(fieldset_hider);

function fixPersonnummer(date_elem, id_elem) {
	var date_part = date_elem.value;
	var id_part = id_elem.valueM
	if(date_part.match(/^\d+$/)) {
		if(date_part.length == 8) {
			date_part=date_part.substring(0,4)+'-'+date_part.substring(4,6)+'-'+date_part.substring(6,8);
			date_elem.value = date_part;
			return;
		} else if(date_part.length == 6) {
			var year = date_part.substring(0,2);
			var this_year = (new Date()).getFullYear()+'';
			var cen = this_year.substring(0,2);
			this_year = this_year.substring(2,4);
			if(year > this_year) {
				cen--;
			}
			date_part = cen+year+'-'+date_part.substring(2,4)+'-'+date_part.substring(4,6);
			date_elem.value = date_part;
			return;
		}
	}
}

