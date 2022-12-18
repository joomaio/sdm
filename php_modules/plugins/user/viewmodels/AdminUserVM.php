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

class AdminUserVM extends ViewModel
{
    protected $alias = 'AdminUserVM';
    protected $layouts = [
        'layouts.backend.user' => [
            'login',
            'form'
        ]
    ];

    public function login()
    {
        $this->set('url', $this->router->url(), true);
        $this->set('link_login', $this->router->url('login'), true);
    }

    public function form()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        $this->set('id', $id, true);

        $data = $id ? $this->UserEntity->findByPK($id) : [];
        if ($data)
        {
            $data['password'] = '';
            $groups = $this->UserEntity->getGroups($data['id']);
            foreach ($groups as $group)
            {
                $data['groups'][] = $group['group_id'];
            }
        }
        $form = new Form($this->getFormFields(), $data);

        $this->set('form', $form, true);
        $this->set('data', $data, true);
        $this->set('title_page', $data ? 'New User' : 'Update User', true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('users'));
        $this->set('link_form', $this->router->url('user'));
    }

    public function getFormFields()
    {
        $groups = $this->GroupEntity->list(0, 0, [], 'name asc');
        $options = [];
        foreach ($groups as $group)
        {
            $options[] = [
                'text' => $group['name'],
                'value' => $group['id'],
            ];
        }

        $fields = [
            'id' => ['hidden'],
            'name' => [
                'text',
                'placeholder' => 'Enter Name',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required'
            ],
            'username' => ['text',
                'placeholder' => 'Enter User Name',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required',
            ],
            'email' => ['email',
                'formClass' => 'form-control',
                'placeholder' => 'Enter Email',
                'showLabel' => false,
                // 'required' => 'required'
            ],
            'password' => ['password',
                'placeholder' => 'Enter Password',
                'showLabel' => false,
                'formClass' => 'form-control'
            ],
            'confirm_password' => ['password',
                'placeholder' => 'Enter Confirm Password',
                'showLabel' => false,
                'formClass' => 'form-control'
            ],
            'status' => ['option',
                'showLabel' => false,
                'type' => 'radio',
                'formClass' => '',
                'default' => 1,
                'options' => [
                    ['text'=>'Active', 'value'=>1],
                    ['text'=>'Inactive', 'value'=>0]
                ]
            ],
            'groups' => ['option',
                'options' => $options,
                'type' => 'multiselect',
                'showLabel' => false,
                'formClass' => 'form-select',
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
