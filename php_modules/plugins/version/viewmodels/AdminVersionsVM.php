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

class AdminVersionsVM extends ViewModel
{
    protected $alias = 'AdminVersionsVM';
    protected $layouts = [
        'layouts.backend.version' => [
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
        $page   = $this->request->get->get('page', 1);
        if ($page <= 0) $page = 1;

        $where = [];


        if (!empty($search)) {
            $where[] = "(`name` LIKE '%" . $search . "%')";
            $where[] = "(`version` LIKE '%" . $search . "%')";
            $where[] = "(`description` LIKE '%" . $search . "%')";
            $where = [implode(' OR ', $where)];
        }

        $start  = ($page - 1) * $limit;
        $sort = $sort ? $sort : 'created_at desc';

        $result = $this->VersionEntity->list($start, $limit, $where, $sort);
        $total = $this->VersionEntity->getListTotal();

        $get_log = [];
        $get_log = $this->VersionNoteEntity->list(0, 0, $where, 0);

        if (!$result) {
            $result = [];
            $total = 0;
            $mgs = $search ? 'Version not found!' : '';
            $this->session->set('flashMsg', $mgs);
        }
        $tag_feedback = $this->TagEntity->findOne(["`name` = 'feedback'"]);

        foreach ($result as &$version) {
            $tag_exist = $this->container->exists('TagEntity');
            $note_exist = $this->container->exists('NoteEntity');
            $total_feedback = 0;
            if ($tag_exist && $note_exist) {
                $tag_version = $this->TagEntity->findOne(["`name` = '" . $version['version'] . "'"]);
                $where = [];
                if ($tag_feedback && $tag_version) {
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
                    $result_feedback = $this->NoteEntity->list(0, 0, $where, '');
                    $total_feedback = $this->NoteEntity->getListTotal();
                }
            }
            if($total_feedback) {
                $version['feedback'] = $total_feedback;
            } else {
                $version['feedback'] = 0;
            }
        }

        $version_number = $this->VersionModel->getVersion();
        $list = new Listing($result, $total, $limit, $this->getColumns());

        $this->set('list', $list, true);
        $this->set('page', $page, true);
        $this->set('start', $start, true);
        $this->set('sort', $sort, true);
        $this->set('version_number', $version_number, true);
        $this->set('get_log', $get_log, true);
        $this->set('user_id', $this->user->get('id'), true);
        $this->set('url', $this->router->url(), true);
        $this->set('link_list', $this->router->url('versions'), true);
        $this->set('title_page', 'Version Manager', true);
        $this->set('link_form', $this->router->url('version'), true);
        $this->set('link_form_detail', $this->router->url('version-notes'), true);
        $this->set('token', $this->app->getToken(), true);
    }

    public function getColumns()
    {
        return [
            'num' => '#',
            'title' => 'Title',
            'release' => 'release',
            'created_at' => 'Created at',
            'col_last' => ' ',
        ];
    }

    protected $_filter;
    public function filter()
    {
        if (null === $this->_filter) :
            $data = [
                'search' => $this->state('search', '', '', 'post', 'version.search'),
                'limit' => $this->state('limit', 10, 'int', 'post', 'version.limit'),
                'sort' => $this->state('sort', '', '', 'post', 'version.sort')
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
                'default' => 'created_at desc',
                'options' => [
                    ['text' => 'Name ascending', 'value' => 'name asc'],
                    ['text' => 'Name descending', 'value' => 'name desc'],
                    ['text' => 'Date ascending', 'value' => 'created_at asc'],
                    ['text' => 'Date descending', 'value' => 'created_at desc'],
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
