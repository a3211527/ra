<?php
/**
 * Created by PhpStorm.
 * User: otorain
 * Date: 17-9-17
 * Time: 下午8:30
 */

define('RA', realpath("./"));
define('API', RA . '/api/');
define('CORE', RA . '/core/');
define('CONF', RA . '/conf/');
define('LOG', RA . '/log/');
define('DATA', RA .'/data/');
define('ARTICLE', DATA .'article/');
define('DEBUG', true);
if (DEBUG) {
    ini_set('display_errors', 'On');
}
else {
    ini_set('display_errors', 'Off');
}
include CORE . 'Ra.php';
include CORE . 'common/function.php';

spl_autoload_register("core\Ra::load");
core\Ra::run();
