<?php
/**
 * SPT software - Stater plugin
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic plugin
 * 
 */

namespace App\plugins\note;

use SPT\App\Instance as AppIns;
use SPT\Plugin\CMS as PluginAbstract;
use SPT\Support\Loader;
use Joomla\DI\Container;
use SPT\File;

class plugin extends PluginAbstract
{
    public function register()
    {
        return [
            'viewmodels' => [
                'alias' => [
                    'App\plugins\note\viewmodels\AdminNoteVM' => 'AdminNoteVM',
                    'App\plugins\note\viewmodels\AdminNotesVM' => 'AdminNotesVM',
                ],
            ],
            'models' => [
                'alias' => [
                    'App\plugins\note\models\NoteModel' => 'NoteModel',
                    'App\plugins\note\models\AttachmentModel' => 'AttachmentModel',
                ],
            ],
            'entity' => [],
            'file' => [],
            // write your code here
        ];
    }

    public function getInfo()
    {
        return [
            'name' => 'sdm',
            'author' => 'HanhDH',
            'version' =>  '0.1',
            'description' => 'SDM'
        ];
    }

    public function loadFile(Container $container)
    {
        $container->set('file', new File());
    }

    public function loadEntity(Container $container)
    {
        $path = AppIns::path('plugin'). 'note/entities';
        $namespace = 'App\plugins\note\entities';
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
        return [
            [['notes', 'note',], 'notes', 'Notes', '<i class="fa-solid fa-business-time"></i>', ''],
        ];
    }
}
