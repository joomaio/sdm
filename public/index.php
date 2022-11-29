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
define('PUBLIC_PATH', __DIR__ . '/');
define('MEDIA_PATH', PUBLIC_PATH. 'media/');
define('SPT_PATH_TEMP', PUBLIC_PATH);

require APP_PATH.'/../vendor/autoload.php';

use SPT\App\Instance as AppIns;
use Joomla\DI\Container;
use App\libraries\appPlg;

/**
 * Running application
 */
AppIns::bootstrap( new appPlg(new Container),[
    'app' => APP_PATH,
    'config' => APP_PATH. '/config.php', 
    'plugin' => APP_PATH. '//plugins/', 
    'theme' => APP_PATH. 'themes/', 
]);

AppIns::main()->execute();