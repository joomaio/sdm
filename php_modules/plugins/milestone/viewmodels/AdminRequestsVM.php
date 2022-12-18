<?php
/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic viewmodel
 * 
 */
namespace App\plugins\milestone\viewmodels; 

use SPT\View\Gui\Form;
use SPT\View\Gui\Listing;
use SPT\View\VM\JDIContainer\ViewModel;
use SPT\Util;

class AdminRequestsVM extends ViewModel
{
    protected $alias = 'AdminRequestsVM';
    protected $layouts = [
        'layouts.backend.request' => [
            'list',
            'list.row',
            'list.filter'
        ]
    ];

    public function list()
    {
        $filter = $this->filter();
        $urlVars = $this->request->get('urlVars');
        $milestone_id = (int) $urlVars['milestone_id'];
        $this->set('milestone_id', $milestone_id, true);

        $limit  = $filter->getField('limit')->value;
        $sort   = $filter->getField('sort')->value;
        $search = $filter->getField('search')->value;
        $status = $filter->getField('status')->value;
        $page   = $this->request->get->get('page', 1);
        if ($page <= 0) $page = 1;

        $where = [];
        $where[] = ['milestone_id = '. $milestone_id];

        if( !empty($search) )
        {
            $where[] = "(`title` LIKE '%".$search."%')";
        }
        if(is_numeric($status))
        {
            $where[] = '`status`='. $status;
        }

        $start  = ($page-1) * $limit;
        $sort = $sort ? $sort : 'title asc';

        $result = $this->RequestEntity->list( $start, $limit, $where, $sort);
        $total = $this->RequestEntity->getListTotal();
        if (!$result)
        {
            $result = [];
            $total = 0;
            if( !empty($search) )
            {
                $this->session->set('flashMsg', 'Not Found Request');
            }
        }
        $milestone = $this->MilestoneEntity->findByPK($milestone_id);
        $title_page = $milestone ? $milestone['title'] .' - Request List' : 'Request List';

        foreach($result as &$item)
        {
            $user_tmp = $this->UserEntity->findByPK($item['created_by']);
            $item['creator'] = $user_tmp ? $user_tmp['name'] : '';
        }
        
        $list   = new Listing($result, $total, $limit, $this->getColumns() );
        $this->set('list', $list, true);
        $this->set('page', $page, true);
        $this->set('start', $start, true);
        $this->set('sort', $sort, true);
        $this->set('user_id', $this->user->get('id'), true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('requests/'. $milestone_id), true);
        $this->set('title_page', $title_page, true);
        $this->set('link_form', $this->router->url('request/'. $milestone_id), true);
        $this->set('link_detail', $this->router->url('detail-request'), true);
        $this->set('token', $this->app->getToken(), true);
    }

    public function getColumns()
    {
        return [
            'num' => '#',
            'title' => 'Title',
            'status' => 'Status',
            'created_at' => 'Created at',
            'col_last' => ' ',
        ];
    }

    protected $_filter;
    public function filter()
    {
        if( null === $this->_filter):
            $data = [
                'search' => $this->state('search', '', '', 'post', 'request.search'),
                'status' => $this->state('status', '','', 'post', 'request.status'),
                'limit' => $this->state('limit', 10, 'int', 'post', 'request.limit'),
                'sort' => $this->state('sort', '', '', 'post', 'request.sort')
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
                    ['text' => 'Active', 'value' => '1'],
                    ['text' => 'Inactive', 'value' => '0'],
                ],
                'showLabel' => false
            ],
            'limit' => ['option',
                'formClass' => 'form-select',
                'default' => 10,
                'options' => [ 5, 10, 20, 50],
                'showLabel' => false
            ],
            'sort' => ['option',
                'formClass' => 'form-select',
                'default' => 'title asc',
                'options' => [
                    ['text' => 'Title ascending', 'value' => 'title asc'],
                    ['text' => 'Title descending', 'value' => 'title desc'],
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
