<?php
/**
 * SPT software - Core plugin
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic plugin
 * 
 */

namespace App\plugins\core;

use SPT\App\Instance as AppIns;
use SPT\Support\Loader;
use Joomla\DI\Container;
use SPT\Plugin\CMS as PluginAbstract;

class plugin extends PluginAbstract
{ 
    public function register()
    {
        return [
            'viewmodels' => [
                'alias' => [
                    'App\plugins\core\viewmodels\MessageVM' => 'MessageVM',
                    'App\plugins\core\viewmodels\SideBarVM' => 'SideBarVM',
                    'App\plugins\core\viewmodels\PaginationVM' => 'PaginationVM',
                    'App\plugins\core\viewmodels\DemoVM' => 'DemoVM',
                ],
            ],
        ];
    }

    public function getInfo()
    {
        return [
            'name' => 'core',
            'author' => 'Pham Minh',
            'version' =>  '0.1',
            'description' => 'Core Plugin'
        ];
    }

}
