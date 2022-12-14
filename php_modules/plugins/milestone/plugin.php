<?php
/**
 * SPT software - Stater plugin
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic plugin
 * 
 */

namespace App\plugins\milestone;

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
                    'App\plugins\milestone\viewmodels\AdminMilestonesVM' => 'AdminMilestonesVM',
                    'App\plugins\milestone\viewmodels\AdminMilestoneVM' => 'AdminMilestoneVM',
                    'App\plugins\milestone\viewmodels\AdminRequestsVM' => 'AdminRequestsVM',
                    'App\plugins\milestone\viewmodels\AdminRequestVM' => 'AdminRequestVM',
                    'App\plugins\milestone\viewmodels\AdminRelateNotesVM' => 'AdminRelateNotesVM',
                    'App\plugins\milestone\viewmodels\AdminRelateNoteVM' => 'AdminRelateNoteVM',
                    'App\plugins\milestone\viewmodels\AdminDocumentVM' => 'AdminDocumentVM',
                    'App\plugins\milestone\viewmodels\AdminTasksVM' => 'AdminTasksVM',
                    'App\plugins\milestone\viewmodels\AdminTaskVM' => 'AdminTaskVM',
                    'App\plugins\milestone\viewmodels\AdminVersionLatestVM' => 'AdminVersionLatestVM',
                ],
            ],
            'models' => [
                'alias' => [
                    'App\plugins\milestone\models\MilestoneModel' => 'MilestoneModel',
                    'App\plugins\milestone\models\RequestModel' => 'RequestModel',
                    'App\plugins\milestone\models\DocumentModel' => 'DocumentModel',
                ],
            ],
            'entity' => [],
        ];
    }

    public function getInfo()
    {
        return [
            'name' => 'milestone',
            'author' => 'Pham Minh',
            'version' =>  '0.1',
            'description' => 'Milestone Plugin'
        ];
    }

    public function loadEntity(Container $container)
    {
        $path = AppIns::path('plugin'). 'milestone/entities';
        $namespace = 'App\plugins\milestone\entities';
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
        $entity = AppIns::factory('MilestoneEntity');
        $router = AppIns::factory('router');
        $path_current = $router->get('actualPath');
        $str = ['detail-request'];
        $check = false;
        foreach ($str as $item)
        {
            if (strpos($path_current, $item) !== false)
            {
                $check = true;
                break;
            }
        }
        if ($check)
        {
            $request = AppIns::factory('request');
            $version = AppIns::factory('VersionEntity');
            $app = AppIns::factory('app');
            $app->set('menu_type', 'milestone');
            $urlVars = $request->get('urlVars');
            $request_id = (int) $urlVars['request_id'];
            
            $menu = [
                [['detail-request/'. $request_id], 'detail-request/'. $request_id.'#relate_note_link', 'Relate Notes', '<i class="fa-solid fa-link"></i>', ''],
                [[], 'detail-request/'. $request_id.'#document_link', 'Document', '<i class="fa-regular fa-folder-open"></i>', ''],
                [[], 'detail-request/'. $request_id.'#task_link', 'Tasks', '<i class="fa-solid fa-list-check"></i>', ''],
            ];

            if ($version instanceof Entity)
            {
                $menu[] = [[], 'detail-request/'. $request_id.'#version_link', 'Versions', '<i class="fa-solid fa-code-branch"></i>', ''];
            }
            return $menu;
        }

        $list = $entity->list(0, 0, ['status = 1']);
        $menu = [
            [['milestones', 'milestone',], 'milestones', 'Milestones', '<i class="fa-solid fa-business-time"></i>', ''],
        ];
        foreach($list as $item)
        {
            $menu[] = [['requests/'. $item['id'],'request/'. $item['id']], 'requests/'. $item['id'], $item['title'], '<i class="fa-solid fa-business-time"></i>', ''];
        }
        return $menu;
    }
}
