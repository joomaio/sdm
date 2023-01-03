<?php
/**
 * SPT software - Demo application
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: How we start an MVC
 * 
 */

define( 'APP_PATH', __DIR__ . '/../php_modules/');
define('PUBLIC_PATH', __DIR__ . '/../public/');
define('MEDIA_PATH', PUBLIC_PATH. 'media/');
define('SPT_PATH_TEMP', PUBLIC_PATH);
define( 'SITE_HOST', 'localTest' );
define( 'SITE_PROTOCOL', 'http://' );
define( 'SITE_URL', SITE_PROTOCOL. SITE_HOST. '/' );

$_SERVER['HTTP_HOST'] = SITE_HOST;
$_SERVER['REQUEST_URI'] = SITE_URL;
require APP_PATH.'/../vendor/autoload.php';
use SPT\App\Instance as AppIns;
use Joomla\DI\Container;
use Tests\libraries\appTest;
use SPT\Request\Base as Request;
use SPT\Storage\File\ArrayType as FileArray;

class Loader 
{
    private static $app;

    public static function getInstance()
    {
        if(static::$app == null)
        {
            $app = new appTest(new Container);
            AppIns::bootstrap( new appTest(new Container),[
                'app' => APP_PATH,
                'config' => APP_PATH. '/config.php', 
                'plugin' => APP_PATH. '//plugins/', 
                'theme' => APP_PATH. 'themes/', 
            ]);

            AppIns::main()->execute();
        }

        return $app;
    }
}

Loader::getInstance();

