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
        $this->set('id', $id, true);

        $data = $id ? $this->UserEntity->findByPK($id) : [];
        if ($data)
        {
            $data['password'] = '';
        }
        $form = new Form($this->getFormFields(), $data);

        $this->set('form', $form, true);
        $this->set('data', $data, true);
        $this->set('title_page', $data ? 'New User' : 'Update User', true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('admin/users'));
        $this->set('link_form', $this->router->url('admin/user'));
    }

    public function getFormFields()
    {
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