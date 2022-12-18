<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic viewmodel
 * 
 */
namespace App\plugins\user\viewmodels; 

use SPT\View\Gui\Form;
use SPT\View\Gui\Listing;
use SPT\View\VM\JDIContainer\ViewModel;
use SPT\Util;

class AdminGroupVM extends ViewModel
{
    protected $alias = 'AdminGroupVM';
    protected $layouts = [
        'layouts.backend.usergroup' => [
            'form'
        ]
    ];

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        $this->view->set('id', $id, true);

        $data = $id ? $this->GroupEntity->findByPK($id) : [];
        if (isset($data['access']) && $data['access'])
        {
            $data['access'] = (array) json_decode($data['access']);
        }
        $form = new Form($this->getFormFields(), $data);

        $this->set('form', $form, true);
        $this->set('data', $data, true);
        $this->set('title_page', $data ? 'New User Group' : 'Update User Group', true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('user-groups'));
        $this->set('link_form', $this->router->url('user-group'));
    }

    public function getFormFields()
    {
        $key_access = $this->UserModel->getRightAccess();
        $option = [];
        foreach ($key_access as $key)
        {
            $option[] = [
                'text' => $key,
                'value' => $key,
            ];
        }

        $fields = [
            'id' => ['hidden'],
            'name' => ['text',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required'
            ],
            'description' => ['textarea',
                'formClass' => 'form-control',
                'showLabel' => false,
                'placeholder' => ''
            ],
            'access' => ['option',
                'showLabel' => false,
                'placeholder' => 'Select Right Access',
                'type' => 'multiselect',
                'formClass' => 'form-select',
                'options' => $option
            ],
            'status' => ['option',
                'type' => 'radio',
                'formClass' => '',
                'default' => 1,
                'options' => [
                    ['text'=>'Yes', 'value'=>1],
                    ['text'=>'No', 'value'=>0]
                ]
            ],
            'token' => ['hidden',
                'default' => $this->app->getToken(),
            ],
        ];

        if($this->view->id)
        {
            $fields['modified_at'] = ['readonly'];
            $fields['modified_by'] = ['readonly'];
            $fields['created_at'] = ['readonly'];
            $fields['created_by'] = ['readonly'];
        }
        else
        {
            $fields['password']['required'] = 'required';
            $fields['confirm_password']['required'] = 'required';
            $fields['modified_at'] = ['hidden'];
            $fields['modified_by'] = ['hidden'];
            $fields['created_at'] = ['hidden'];
            $fields['created_by'] = ['hidden'];
        }

        return $fields;
    }
}
