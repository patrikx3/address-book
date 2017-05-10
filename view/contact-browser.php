<?php 
use Lib\Language;
?>
<script type="text/javascript">
	$(document).ready(function() {
		com.grid('contact-grid', 'contact-pager');
	});
</script>

<h1><?= Language::item('contact-browser', 'title') ?></h1>

<table id="contact-grid"></table>
<div id="contact-pager"></div>


 