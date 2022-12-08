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
        return $this->responseJson('success', '', $data);
    }

    public function add(){
        $name = $this->request->post->get('name', '', 'string');

        if (empty($name)){
            return $this->responseJson('fail', 'Name invalid');
        }

        $findOne = $this->TagEntity->findOne(['name = "'. $name. '"']);
        if (!empty($findOne)){
            return $this->responseJson('fail', 'Error: Title is already in use!');
        }

        $newId =  $this->TagEntity->add([
            'name' => $name,
        ]);

        if ($newId){
            return $this->responseJson('success', 'Create Tag sucess', ['id' => $newId, 'name' => $name]);
        } else {
            return $this->responseJson('fail', 'Error: Create Tag fail!');
        }
    }

    private function responseJson ($status, $message = '', $data = [], $code = 200){
        header('Content-Type: application/json; charset=utf-8');
        $response = [
            'status'  => $status,
            'data'    => $data,
            'message' => $message,
            'code'    => $code
        ];
        echo json_encode($response);
        die();
    }
}