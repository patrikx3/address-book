var model_manager = function() {};
model_manager.prototype.constructor = model_manager;

model_manager.prototype.jform = null;
model_manager.prototype.jgrid = null;
model_manager.prototype.jpager = null;
model_manager.prototype.form_name = null;
model_manager.prototype.model = null;
model_manager.prototype.selected_id = null;
model_manager.prototype.grid_options = null;
model_manager.prototype.relationship_data = {};
model_manager.prototype.relationships = [];
model_manager.prototype.table_id = null;
model_manager.prototype.pager_id = null;

/***********************************************
 * Model management
 ***********************************************/
model_manager.prototype.index_data = function(data, id_field) {
	if (typeof id_field == 'undefined') {
		id_field = 'id';
	}
	indexed_data = {};
	for(var index = 0; index < data.length; index++) {
		var d = data[index];
		var data_key = d[id_field]
		indexed_data[data_key] = d;
	}
	var table = {};
	table.rows = indexed_data;
	table.count = data.length;
	return table;
}

model_manager.prototype.on_related_model_data_loaded = function(callback) {
	var self = this;
	
	var is_ready = function() {
		var ready = true;
		for(var index = 0; index < self.relationships.length; index++) {
			var r = self.relationships[index];
			if (typeof self.relationship_data[r.model] == 'undefined') {
				ready = false;
				break;
			}
		}
		if (ready) {
			callback.call(self);
		} else {
			setTimeout(is_ready, 10);
		}
	}
	is_ready();
}
 
model_manager.prototype.fetch_model_data = function(r) {
	var self = this;
	var url = config.app_url + 'ajax_model_interface/fetch/' + r.model + '/' + r.sort_field + '/' + r.sort_direction;
	$.ajax({
		url: url,
		success: function(data) {
			self.relationship_data[r.model] = self.index_data(data);
		}
	});
}

model_manager.prototype.fetch_related_model_data = function(complete_callback) {

	var self = this;
	
	self.relationship_data = {};
	
	for(var index = 0; index < self.relationships.length; index++) {
		var r = self.relationships[index];
		self.fetch_model_data(r);		
	}	
	self.on_related_model_data_loaded(complete_callback);
}

model_manager.prototype.delete_record = function(id, callback) {
	var self = this;
	$.ajax({
		url: config.app_url + 'ajax_model_interface/delete/' + this.model + '/' + id,
		success: function(response) {
			callback.call(self, response);
		}
	});
}

model_manager.prototype.load_record = function(id, callback) {
	var self = this;
	$.ajax({
		url: config.app_url + 'ajax_model_interface/load/' + this.model + '/' + id,
		success: function(response) {
			callback.call(self, response);
		}
	});
}

model_manager.prototype.save_record = function() {
	var self = this;
	var form_data = this.jform.find('form').formToJson();
	var data = {};
	data.data = form_data;
	$.ajax({
		url: config.app_url + 'ajax_model_interface/save/' + this.model,
		data: data,
		success: function(response) {
			self.reset_form_errors();
			if (response.validation == true) {
				self.grid_reload();
				self.set_form_editing(true);
				self.get_form_field('id').val(response.data.id);
				self.get_form_field('updated_on').val(response.data.updated_on);
				lm.alert(lang.model_manager.data_saved_message);
			} else {
				for (var key in response.validation) {
					var id = self.field_name_to_id(key);
					var input = self.jform.find('#' + id);
					if (!input.is(':visible')) {
						input = input.parent().find(input.data('error-container-selector'));
					}
					input.addClass('error');
				}
				lm.alert(lang.model_manager.data_validation_error_message);
			}
		}
	});
}


/***********************************************
 * Grid management
 ***********************************************/
model_manager.prototype.grid_has_selected = function() {
	var count = this.jgrid.find('.ui-state-highlight').length;
	if (count == 0 ) {
		lm.alert(lang.model_manager.grid_no_data_selected);
	}
	return count == 1;
}

model_manager.prototype.get_base_grid_url = function() {
	var self = this;
	var url = config.app_url + 'ajax_model_interface/jqgrid/' + self.model;
	return url;
}

model_manager.prototype.grid =  function(table_id, pager_id) {
	
	var self = this;

	self.table_id = table_id;
	self.pager_id = pager_id;
	
	var table_selector = '#' + table_id;
	var pager_selector = '#' + pager_id;

	var options = $.extend({
		add: true,
		edit: true,
		remove: true,
		column_chooser: true,
		resizable: true
	}, options);
	
	var grid_options = $.extend({
		rownumbers: true, 
		rownumWidth: 40, 
		gridview: true, 
		sortable: true,
		datatype: "json",
		rowNum: 10,
		rowList: [10, 20, 30],
		viewrecords: true,
		width: 800,
		height: '100%',
		altRows: true,					
		onSelectRow: function(id){
			self.selected_id = id;
		},
		ondblClickRow: function(id, row, col, e) {
			self.edit(self.selected_id);
		},
		loadComplete: function(){
		}	
	}, this.grid_options);

	grid_options.url = self.get_base_grid_url();
	grid_options.pager = pager_selector;
	
	this.jgrid = $(table_selector);
	this.jgrid.jqGrid(grid_options);
	
	this.jgrid.jqGrid('navGrid', pager_selector, {edit:false,add:false,del:false, search: false});
	
	if (options.add) {
		this.jgrid.jqGrid('navButtonAdd', pager_selector, {
			caption: "",
			title: lang.model_manager.grid_new_data,
			buttonicon: "ui-icon-plus",
			onClickButton: function() {
				self.add.call(self);
			}
		});
	}
	
	if (options.edit) {
		this.jgrid.jqGrid('navButtonAdd', pager_selector, {
			caption: "",
			title: lang.model_manager.grid_edit_data,
			buttonicon: "ui-icon-pencil",
			onClickButton: function() {
				if (self.grid_has_selected() ) {
					self.edit.call(self, self.selected_id);
				}
			}
		});
	}
	
	if (options.remove) {
		this.jgrid.jqGrid('navButtonAdd', pager_selector, {
			caption: '',
			title: lang.model_manager.grid_delete_data,
			buttonicon: "ui-icon-trash",
			onClickButton: function() {
				if (self.grid_has_selected() ) {
					self.remove.call(self, self.selected_id);
				}
			}
		});
	}
	
	if (options.column_chooser) {
		this.jgrid.jqGrid('navButtonAdd',pager_selector,{ 
			buttonicon: "ui-icon-key",
			caption: "", 
			title: lang.model_manager.grid_column_chooser, 
			onClickButton : function (){ 
				self.jgrid.jqGrid('columnChooser'); 
			} 
		}); 
	}

	if (options.resizable) {
		this.jgrid.jqGrid('gridResize',{minWidth:300,maxWidth:900,minHeight:80, maxHeight:600});
	}
	
};

