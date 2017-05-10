var layout_manager = function() {
	var self = this;
	
	self.jcontent = $('#layout-content');
	self.jconfirm = $('#layout-confirm');
	self.jbody = $('body');
	
	// history support	
	$.address.change(function(event) {  
		view = event.value.substr(1);
		if (view == '') {
			view = config.default_view
		}
		self.get_controller('view/get/' + view);
	});
		
	var settings;	
	settings = {
		type: 'POST',
		dataType: 'json'
	}	
	$.ajaxSetup(settings);
	$.blockUI.defaults.message = '<img src="' + config.base_url + 'images/ajax-loader.gif"/>';
	$.blockUI.defaults.css.border = 'none';
	$.blockUI.defaults.css.position = 'fixed';
	$.blockUI.defaults.css.right = '5px';
	$.blockUI.defaults.css.top = '5px';
	$.blockUI.defaults.css.backgroundColor = 'transparent';
	$.blockUI.defaults.css.width = 'auto';
	$.blockUI.defaults.css.left = 'auto';
	$.blockUI.defaults.css.cursor= 'default';

	$.blockUI.defaults.baseZ = 1000000;
	$.blockUI.defaults.fadeIn = 0;
	$.blockUI.defaults.fadeOut = 0;
	$.blockUI.defaults.centerX = true;
	$.blockUI.defaults.centerY = true;

	$.blockUI.defaults.overlayCSS.backgroundColor = 'transparent';
	
	$.fn.jGrowl.prototype.defaults.closerTemplate = lang.layout_manager.jgrowl_closer_template;
	$.fn.jGrowl.prototype.defaults.position = 'bottom-right';

// for now the multiselect is configured in the js

	settings = {
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		showWeek: true,
		firstDay: 1,
		autoSize: true,
		showOn: "focus",
		gotoCurrent: true,		
		dateFormat: config.date_format_jquery
	};
	$.datepicker.setDefaults( settings )

	$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	
	$('#layout-navigation').ptMenu({
		showDuration: 0,
		hideDuration: 100
	}).show();
				
};
layout_manager.prototype.constructor = layout_manager;

layout_manager.prototype.jcontent = null;
layout_manager.prototype.jconfirm = null;
layout_manager.prototype.jbody = null;

layout_manager.prototype.init = function() {
	var self = this;
	$('#locale-' + config.locale).addClass('selected');	
	self.alert(lang.layout_manager.welcome);
	self.tooltip('#layout-navigation * [title]', {defaultPosition: 'top'});
	self.tooltip('#layout-header span', {defaultPosition: 'right'});

	self.load_view_by_hash(true);
}

layout_manager.prototype.get_view_by_hash = function() {
	if (window.location.hash != '')
	{
		var view = window.location.hash.substr(1);
		return view;
	}
	return null;
}

layout_manager.prototype.load_view_by_hash = function() {
	var self = this;
	var view = self.get_view_by_hash();

	if (view == null && typeof(load_default) != 'undefined' && load_default == true) {
		view = config.default_view;
	}

	if (view != null)
	{
		self.get_view(view);
	}
}

layout_manager.prototype.tooltip = function(selector, options) {
	var op = $.extend({
		delay: 200,
		keepCursor: false,
		fadeIn: 0,
		fadeOut: 0,
		maxWidth: 500
	}, options);
	$selected = $(selector)
	$selected.tipTip(op);
	if (!op.keepCursor) {
		$selected.css('cursor', 'default');
	}
}

layout_manager.prototype.confirm = function(text, callback) {
	this.jconfirm.html(text);
	this.jconfirm.dialog({
		buttons: [
			{
				text: lang.layout_manager.confirm_yes, 
				click: function() {
					callback(); 
					$(this).dialog('destroy');
				}
			},
			{
				text: lang.layout_manager.confirm_no, 
				click: function() {
					$(this).dialog('destroy');
				}
			}
		],
		modal: true,
		closeText: lang.layout_manager.confirm_close			
	});
}

layout_manager.prototype.alert = function(text) {
	$.jGrowl(text);
};

layout_manager.prototype.get_controller = function(controller, callback, send) {
	var self = this;
	$.ajax({
		data: send,
		dataType: 'html',
		url: config.app_url + controller,
		success: function(data) {
			if (typeof callback != 'undefined') {
				callback(data);
			} else {
				self.jcontent.html(data);
			}
		}
	});
};

layout_manager.prototype.get_view = function(view, callback, send) {
	if (typeof callback == 'undefined') {
		window.location.hash = view;
	} else {
		this.get_controller('view/get/' + view, callback, send);
	}
};

layout_manager.prototype.get_form = function(view, callback, send) {
	var self = this;
	self.get_controller('view/get/' + view, function(data) {
		self.jbody.append(data);
		callback(data);
	}, send);
}

layout_manager.prototype.set_locale = function(locale) {
	$.cookie('locale', locale, { expires: 365, path: config.base_url_path});
	document.location.reload();
}
