var lm = null;
var cm = null;
var com = null;
var lang = {};
$(document).ready(function() {
	lm = new layout_manager();
	cm = new category_model_manager();
	com = new contact_model_manager();
	lm.init();
});

