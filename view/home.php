<?php

use Lib\Language;

?>
<style type="text/css">
    #technologies h1 {
        font-size: 1em;
        color: #440000;
        border: none;
    }
</style>
<div id="technologies" class="ui-widget ui-widget-content"
     style="float: right; padding: 10px; margin-top: 10px; margin-right: 10px;">
</div>
<script type="text/javascript">
    $(document).ready(function () {
        lm.tooltip('.top-menu');
        lm.get_view('technologies', function (data) {
            $('#technologies').html(data);
        });
    });
</script>
<h1><?= Language::item('home', 'title') ?></h1>
<?= Language::item('home', 'content') ?>

