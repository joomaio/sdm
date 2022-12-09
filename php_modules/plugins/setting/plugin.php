<?php
/**
 * SPT software - Stater plugin
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic plugin
 * 
 */

namespace App\plugins\setting;

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
                    'App\plugins\setting\viewmodels\AdminSettingVM' => 'AdminSettingVM',
                ],
            ],
            'models' => [
                'alias' => [
                    'App\plugins\setting\models\OptionModel' => 'OptionModel',
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
            'author' => 'Dev Joomaio',
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
        $path = AppIns::path('plugin'). 'setting/entities';
        $namespace = 'App\plugins\setting\entities';
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

    public function registerSetting()
    {
        return [
            [
                'label' => 'System Info',
                'fields' => [
                    'admin_mail' => [
                        'text',
                        'label' => 'Admin Mail:',
                        'formClass' => 'form-control',
                    ],
                ],
            ],
            [
            'label' => 'SMTP Setting',
            'fields' => [
                'email_host' => [
                    'text',
                    'label' => 'Email Host:',
                    'formClass' => 'form-control',
                ],
                'email_port' => [
                    'text',
                    'label' => 'Email Port:',
                    'formClass' => 'form-control',
                ],
                'email_username' => [
                    'email',
                    'label' => 'Email:',
                    'formClass' => 'form-control',
                ],
                'email_password' => [
                    'password',
                    'label' => 'Password Email:',
                    'formClass' => 'form-control',
                ],
            ],
        ]
    ];
    }

    public function registerMenu()
    {
        return [
            [['setting', 'setting',], 'setting', 'Settings', '<i class="fa-solid fa-gear"></i>', ''],
        ];
    }
}
