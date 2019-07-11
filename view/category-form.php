<?php

use Lib\Language;

?>
<div id="category-form" class="form" title="<?= Language::item('category-form', 'form_title') ?>">
    <form>
        <div class="form-read-only">

            <label><?= Language::item('category-form', 'column_id') ?></label>
            <input type="text" name="id" id="category-id" readonly="readonly" size="5"
                   title="<?= Language::item('category-form', 'column_id_tooltip') ?>"/>

            <br clear="all"/>

            <label><?= Language::item('category-form', 'column_updated') ?></label>
            <input type="text" name="updated_on" id="category-updated-on" readonly="readonly"
                   title="<?= Language::item('category-form', 'column_updated_tooltip') ?>"/>
        </div>

        <br clear="all"/>

        <label for="category-title"><?= Language::item('category-form', 'column_title') ?></label>
        <input type="text" name="title" id="category-title" size="40" maxlength="255"
               title="<?= Language::item('category-form', 'column_title_tooltip') ?>"/>

    </form>
</div>
