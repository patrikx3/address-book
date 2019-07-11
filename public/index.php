<?php
error_reporting(E_ALL);

//define('DEBUG', true);
//define('DEBUG_SLOW_DOWN_AJAX', 1000);

define('BASE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

define('LIB_PATH', BASE_PATH . 'lib' . DIRECTORY_SEPARATOR);
define('MODEL_PATH', BASE_PATH . 'model' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', BASE_PATH . 'view' . DIRECTORY_SEPARATOR);
define('CONTROLLER_PATH', BASE_PATH . 'controller' . DIRECTORY_SEPARATOR);
define('DATA_PATH', BASE_PATH . 'data' . DIRECTORY_SEPARATOR);
define('WWW_PATH', BASE_PATH . 'www' . DIRECTORY_SEPARATOR);
define('LANG_PATH', BASE_PATH . 'language' . DIRECTORY_SEPARATOR);

define('DSN', 'sqlite:' . DATA_PATH . 'address-book.sqlite');

$url = isset($_SERVER['URL']) ? $_SERVER["URL"] : $_SERVER["SCRIPT_NAME"];
define('BASE_URL_PATH', dirname($url));
define('BASE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://') . $_SERVER["HTTP_HOST"] . BASE_URL_PATH);
define('APP_URL', BASE_URL);
define('DEFAULT_ROUTE', '/view');
define('DEFAULT_ROUTE_METHOD', 'display');
define('DEFAULT_LAYOUT', 'layout');
define('DEFAULT_VIEW', 'home');

define('DATE_FORMAT_JQUERY', 'yy-mm-dd');
define('DATE_FORMAT_PHP', 'Y-m-d');
define('DATETIME_FORMAT_PHP', 'Y-m-d H:i:s');

define('DEFAULT_LOCALE', 'hu');

$config = array();
$config['available_locales'] = array('hu', 'en');

$config['deploymented-url'] = 'https://address-book.patrikx3.com/';

try {
    $pdo = new PDO (DSN);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "DB connection error: " . $e->getMessage() . "<br/>";
    die ();
}

// auto load could be utilized but it is not 
// in scope for this little application
require_once LIB_PATH . 'view.php';
require_once LIB_PATH . 'router.php';
require_once LIB_PATH . 'json.php';
require_once LIB_PATH . 'abstract_model.php';
require_once LIB_PATH . 'controller_base.php';
require_once LIB_PATH . 'validator.php';
require_once LIB_PATH . 'language.php';

require_once MODEL_PATH . 'category.php';
require_once MODEL_PATH . 'contact.php';

use Lib\Router;
use Lib\Language;

/*
if (isset($_GET['debug'])) {
    echo '<pre>';
    print_r($_SERVER);
    $consts = get_defined_constants(true);
    print_r($consts['user']);
    exit;
}
*/

Language::init();
Router::execute();

