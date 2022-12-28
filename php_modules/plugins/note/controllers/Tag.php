<?php
/**
 * SPT software - homeController
 *
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 *
 */

namespace App\plugins\note\controllers;

use SPT\MVC\JDIContainer\MVController;

class Tag extends Admin {
    public function list()
    {
//        $this->isLoggedIn();

        $name = $this->request->get->get('search', '', 'string');

        $where = [];

        if( !empty($name) )
        {
            $where[] = "(`name` LIKE '%".$name."%' )";
        }

        $data = $this->TagEntity->list(0,100, $where);
        return $this->app->response(
            [
                'status'  => 'success',
                'data'    => $data,
                'message' => '',
            ]);
    }

    public function add(){
        $name = $this->request->post->get('name', '', 'string');

        if (empty($name)){
            return $this->app->response(
                [
                    'status'  => 'fail',
                    'data'    => '',
                    'message' => 'Name invalid',
                ]);
        }

        $findOne = $this->TagEntity->findOne(['name = "'. $name. '"']);
        if (!empty($findOne)){
            return $this->app->response(
                [
                    'status'  => 'fail',
                    'data'    => '',
                    'message' => 'Error: Title is already in use!',
                ]
            );
        }

        $newId =  $this->TagEntity->add([
            'name' => $name,
        ]);

        if ($newId){
            return $this->app->response(
                [
                    'status'  => 'success',
                    'data'    => ['id' => $newId, 'name' => $name],
                    'message' => 'Create Tag sucess',
                ]);
        } else {
            return $this->app->response(
                [
                    'status'  => 'fail',
                    'data'    => '',
                    'message' => 'Error: Create Tag fail!',
                ]);
        }
    }
}