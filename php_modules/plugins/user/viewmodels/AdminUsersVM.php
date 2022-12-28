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
        $search = $filter->getField('search')->value;
        $status = $filter->getField('status')->value;
        $filter_group = $filter->getField('group')->value;
        $page   = $this->request->get->get('page', 1, 'int');
        if ($page <= 0) $page = 1;

        $where = [];
        

        if( !empty($search) )
        {
            $where[] = "(`username` LIKE '%".$search."%' ".
                "OR `name` LIKE '%".$search."%' ".
                "OR `email` LIKE '%".$search."%' )";
        }
        if(is_numeric($status))
        {
            $where[] = '`status`='. $status;
        }

        $start  = ($page-1) * $limit;
        $sort = $sort ? $sort : 'name ASC';
        if ($filter_group)
        {
            $user_map = $this->UserGroupEntity->list(0, 0, ['group_id' => $filter_group]);
            $where_group[] = 0;
            foreach($user_map as $map)
            {
                $where_group[] = $map['user_id'];
            }
        
            $where[] = 'id IN ('. implode(',', $where_group) . ')';
        }

        $result = $this->UserEntity->list( $start, $limit, $where, $sort);
        $total = $this->UserEntity->getListTotal();

        if (!$result)
        {
            $result = [];
            $total = 0;
            if ($where)
            {
                $this->session->set('flashMsg', 'User note found');
            }
        }

        foreach( $result as $key => &$value )
        {
            $result[$key]['groups'] = $this->UserEntity->getGroups($value['id']);
        }

        $list   = new Listing($result, $total, $limit, $this->getColumns() );
        $this->set('list', $list, true);
        $this->set('page', $page, true);
        $this->set('start', $start, true);
        $this->set('sort', $sort, true);
        $this->set('user_id', $this->user->get('id'), true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('users'), true);
        $this->set('title_page', 'User Manager', true);
        $this->set('link_form', $this->router->url('user'), true);
        $this->set('token', $this->app->getToken(), true);
    }

    public function getColumns()
    {
        return [
            'num' => '#',
            'name' => 'Name',
            'username' => 'User name',
            'emal' => 'Email',
            'block' => 'Is block',
            'created_at' => 'Created at',
            'col_last' => ' ',
        ];
    }

    protected $_filter;
    public function filter()
    {
        if( null === $this->_filter):
            $data = [
                'search' => $this->state('search', '', '', 'post', 'users.search'),
                'status' => $this->state('status', '','', 'post', 'users.status'),
                'group' => $this->state('group', '','', 'post', 'users.group'),
                'limit' => $this->state('limit', 10, 'int', 'post', 'users.limit'),
                'sort' => $this->state('sort', '', '', 'post', 'users.sort')
            ];

            $filter = new Form($this->getFilterFields(), $data);
            $this->set('form', ['filter' => $filter], true);
            $this->set('dataform', $data, true);

            foreach($data as $k=>$v) $this->set($k, $v);
            $this->_filter = $filter;
        endif;

        return $this->_filter;
    }

    public function getFilterFields()
    {
        $groups = $this->GroupEntity->list(0, 0, [], 'name asc');
        $options = [
            ['text' => 'Select Group', 'value' => ''],
        ];
        foreach ($groups as $group)
        {
            $options[] = [
                'text' => $group['name'],
                'value' => $group['id'],
            ];
        }

        return [
            'search' => ['text',
                'default' => '',
                'showLabel' => false,
                'formClass' => 'form-control h-full input_common w_full_475',
                'placeholder' => 'Search..'
            ],
            'status' => ['option',
                'default' => '1',
                'formClass' => 'form-select',
                'options' => [
                    ['text' => '--', 'value' => ''],
                    ['text' => 'Inactive', 'value' => '0'],
                    ['text' => 'Active', 'value' => '1']
                ],
                'showLabel' => false
            ],
            'limit' => ['option',
                'formClass' => 'form-select',
                'default' => 10,
                'options' => [ 5, 10, 20, 50],
                'showLabel' => false
            ],
            'group' => ['option',
                'formClass' => 'form-select',
                'options' => $options,
                'showLabel' => false
            ],
            'sort' => ['option',
                'formClass' => 'form-select',
                'default' => 'name asc',
                'options' => [
                    ['text' => 'Name ascending', 'value' => 'name asc'],
                    ['text' => 'Name descending', 'value' => 'name desc'],
                    ['text' => 'Email ascending', 'value' => 'email asc'],
                    ['text' => 'Email descending', 'value' => 'email desc'],
                    ['text' => 'Username ascending', 'value' => 'username asc'],
                    ['text' => 'Username descending', 'value' => 'username desc'],
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
