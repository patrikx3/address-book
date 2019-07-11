<?php

namespace Controller;

use Lib\Controller_base;
use Lib\Language;
use Lib\Router;

class System extends Controller_base
{

    public function javascript_config()
    {
        $config = array();
        $config['base_url'] = BASE_URL;
        $config['app_url'] = APP_URL;
        $config['base_url_path'] = BASE_URL_PATH;
        $config['date_format_jquery'] = DATE_FORMAT_JQUERY;
        $config['locale'] = Language::$locale;
        $config['default_view'] = DEFAULT_VIEW;

        $this->send_javascript_var('config', $config);
    }

    public function javascript_language($area)
    {
        $js_area = Router::secure_method($area);
        $lang = Language::javascript_area($area);
        $this->send_javascript_var('lang[\'' . $js_area . '\']', $lang, false);
    }

}
