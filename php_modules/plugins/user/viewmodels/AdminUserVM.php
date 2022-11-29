<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: A simple View Model
 * 
 */

namespace App\plugins\user\viewmodels;

use SPT\View\VM\JDIContainer\ViewModel; 
use SPT\View\Gui\Form;

class AdminUserVM extends ViewModel
{
    protected $alias = 'AdminUserVM';
    protected $layouts = [
        'layouts.backend.user' => [
            'form',
            'login',
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
            $ip_login = $this->IPLoginEntity->findOne(['u_id' => $id]);
            $data['ip_login'] = $ip_login ? $ip_login['ip_addr'] : '';
            $data['psw'] = $this->HelperModel->descrypt($data['psw']);
        }
        else
        {
            $data['start_date'] = date('Y-m-d');
        }
        $form = new Form($this->getFormFields(), $data);
        $title_page = $id ? 'Update User' : 'New User';
        $this->view->set('form', $form, true);
        $this->view->set('data', $data, true);
        $this->view->set('title_page', $title_page, true);
        $this->view->set('url', $this->router->url(), true);
        $this->view->set('link_list', $this->router->url('admin/users'));
        $this->view->set('link_form', $this->router->url('admin/user/'. $id));
    }

    public function getFormFields()
    {
        $time_zone = $this->HelperModel->time_zone_list(0, 0);
        $options = [];
        foreach ($time_zone as $item)
        {
            $temp = explode('~', $item);
            $tz_code = $temp[0];
            $tz_name = $temp[1];
            $options[] = [
                'text' => $tz_name,
                'value' => $tz_code,
            ];
        }

        $fields = [
            'id' => ['hidden'],
            'userid' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required'
            ],
            'psw' => [
                'password',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'u_email' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required'
            ],
            'u_l_name' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required'
            ],
            'u_f_name' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
                'required' => 'required'
            ],
            't_count' => [
                'number',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'grade_level' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'school_name' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'phone' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'addr1' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'addr2' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'city' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'state' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'zip' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'country' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'u_type' => [
                'option',
                'showLabel' => false,
                'formClass' => 'form-select',
                'default' => 'view',
                'options' => [
                    ['text' => 'View', 'value' => 'view'],
                    ['text' => 'Update', 'value' => 'update'],
                    ['text' => 'Admin', 'value' => 'admin'],
                ],
            ],
            's_type' => [
                'option',
                'formClass' => 'form-select',
                'showLabel' => false,
                'default' => 'other',
                'options' => [
                    ['text' => 'Other', 'value' => 'other'],
                    ['text' => 'Home', 'value' => 'home'],
                    ['text' => 'Teacher', 'value' => 'teacher'],
                    ['text' => 'School', 'value' => 'school'],
                    ['text' => 'Extended Staff', 'value' => 'extended_staff'],
                    ['text' => 'Extended School', 'value' => 'extended_school'],
                ],
            ],
            'time_zone' => [
                'option',
                'formClass' => 'form-select',
                'showLabel' => false,
                'options' => $options,
            ],
            'start_time' => [
                'text',
                'showLabel' => false,
                'default' => '00:00:00',
                'formClass' => 'form-control',
            ],
            'end_time' => [
                'text',
                'showLabel' => false,
                'default' => '24:00:00',
                'formClass' => 'form-control',
            ],
            'start_date' => [
                'date',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'payment_date' => [
                'date',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'expire_date' => [
                'date',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'gift_name' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'ip_login' => [
                'text',
                'showLabel' => false,
                'formClass' => 'form-control',
            ],
            'token' => ['hidden',
                'default' => $this->app->getToken(),
            ],
        ];

        if (!$this->view->id)
        {
            $fields['psw']['required'] = 'required';
        }

        return $fields;
    }

    public function login()
    {
        $this->view->set('url', $this->router->url(), true);
        $this->view->set('link_login', $this->router->url('admin/login'), true);
    }
}