<?php

use Lib\Language;

global $config;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Language::item('layout', 'page_title') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta name="google-site-verification" content="pbVywkvDYDmUoP7E8rwbmtetgqjmtR9sW8-eAT5A-rI"/>
    <base href="<?= BASE_URL ?>"/>

    <meta name="description" content="Patrik Laszlo Address Contact Book Címjegyzék Cím jegyzék"/>
    <meta name="keywords" content="Patrik,Laszlo,Address,Contact,Book,Címjegyzék,Cím,jegyzék"/>
    <meta name="author" content="Patrik Laszlo">
    <meta charset="UTF-8">

    <!-- jquery css -->
    <link href="css/jquery/address-book/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css"/>
    <link href="css/jquery/ui.jqgrid.css" rel="stylesheet" type="text/css"/>
    <link href="css/jquery/jquery.ui.potato.menu.css" rel="stylesheet" type="text/css"/>
    <link href="css/jquery/jquery.jgrowl.css" rel="stylesheet" type="text/css"/>
    <link href="css/jquery/tipTip.css" rel="stylesheet" type="text/css"/>
    <link href="css/jquery/ui.multiselect.css" rel="stylesheet" type="text/css"/>

    <!-- jquery javascript and plugins -->
    <script type="text/javascript" src="javascript/jquery/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery-ui-1.8.9.custom.min.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery.ui.potato.menu.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery.jgrowl_minimized.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery.tipTip.minified.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery.blockUI.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery.cookie.js"></script>
    <script type="text/javascript" src="javascript/jquery/ui.multiselect.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery.address-1.3.2.min.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery.formToJson.js"></script>

    <!-- jquery localization scripts -->
    <?php if (Language::$locale != 'en') : ?>
        <script type="text/javascript"
                src="javascript/jquery/i18n/jquery.ui.datepicker-<?php echo Language::$locale ?>.js"></script>
        <script type="text/javascript"
                src="javascript/jquery/i18n/ui-multiselect-<?php echo Language::$locale ?>.js"></script>
    <?php endif; ?>
    <script type="text/javascript" src="javascript/jquery/i18n/grid.locale-<?php echo Language::$locale ?>.js"></script>

    <!-- jquery plugins -->
    <script type="text/javascript" src="javascript/jquery/jquery.jqGrid.min.js"></script>

    <!-- framework css -->
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="css/form.css" rel="stylesheet" type="text/css"/>

    <!-- framework javascript -->
    <script type="text/javascript" src="javascript/layout-manager.js"></script>
    <script type="text/javascript" src="javascript/model-manager.js"></script>
    <script type="text/javascript" src="javascript/category-model-manager.js"></script>
    <script type="text/javascript" src="javascript/contact-model-manager.js"></script>
    <script type="text/javascript" src="javascript/system-initialization.js"></script>
    <script type="text/javascript" src="<?= APP_URL ?>system/javascript-config"></script>
    <script type="text/javascript" src="<?= APP_URL ?>system/javascript-language/layout-manager"></script>
    <script type="text/javascript" src="<?= APP_URL ?>system/javascript-language/model-manager"></script>
    <script type="text/javascript" src="<?= APP_URL ?>system/javascript-language/category-model-manager"></script>
    <script type="text/javascript" src="<?= APP_URL ?>system/javascript-language/contact-model-manager"></script>

</head>

<body>
<div id="layout-header">
    <img src="images/Address_Book.png"/><span
        title="<?php echo Language::item('layout', 'header_title_tooltip') ?>"><?php echo Language::item('layout', 'header_title') ?></span>
</div>

<div id='layout-locale'>
    <?php echo Language::item('layout', 'switch_locale_label') ?>
    <?php foreach ($config['available_locales'] as $value): ?>
        <?php if (Language::$locale != $value): ?>
            <a href="javascript:lm.set_locale('<?php echo $value ?>');">
                <img id="locale-<?php echo $value ?>" src="images/locale-<?php echo $value ?>.png"
                     title="<?php echo Language::item('layout', 'locale_' . $value) ?>"/>
            </a>
        <?php else: ?>
            <img id="locale-<?php echo $value ?>" src="images/locale-<?php echo $value ?>.png"
                 title="<?php echo Language::item('layout', 'locale_' . $value) ?>"/>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<div id="layout-navigation-container">
    <ul id="layout-navigation">
        <li><a href="javascript: lm.get_view('home');"><?php echo Language::item('layout', 'navigation_home') ?></a>
        </li>
        <li>
            <a href="javascript: lm.get_view('contact-browser');"><?php echo Language::item('layout', 'navigation_contact') ?></a>
            <ul>
                <li>
                    <a href="javascript: com.add()"><?php echo Language::item('layout', 'navigation_contact_new') ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript: lm.get_view('category-browser');"><?php echo Language::item('layout', 'navigation_category') ?></a>
            <ul>
                <li>
                    <a href="javascript: cm.add()"><?php echo Language::item('layout', 'navigation_category_new') ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" id="help"
               title="<?php echo Language::item('layout', 'navigation_help_tooltip') ?>"><?php echo Language::item('layout', 'navigation_help') ?></a>
            <ul>
                <li>
                    <a href="javascript: lm.get_view('requirements');"><?php echo Language::item('layout', 'navigation_help_requirements') ?></a>
                </li>
                <li>
                    <a href="javascript: lm.get_view('installation');"><?php echo Language::item('layout', 'navigation_help_installation') ?></a>
                </li>
                <li>
                    <a href="javascript: lm.get_view('technologies');">
                        <?php echo Language::item('layout', 'navigation_help_technologies') ?>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<div id="layout-content">
</div>

<?php if (defined('DEBUG')) : ?>
    <div id='layout-debug'>
        DEBUG
    </div>
<?php endif; ?>

<div id="layout-confirm" title="<?php echo Language::item('layout', 'confirm_title') ?>">
</div>

<div style="position: fixed; bottom: 5px; right: 5px; font-size: 12px; padding: 3px; background-color: white;">
    <a href="http://www.patrikx3.com/" target="_blank">&copy;<?php echo Language::item('layout', 'copyright') ?></a>
</div>

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-102206174-1', 'auto');
    ga('send', 'pageview');


    $(document).ajaxSend(function (event, jqXHR, options) {
        ga('send', 'pageview', options.url);
    });

</script>

</body>
</html>
