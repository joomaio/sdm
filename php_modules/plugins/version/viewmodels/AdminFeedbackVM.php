<?php

/**
 * SPT software - ViewModel
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Just a basic viewmodel
 * 
 */

namespace App\plugins\version\viewmodels;

use SPT\View\Gui\Form;
use SPT\View\Gui\Listing;
use SPT\View\VM\JDIContainer\ViewModel;
use SPT\Util;

class AdminFeedbackVM extends ViewModel
{
    protected $alias = 'AdminFeedbackVM';
    protected $layouts = [
        'layouts.backend.feedback' => [
            'list',
            'list.row',
            'list.filter',
        ]
    ];

    public function list()
    {
        $filter = $this->filter();
        $urlVars = $this->request->get('urlVars');
        $version_id = (int) $urlVars['version_id'];
        $this->set('version_id', $version_id, true);

        $limit  = $filter->getField('limit')->value;
        $sort   = $filter->getField('sort')->value;
        $search = $filter->getField('search')->value;
        $page   = $this->request->get->get('page', 1);
        if ($page <= 0) $page = 1;

        $where = [];

        if (!empty($search)) 
        {
            $tags = $this->TagEntity->list(0, 0, ["`name` LIKE '%". $search ."%' "]);
            $where[] = "(`description` LIKE '%". $search ."%')";
            $where[] = "(`note` LIKE '%". $search ."%')";
            $where[] = "(`title` LIKE '%". $search ."%')";
            if ($tags)
            {
                foreach ($tags as $tag)
                {
                    $where[] = "(`tags` = '" . $tag['id'] . "'" .
                    " OR `tags` LIKE '%" . ',' . $tag['id'] . "'" .
                    " OR `tags` LIKE '" . $tag['id'] . ',' . "%'" .
                    " OR `tags` LIKE '%" . ',' . $tag['id'] . ',' . "%' )";
                }
            }
            $where = [implode(" OR ", $where)];
        }

        $start  = ($page - 1) * $limit;
        $sort = $sort ? $sort : 'title asc';

        $version = $this->VersionEntity->findByPK($version_id);
        $tag_exist = $this->container->exists('TagEntity');
        $note_exist = $this->container->exists('NoteEntity');
        $result = [];
        if ($tag_exist && $note_exist && $version) {
            
            $tag_feedback = $this->TagEntity->findOne(["`name` = 'feedback'"]);
            $tag_version = $this->TagEntity->findOne(["`name` = '". $version['version']."'"]);
            if ($tag_feedback && $tag_version)
            {
                $where = array_merge($where, [
                    "(`tags` = '" . $tag_feedback['id'] . "'" .
                    " OR `tags` LIKE '%" . ',' . $tag_feedback['id'] . "%'" .
                    " OR `tags` LIKE '%" . $tag_feedback['id'] . ',' . "%'" .
                    " OR `tags` LIKE '%" . ',' . $tag_feedback['id'] . ',' . "%' )",
                    "(`tags` = '" . $tag_version['id'] . "'" .
                    " OR `tags` LIKE '%" . ',' . $tag_version['id'] . "%'" .
                    " OR `tags` LIKE '%" . $tag_version['id'] . ',' . "%'" .
                    " OR `tags` LIKE '%" . ',' . $tag_version['id'] . ',' . "%' )"
                ]);
                $result = $this->NoteEntity->list($start, $limit, $where, $sort);
                $total = $this->NoteEntity->getListTotal();
            }
        }
        $data_tags = [];
        foreach ($result as $item){
            if (!empty($item['tags'])){
                $t1 = $where = [];
                $where[] = "(`id` IN (".$item['tags'].") )";
                $t2 = $this->TagEntity->list(0, 1000, $where,'','`name`');

                foreach ($t2 as $i) {
                    if($i['name'] != $tag_feedback['name'] && $i['name'] != $tag_version['name']) {
                        $t1[] = $i['name'];
                    }
                }
                $data_tags[$item['id']] = implode(', ', $t1);
            }
        }

        if (!$result) {
            $result = [];
            $total = 0;
            $mgs = $search ? 'Feedback not found!' : '';
            $this->session->set('flashMsg', $mgs);
        }

        

        $list = new Listing($result, $total, $limit, $this->getColumns());
        $version = $version ? $version : ['name' => ''];
        $title_page = $version['name'] ? '<a href="'. $this->router->url('versions/').'" >Version: '.$version['name'].'</a> >> Feedback ' : 'Feedback';

        $this->set('list', $list, true);
        $this->set('url', $this->router->url(), true);
        $this->set('data_tags', $data_tags, true);
        $this->set('link_cancel', $this->router->url('versions'), true);
        $this->set('title_page', $title_page, true);
        $this->set('link_form', $this->router->url('note'), true);
        $this->set('token', $this->app->getToken(), true);
    }
    public function getColumns()
    {
        return [
            'num' => '#',
            'title' => 'Title',
            'created_at' => 'Created at',
            'col_last' => ' ',
        ];
    }

    protected $_filter;
    public function filter()
    {
        if (null === $this->_filter) :
            $data = [
                'search' => $this->state('search', '', '', 'post', 'version_feedback.search'),
                'limit' => $this->state('limit', 10, 'int', 'post', 'version_feedback.limit'),
                'sort' => $this->state('sort', '', '', 'post', 'version_feedback.sort')
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
            'limit' => [
                'option',
                'formClass' => 'form-select',
                'default' => 10,
                'options' => [5, 10, 20, 50],
                'showLabel' => false
            ],
            'sort' => [
                'option',
                'formClass' => 'form-select',
                'default' => 'title asc',
                'options' => [
                    ['text' => 'title ascending', 'value' => 'title asc'],
                    ['text' => 'title descending', 'value' => 'title desc'],
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
