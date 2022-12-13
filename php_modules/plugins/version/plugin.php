<?php
/**
 * SPT software - Stater plugin
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic plugin
 * 
 */

namespace App\plugins\version;

use SPT\App\Instance as AppIns;
use SPT\Plugin\CMS as PluginAbstract;
use SPT\Support\Loader;
use Joomla\DI\Container;
use SPT\Storage\DB\Entity;

class plugin extends PluginAbstract
{ 
    public function register()
    {
        return [
            // write your code here
            'viewmodels' => [
                'alias' => [
                    'App\plugins\version\viewmodels\AdminVersionsVM' => 'AdminVersionsVM',
                    'App\plugins\version\viewmodels\AdminVersionVM' => 'AdminVersionVM',
                    'App\plugins\version\viewmodels\AdminVersionNotesVM' => 'AdminVersionNotesVM',
                    'App\plugins\version\viewmodels\AdminFeedbackVM' => 'AdminFeedbackVM',
                ],
            ],
            'models' => [
                'alias' => [
                    'App\plugins\version\models\VersionModel' => 'VersionModel',
                ],
            ],
            'entity' => [],
        ];
    }

    public function getInfo()
    {
        return [
            'name' => 'version',
            'author' => 'Pham Minh',
            'version' =>  '0.1',
            'description' => 'version Plugin'
        ];
    }

    public function loadEntity(Container $container)
    {
        $path = AppIns::path('plugin'). 'version/entities';
        $namespace = 'App\plugins\version\entities';
        $inners = Loader::findClass($path, $namespace);
        foreach($inners as $class)
        {
            if(class_exists($class))
            {
                $entity = new $class($container->get('query'));
                $entity->checkAvailability();
                $container->share( $class, $entity, true);
                $alias = explode('\\', $class);
                $container->alias( $alias[count($alias) - 1], $class);
            }
            // else { debug this }
        }
    }

    public function registerMenu()
    {
        $menu = [
            [['versions', 'version', 'version-notes', 'version-feedback'], 'versions', 'Version', '<i class="fa-solid fa-code-branch"></i>', ''],
        ];
        return $menu;
    }
}
