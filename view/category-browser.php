<?php 
use Lib\Language;
?>
<script type="text/javascript">
	$(document).ready(function() {
		cm.grid('category-grid', 'category-pager');
	});
</script>

<h1><?php echo Language::item('category-browser', 'title') ?></h1>

<table id="category-grid"></table>
<div id="category-pager"></div>


 