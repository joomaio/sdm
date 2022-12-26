<?php

/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: A simple View Model
 * 
 */

namespace App\plugins\note\viewmodels;

use SPT\View\Gui\Form;
use SPT\View\Gui\Listing;
use SPT\View\VM\JDIContainer\ViewModel;
use SPT\Util;

class AdminNotesVM extends ViewModel
{
    protected $alias = 'AdminNotesVM';
    protected $layouts = [
        'layouts.backend.note' => [
            'list',
            'list.row',
            'list.filter'
        ]
    ];

    public function list()
    {
//        echo '123';die();
        $filter = $this->filter();

        $limit  = $filter->getField('limit')->value;
        $sort   = $filter->getField('sort')->value;
        $search = $filter->getField('search')->value;
//        $status = $filter->getField('tags')->value;
        $page   = $this->request->get->get('page', 1);
        if ($page <= 0) $page = 1;

        $where = [];

        if( !empty($search) )
        {
            $tags = $this->TagEntity->list(0, 0, ["`name` LIKE '%". $search ."%' "]);
            $where = ["(`description` LIKE '%". $search ."%')", "(`title` LIKE '%". $search ."%')"];
            if ($tags)
            {
                foreach ($tags as $tag)
                {
                    $where[] = "(`tags` = '" . $tag['id'] . "'" .
                    " OR `tags` LIKE '%" . ',' . $tag['id'] . "'" .
                    " OR `tags` LIKE '" . $tag['id'] . ',' . "%'" .
                    " OR `tags` LIKE '%" . ',' . $tag['id'] . ',' . "%' )";
                }

                $where = [implode(" OR ", $where)];
            }
        }

        $start  = ($page-1) * $limit;
        $sort = $sort ? $sort : 'title asc';

        $result = $this->NoteEntity->list( $start, $limit, $where, $sort);
        $total = $this->NoteEntity->getListTotal();
        $data_tags = [];
        foreach ($result as $item){
            if (!empty($item['tags'])){
                $t1 = $where = [];
                $where[] = "(`id` IN (".$item['tags'].") )";
                $t2 = $this->TagEntity->list(0, 1000, $where,'','`name`');

                foreach ($t2 as $i) $t1[] = $i['name'];

                $data_tags[$item['id']] = implode(',', $t1);
            }
        }
        if (!$result)
        {
            $result = [];
            $total = 0;
            if( !empty($search) )
            {
                $this->session->set('flashMsg', 'Not Found Note');
            }
        }

        $list   = new Listing($result, $total, $limit, $this->getColumns() );
        $this->set('list', $list, true);
        $this->set('data_tags', $data_tags, true);
        $this->set('page', $page, true);
        $this->set('start', $start, true);
        $this->set('sort', $sort, true);
        $this->set('user_id', $this->user->get('id'), true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('notes'), true);
        $this->set('title_page', 'Note Manager', true);
        $this->set('link_form', $this->router->url('note'), true);
        $this->set('token', $this->app->getToken(), true);
    }

    public function getColumns()
    {
        return [
            'num' => '#',
            'title' => 'Title',
//            'status' => 'Status',
            'created_at' => 'Created at',
            'col_last' => ' ',
        ];
    }

    protected $_filter;
    public function filter()
    {
        if( null === $this->_filter):
            $data = [
                'search' => $this->state('search', '', '', 'post', 'note.search'),
                'tags' => $this->state('tags', '','', 'post', 'note.tags'),
                'limit' => $this->state('limit', 10, 'int', 'post', 'note.limit'),
                'sort' => $this->state('sort', '', '', 'post', 'note.sort')
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
                    ['text' => 'Show', 'value' => '1'],
                    ['text' => 'Hide', 'value' => '0'],
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
