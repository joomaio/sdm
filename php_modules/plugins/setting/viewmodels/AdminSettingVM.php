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

        $title_page = 'Setting';
        $this->view->set('fields', $fields, true);
        $this->view->set('form', $form, true);
        $this->view->set('title_page', $title_page, true);
        $this->view->set('data', $data, true);
        $this->view->set('url', $this->router->url(), true);
        $this->view->set('link_form', $this->router->url('setting'));
        $this->view->set('link_mail_test', $this->router->url('setting/mail-test'));
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
                    foreach ($register as $item)
                    {
                        $legend = [];
                        $legend['label'] = $item['label'];
                        $legend['fields'] = [];
                        $fields = array_merge($fields, $item['fields']);
                        $legend['fields'] = array_keys($item['fields']);
                        $legends[] = $legend;
                    }
                }
            }
        }
        $this->view->set('legends', $legends);
        return $fields;
    }
}
