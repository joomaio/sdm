<?php

/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: A simple View Model
 * 
 */

namespace App\plugins\setting\viewmodels;

use SPT\View\VM\JDIContainer\ViewModel;
use SPT\View\Gui\Form;

class AdminSettingVM extends ViewModel
{
    protected $alias = 'AdminSettingVM';
    protected $layouts = [
        'layouts.backend.setting' => [
            'form'
        ]
    ];

    public function form()
    {
        
        $fields = $this->getFormFields();
        
        $data = [];
        foreach ($fields as $key => $value) {
            if ($key != 'token') {
                $data[$key] =  $this->OptionModel->get($key, '');
            }
        }
        $form = new Form($this->getFormFields(), $data);
        $fileds = $this->getFormFields();
        $title_page = 'Setting';
        $this->view->set('fileds', $fileds, true);
        $this->view->set('form', $form, true);
        $this->view->set('title_page', $title_page, true);
        $this->view->set('data', $data, true);
        $this->view->set('url', $this->router->url(), true);
        $this->view->set('link_form', $this->router->url('admin/setting'));
    }

    public function getFormFields()
    {
        $fields = [];
        $legends = [];
        foreach ($this->plugin as $name => $plg)
        {
            if (method_exists($plg, 'registerSetting'))
            {
                $register = $plg->registerSetting();
                if (is_array($register))
                {
                    $legend = [];
                    foreach ($register as $item)
                    {
                        $legend['label'] = $item['label'];
                        $legend['fields'] = [];
                        $fields = array_merge($fields, $item['fields']);
                        $legend['fields'] = array_keys($fields);
                        $legends[] = $legend;
                    }
                }
            }
        }
        $this->set('legends', $legends);
        return $fields;
    }
}
