<?php
if (!defined('ROOT_PATH'))
{
    define('ROOT_PATH', __DIR__ .'/..//');
    define( 'SITE_HOST', '192.168.56.10' );
    define( 'SITE_PROTOCOL', 'http://' );
    define( 'SITE_URL', SITE_PROTOCOL. SITE_HOST. '/' );
    define('APP_PATH', ROOT_PATH . 'php_modules/');
    define('PATH_CONFIG', APP_PATH. 'config.php');
    define('SPT_PATH_TEMP', ROOT_PATH. 'public/');
    define('PUBLIC_PATH', ROOT_PATH. 'public/');
    define('MEDIA_PATH', ROOT_PATH. 'public/media/');
    define('USERNAME', 'admin');
    define('PASSWORD', '123');

}
?>