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

use SPT\View\Gui\Form;
use SPT\View\Gui\Listing;
use SPT\View\VM\JDIContainer\ViewModel;
use SPT\Util;

class AdminUsersVM extends ViewModel
{
    protected $alias = 'AdminUsersVM';
    protected $layouts = [
        'layouts.backend.user' => [
            'list',
            'list.row',
            'list.filter'
        ]
    ];

    public function list()
    {
        $filter = $this->filter();

        $limit  = $filter->getField('limit')->value;
        $sort   = $filter->getField('sort')->value;
        $sub_type = $filter->getField('sub_type')->value;
        $search = $filter->getField('search')->value;
        $status = $filter->getField('status')->value;
        $page   = $this->request->get->get('page', 1);
        if ($page <= 0) $page = 1;

        $where = [];


        if( !empty($search) )
        {
            $where[] = "(`userid` LIKE '%".$search."%' ".
                "OR `u_email` LIKE '%".$search."%' ".
                "OR `u_f_name` LIKE '%".$search."%' ".
                "OR `school_name` LIKE '%".$search."%' ".
                "OR `u_l_name` LIKE '%".$search."%' )";
        }
        if($status == '1')
        {
            $where[] = 'expire_date < NOW()';
        }
        elseif($status == '2')
        {
            $where[] = 'expire_date >= NOW()';
        }

        if($sub_type)
        {
            $where[] = 's_type = "'. $sub_type.'"';
        }
        $start  = ($page - 1) * $limit;

        $sort = $sort ? $sort : 'u_id DESC';
        $result = $this->UserEntity->list($start, $limit, $where, $sort);
        $total = $this->UserEntity->getListTotal();
        if (!$result) {
            $result = [];
            $total = 0;
            $this->session->set('flashMsg', 'Not Found User');
        }
        $users = $this->UserEntity->list(0, 0, [], 'userid asc');
        $list   = new Listing($result, $total, $limit, $this->getColumns());
        $this->set('list', $list, true);
        $this->set('title_page', 'Users', true);
        $this->set('page', $page, true);
        $this->set('start', $start, true);
        $this->set('users', $users, true);
        $this->set('sort', $sort, true);
        $this->set('user_id', $this->user->get('u_id'), true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('admin/users'), true);
        $this->set('link_form', $this->router->url('admin/user'), true);
        $this->set('token', $this->app->getToken(), true);
    }

    public function getColumns()
    {
        return [
            'num' => '#',
            'userid' => 'User Name',
            'u_type' => 'User Type',
            's_type' => 'Subscription Type',
            'u_email' => 'Email',
            'u_l_name' => 'Last Name',
            'u_f_name' => 'First Name',
            'phone' => 'Phone',
            'school_name' => 'School Name',
            'addr1' => 'Address 1',
            'addr2' => 'Address 2',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip/Postal',
            'start_date' => 'Start Date',
            'payment_date' => 'Payment Date',
            'expire_date' => 'Expire Date',
            'col_last' => ' ',
        ];
    }

    protected $_filter;
    public function filter()
    {
        if (null === $this->_filter) :
            $data = [
                'search' => $this->state('search', '', '', 'post', 'users.search'),
                'status' => $this->state('status', '', '', 'post', 'users.status'),
                'limit' => $this->state('limit', 10, 'int', 'post', 'users.limit'),
                'sort' => $this->state('sort', '', '', 'post', 'users.sort'),
                'sub_type' => $this->state('sub_type', '', '', 'post', 'users.sub_type'),
            ];

            $filter = new Form($this->getFilterFields(), $data);
            $this->set('form', ['filter' => $filter], true);
            $this->set('dataform', $data, true);

            foreach ($data as $k => $v) $this->set($k, $v);
            $this->_filter = $filter;
        endif;

        return $this->_filter;
    }

    public function getFilterFields()
    {
        return [
            'search' => [
                'text',
                'default' => '',
                'showLabel' => false,
                'formClass' => 'form-control h-full input_common w_full_475',
                'placeholder' => 'Search..'
            ],
            'status' => [
                'option',
                'default' => '',
                'formClass' => 'form-select',
                'options' => [
                    ['text' => '--', 'value' => ''],
                    ['text' => 'Expired', 'value' => '1'],
                    ['text' => 'Unexpired', 'value' => '2']
                ],
                'showLabel' => false
            ],
            'sub_type' => [
                'option',
                'default' => '',
                'formClass' => 'form-select',
                'options' => [
                    ['text' => 'Subscription Type', 'value' => ''],
                    ['text' => 'School', 'value' => 'school'],
                    ['text' => 'Teacher', 'value' => 'teacher'],
                    ['text' => 'Home', 'value' => 'home'],
                    ['text' => 'Extended Staff', 'value' => 'extended_staff'],
                    ['text' => 'Extended School', 'value' => 'extended_school'],
                    ['text' => 'Other', 'value' => 'other'],
                ],
                'showLabel' => false
            ],
            'limit' => [
                'option',
                'formClass' => 'form-select w-auto',
                'default' => 10,
                'options' => [5, 10, 20, 50],
                'showLabel' => false
            ],
            'group' => ['text'],
            'sort' => [
                'option',
                'formClass' => 'form-select',
                'default' => 'username asc',
                'options' => [
                    ['text' => 'Sort By', 'value' => ''],
                    ['text' => 'Username ASC', 'value' => 'userid asc'],
                    ['text' => 'Username DESC', 'value' => 'userid desc'],
                    ['text' => 'School ASC', 'value' => 'school_name asc'],
                    ['text' => 'School DESC', 'value' => 'school_name desc'],
                    ['text' => 'Email ASC', 'value' => 'u_email asc'],
                    ['text' => 'Email DESC', 'value' => 'u_email desc'],
                    ['text' => 'Payment ASC', 'value' => 'payment_date asc'],
                    ['text' => 'Payment DESC', 'value' => 'payment_date desc'],
                    ['text' => 'Expire ASC', 'value' => 'expire_date asc'],
                    ['text' => 'Expire DESC', 'value' => 'expire_date desc'],
                    ['text' => 'Start ASC', 'value' => 'start_date asc'],
                    ['text' => 'Start DESC', 'value' => 'start_date desc'],
                ],
                'showLabel' => false
            ]
        ];
    }

    public function row()
    {
        $row = $this->view->list->getRow();
        $this->set('item', $row);
        $this->set('index', $this->view->list->getIndex());
    }
}