model_manager.prototype.grid_reload = function() {
	if (this.jgrid != null) {
		this.jgrid.trigger("reloadGrid");
	}
}

/*
 * Form management
 */
model_manager.prototype.form = function(options) {
	var self = this;
	
	options = $.extend({
		autoOpen: false,
		modal: true,
		minWidth: 420
	}, options);
	
	self.jform = $('#' + this.form_name);
	self.jform.dialog(options);

	self.jform.bind('dialogclose', function(e, ui) {
		$('#tiptip_holder').hide();
	});

	var selector = '#' + self.form_name + ' [title]';
	lm.tooltip(selector, {defaultPosition: 'top', keepCursor: true, activation:'hover' });
};

model_manager.prototype.form_close = function() {
	if (this.jform != null) {
		this.jform.dialog("close");
	}
}

// callback must have callback...
model_manager.prototype.initialize_form = function(initialize_form_complete) {
	var self = this;
	
	var init = function() {
		self.reset_form();
		self.fetch_related_model_data(function() {

			initialize_form_complete.call(self);
			self.jform.find(':focus').blur();
			self.jform.dialog('open');
		});
	}
	if ($('#' + this.form_name).length == 0) {
		lm.get_form(this.form_name, function() {
			self.form(self.form_name);
			init.call(self);
		});
	} else {
		init.call(self);
	}
		
};
	
model_manager.prototype.set_form_editing = function(editing) {
	var self = this;

	var buttons_add = [
		{
			text: lang.model_manager.form_button_add_save,
			click: function() {
				self.save_record();
			}
		},
		{
			text: lang.model_manager.form_button_add_close,
			click: function() {
				$(this).dialog('close');
			}
		}
	];
	
	var buttons_edit = [
		{
			text: lang.model_manager.form_button_edit_save,
			click: function() {
				self.save_record();
			}
		},
		{
			text: lang.model_manager.form_button_edit_delete,
			click: function() {
				self.remove(self.get_form_field('id').val());
			}
		},
		{
			text: lang.model_manager.form_button_edit_close,
			click: function() {
				$(this).dialog('close');
			}
		}
	];
	

	if (editing) {
		self.jform.find('.form-read-only').show();
		self.jform.dialog('option', 'buttons', buttons_edit);
		
	} else {
		self.jform.find('.form-read-only').hide();
		self.jform.dialog('option', 'buttons', buttons_add);
	}
}

model_manager.prototype.add = function() {
	var self = this;
	this.initialize_form.call(this, function(initialize_form_complete) {
		self.set_form_editing(false);
		
		if (typeof callback != 'undefined') {
			initialize_form_complete.call(self);
		}
	});
};
	
model_manager.prototype.edit = function(id) {
	var self = this;
	this.initialize_form.call(this, function(initialize_form_complete) {

		self.set_form_editing(true);		

		self.load_record(id, function(response) {
			for(var field in response.data) {
				self.set_form_field(field, response.data[field]);
			}

			if (typeof callback != 'undefined') {
				initialize_form_complete.call(self);
			}
		})
	});
};

model_manager.prototype.remove = function (id) {
	var self = this;
	lm.confirm(lang.model_manager.confirm_delete, function() {
		self.delete_record(id, function() {
			self.grid_reload();
			self.form_close();
			lm.alert(lang.model_manager.data_deleted_message);
		});
	});
};

model_manager.prototype.field_name_to_id = function(name) {
	name = name.replace('_', '-');
	var id = this.model + '-' + name;
	return id;
}

model_manager.prototype.reset_form_errors = function() {
	this.jform.find('.error').removeClass('error');
}

model_manager.prototype.reset_form = function() {
	this.reset_form_errors();
	this.jform.find('form')[0].reset();
}

model_manager.prototype.get_form_field = function(name) {
	var id = this.field_name_to_id(name);
	return this.jform.find('#' + id);
}

model_manager.prototype.set_form_field = function(field, value) {
	var self = this;
	var field = self.get_form_field(field);
	field.val(value);
}


model_manager.prototype.populate_select_with_fetch_data = function($o, table, value_field, text_field) {
	for(var key in table.rows) {
		var data = table.rows[key];
		var value = data[value_field];
		var text = data[text_field];
		var option = $('<option></option>');
		option.val(value);
		option.append(text);
		$o.append(option);
	}
}