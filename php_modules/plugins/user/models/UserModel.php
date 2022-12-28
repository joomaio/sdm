<?php
/**
 * SPT software - Model
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic model
 * 
 */

namespace App\plugins\user\models;

use SPT\JDIContainer\Base; 

class UserModel extends Base 
{ 
    // Write your code here
    public function getRightAccess()
    {
        $access = [];
        foreach($this->plugin as $key => $plugin)
        {
            $right_access = [];
            if (method_exists($this->plugin->$key, 'getRightAccess'))
            {
                $right_access = $this->plugin->$key->getRightAccess();
            }

            if (is_array($right_access) && $right_access)
            {
                $access = array_merge($right_access, $access);
            }
        }

        return $access;
    }

    public function validate($id)
    {
        $password = $this->request->post->get('password', '', 'string');
        $username = $this->request->post->get('username', '', 'string');
        $email = $this->request->post->get('email', '', 'string');

        if(!empty($password)) 
        {
            $password = $password;
            if (strlen($password) < '6') 
            {
                $this->session->set('validate', "Error: Your Password Must Contain At Least 6 Characters!");
                return false;
            }
        } 
        elseif (!$id) 
        {
            $this->session->set('validate', "Error: Passwords cant't empty");
            return false;
        }

        // validate user name
        if(!empty($username)) 
        {
            $username = $username;
            $find = $this->UserEntity->findOne(['username' => $username]);
            if ($find && $find['id'] != $id)
            {
                $this->session->set('validate', "Error: Username already exists");
                return false;
            }
        } 
        else 
        {
            $this->session->set('validate', "Error: UserName cant't empty");
            return false;
        }

        //validate email
        if(!empty($email)) {
            $email = $email;
            $findEmail = $this->UserEntity->findOne(['email' => $email]);
            if ($findEmail && $findEmail['id'] != $id)
            {
                $this->session->set('validate', "Error: Email already exists");
                return false;
            }
        } else {
            $this->session->set('validate', "Error: Email can't empty");
            return false;
        }
        
        return true;
    }

    public function getAccessByGroup($groups)
    {
        $access = [];
        foreach($groups as $group)
        {
            $group_tmp = $this->GroupEntity->findByPK($group);
            if ($group_tmp)
            {
                $access_tmp = $group_tmp['access'] ? json_decode($group_tmp['access'], true) : [];
                $access = array_merge($access, $access_tmp);
            }
        }

        return $access;
    }
}
