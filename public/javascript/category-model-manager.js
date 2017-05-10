var category_model_manager = function() {

	this.model = 'category';
	this.form_name = 'category-form';
	
	this.grid_options = $.extend(this.grid_options, {
		colNames: [
			lang.contact_model_manager.column_id, 
			lang.contact_model_manager.column_name, 
			lang.contact_model_manager.column_updated
		],
		colModel: [
			{name: lang.contact_model_manager.column_id, index: 'id', width: 55, hidden: true },
			{name: lang.contact_model_manager.column_name, index: 'title', width: 90 },
			{name: lang.contact_model_manager.column_updated, index: 'updated_on', width: 60 },
		],
		sortname: 'title',
		sortorder: "asc",
		caption: lang.contact_model_manager.grid_title	
	});
};

category_model_manager.prototype = new model_manager;
category_model_manager.prototype.constructor = category_model_manager;

category_model_manager.prototype.add = function() {
	var self = this;
	model_manager.prototype.add.call(this, function() {
		var date = $.datepicker.formatDate( config.date_format_jquery, new Date());
		self.set_form_field('created_on', date);
	});
}

category_model_manager.prototype.grid_reload = function() {
	var self = this;
	model_manager.prototype.grid_reload.call(self);
	com.reset_grid();
};