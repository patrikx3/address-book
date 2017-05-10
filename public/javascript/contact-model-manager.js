var contact_model_manager = function() {
	
	var self = this;

	self.model = 'contact';
	self.form_name = 'contact-form';
	
	self.relationships= [{
		model: 'category', sort_field: 'title', sort_direction: 'asc'
	}];
	
	self.grid_options = $.extend(self.grid_options, {
		colNames: [
			lang.contact_model_manager.column_id, 
			lang.contact_model_manager.column_name, 
			lang.contact_model_manager.column_email, 
			lang.contact_model_manager.column_phone, 
			lang.contact_model_manager.column_created, 
			lang.contact_model_manager.column_updated
		],
		colModel: [
			{name: lang.contact_model_manager.column_id, index: 'id', width: 55, hidden: true },
			{name: lang.contact_model_manager.column_name, index: 'name', width: 90 },
			{name: lang.contact_model_manager.column_email, index: 'email', width: 90, formatter: function(value, options, cellobject) {
				return '<a href="mailto:' + value + '">' + value + '</a>';
			}},
			{name: lang.contact_model_manager.column_phone, index: 'phone', width: 90 },
			{name: lang.contact_model_manager.column_created, index: 'created_on', width: 60 },
			{name: lang.contact_model_manager.column_updated, index: 'updated_on', width: 60 },
		],
		sortname: 'name',
		sortorder: "asc",
		caption: lang.contact_model_manager.grid_title,
		toolbar: [true,"top"]
	});
};

contact_model_manager.prototype = new model_manager;
contact_model_manager.prototype.constructor = contact_model_manager;

contact_model_manager.prototype.reset_grid = function() {
	var self = this;
	self.grid_reload();
	self.reset_toolbar();
}

contact_model_manager.prototype.reset_toolbar = function() {
	var self = this;

	var toolbar = $('#t_' + self.table_id);

	toolbar.css('textAlign', 'right');
	toolbar.empty();
	toolbar.append(lang.contact_model_manager.category_filter);

	var create_toolbar_category_filter = function() {

		var table = self.relationship_data['category'];

		var select = $('<select></select>');
		select.css('minWidth', '200px');
		select.css('marginLeft', '5px');
		select.attr('id', 'category-filter');
		
		var opt = $('<option></option>');
		opt.val('');
		opt.html(lang.contact_model_manager.category_filter_all);
		select.append(opt);

		opt = $('<option></option>');
		opt.val('na');
		opt.html(lang.contact_model_manager.category_filter_uncategorized);
		select.append(opt);

		self.populate_select_with_fetch_data(select, table, 'id', 'title');

		select.change(function() {
			self.jgrid.jqGrid('setGridParam', {
				url: self.get_base_grid_url() + '/category/' + select.val()
			});
			self.grid_reload();
		});

		toolbar.append(select);
	}

	self.fetch_related_model_data(create_toolbar_category_filter);	
}

contact_model_manager.prototype.grid = function(table_id, pager_id) {
	var self = this;
	
	model_manager.prototype.grid.call(self, table_id, pager_id);
	self.reset_toolbar();
}

contact_model_manager.prototype.load_record = function(id, callback) {
	var self = this;
	model_manager.prototype.load_record.call(this, id, function(response) {
		callback.call(self, response);
		var field = self.get_form_field('category');
		field.val(response.relationships.category);
		field.multiselect('destroy');
		field.multiselect();
	});	
}

contact_model_manager.prototype.add = function() {
	var self = this;
	model_manager.prototype.add.call(this, function() {
		var date = $.datepicker.formatDate( config.date_format_jquery, new Date());
		self.set_form_field('created_on', date);
	});
}

contact_model_manager.prototype.form = function() {
	model_manager.prototype.form.call(this, {minWidth: 460, minHeight: 470});
}

contact_model_manager.prototype.initialize_form = function(initialize_form_complete) {
	var self = this;
	model_manager.prototype.initialize_form.call(this, function() {		
		initialize_form_complete.call(self);
		var categories = self.relationship_data.category;
		
		var select = self.jform.find('#contact-category');
		select.html('');
		select.multiselect('destroy');
		if (categories.count == 0) {
			$('#contact-category-ui').hide();
			$('#contact-category-none').show();
		} else {
			self.populate_select_with_fetch_data( select, categories, 'id', 'title');
			select.multiselect();
			select.data('error-container-selector', '.ui-multiselect');
			$('#contact-category-ui').show();
			$('#contact-category-none').hide();
		}
	});
}
