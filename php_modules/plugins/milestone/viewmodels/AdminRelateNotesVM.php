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

class AdminRelateNotesVM extends ViewModel
{
    protected $alias = 'AdminRelateNotesVM';
    protected $layouts = [
        'layouts.backend.relate_note' => [
            'list',
            'list.row',
            'list.filter'
        ]
    ];

    public function list()
    {
        $filter = $this->filter();
        $urlVars = $this->request->get('urlVars');
        $request_id = (int) $urlVars['request_id'];
        $this->set('request_id', $request_id, true);

        $limit  = $filter->getField('limit')->value;
        $sort   = $filter->getField('sort')->value;
        $search = $filter->getField('search')->value;
        $page   = $this->request->get->get('page', 1);
        if ($page <= 0) $page = 1;

        $where = [];
        $where[] = ['request_id = '. $request_id];

        if( !empty($search) )
        {
            $where[] = "(`title` LIKE '%".$search."%')";
        }
        
        $start  = ($page-1) * $limit;
        $sort = $sort ? $sort : 'title asc';

        $result = $this->RelateNoteEntity->list( 0, 0, $where, 0);
        $total = $this->RelateNoteEntity->getListTotal();
        if (!$result)
        {
            $result = [];
            $total = 0;
        }
        $request = $this->RequestEntity->findByPK($request_id);
        $milestone = $request ? $this->MilestoneEntity->findByPK($request['milestone_id']) : ['title' => '', 'id' => 0];
        $title_page_relate_note = 'Relate Note';
        $title_page = '<a href="'.$this->router->url('admin/notes/').'">Notes</a> | <a href="'. $this->router->url('admin/requests/'. $milestone['id']).'" >'. $milestone['title'].'</a>';

        $note_exist = $this->container->exists('NoteEntity');

        foreach ($result as &$item)
        {
            if ($note_exist)
            {
                $note_tmp = $this->NoteEntity->findByPK($item['note_id']);
                if ($note_tmp)
                {
                    $item['title'] = $note_tmp['title'];
                    $item['description'] = $note_tmp['html_editor'];
                }
            }

            if (strlen($item['description']) > 100)
            {
                $item['description'] = substr($item['description'], 0, 100) .' ...';
            }
        }
        $list   = new Listing($result, $total, $limit, $this->getColumns() );
        $this->set('list', $list, true);
        $this->set('page', $page, true);
        $this->set('start', $start, true);
        $this->set('sort', $sort, true);
        $this->set('user_id', $this->user->get('id'), true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('admin/relate-notes/'. $request_id), true);
        $this->set('title_page_relate_note', $title_page_relate_note, true);
        $this->set('title_page', $title_page, true);
        $this->set('link_form', $this->router->url('admin/relate-note/'. $request_id), true);
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
                'search' => $this->state('search', '', '', 'post', 'relate_note.search'),
                'limit' => $this->state('limit', 10, 'int', 'post', 'relate_note.limit'),
                'sort' => $this->state('sort', '', '', 'post', 'relate_note.sort')
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
