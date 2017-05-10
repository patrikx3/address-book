<?php 
use Lib\Language;
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#contact-created-on").datepicker();
});
</script>
<div id="contact-form" class="form" title="<?php echo Language::item('contact-form', 'title') ?>">

	<form>
        <div class="form-read-only">
    
            <label><?php echo Language::item('contact-form', 'column_id') ?></label>
            <input type="text" name="id" id="contact-id" readonly="readonly" size="5" title="<?php echo Language::item('contact-form', 'column_id_tooltip') ?>"/>        
            
            <br clear="all"/>
            
            <label><?php echo Language::item('contact-form', 'column_updated') ?></label>
            <input type="text" name="updated_on" id="contact-updated-on" readonly="readonly" title="<?php echo Language::item('contact-form', 'column_updated_tooltip') ?>"/>        
        </div>


        <br clear="all"/>

        <label><?php echo Language::item('contact-form', 'column_created') ?></label>
        <input type="text" name="created_on" class="form-date" id="contact-created-on" title="<?php echo Language::item('contact-form', 'column_created_tooltip') ?>"/>  
    
        <br clear="all"/>

        <label for="contact-name"><?php echo Language::item('contact-form', 'column_name') ?></label>
        <input type="text" name="name" id="contact-name" size="40" maxlength="255"  title="<?php echo Language::item('contact-form', 'column_name_tooltip') ?>"/>        
    
        <br clear="all"/>

        <label for="contact-email"><?php echo Language::item('contact-form', 'column_email') ?></label>
        <input type="text" name="email" id="contact-email" size="40" maxlength="255"  title="<?php echo Language::item('contact-form', 'column_email_tooltip') ?>"/>        
    
        <br clear="all"/>

        <label for="contact-phone"><?php echo Language::item('contact-form', 'column_phone') ?></label>
        <input type="text" name="phone" id="contact-phone" size="40" maxlength="255"  title="<?php echo Language::item('contact-form', 'column_phone_tooltip') ?>"/>        
		    
        <br clear="all"/>
        
        <div id="contact-category-ui" title="<?= Language::item('contact-form', 'field_category_tooltip') ?>">
            <span class="label"><?= Language::item('contact-form', 'field_category') ?></span>
            <select name="category" id="contact-category" multiple="multiple">
            </select>
        </div>
        <div id="contact-category-none" style="font-size: smaller">
	        <br/>
        	<?php echo Language::item('contact-form', 'field_category_none'); ?>
        </div>
		              
    </form>
    
</div>