<?php
/**
 * SPT software - homeController
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic controller
 * 
 */

namespace App\plugins\user\controllers;

use App\plugins\user\controllers\Admin;

class User extends Admin
{
    public function list()
    {
        $this->isAdmin();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.user.list');
        $this->app->set('page', 'backend');
    }

    public function detail()
    {
        $this->isAdmin();
        $this->app->set('format', 'html');
        $this->app->set('layout', 'backend.user.form');
        $this->app->set('page', 'backend');
    }

    public function add()
    {
        $this->isAdmin();
        $this->validateToken();

        $data = [];
        $data['nuserid'] = $this->request->post->get('userid', '', 'string');
        $data['nu_email'] = $this->request->post->get('u_email', '', 'string');
        $data['nu_type'] = $this->request->post->get('u_type', '', 'string');
        $data['u_psw'] = $this->request->post->get('psw', '', 'string');
        $data['s_type'] = $this->request->post->get('s_type', '', 'string');
        $data['u_f_name'] = $this->request->post->get('u_f_name', '', 'string');
        $data['grade_level'] = $this->request->post->get('grade_level', '', 'string');
        $data['u_l_name'] = $this->request->post->get('u_l_name', '', 'string');
        $data['phone'] = $this->request->post->get('phone', '', 'string');
        $data['school_name'] = $this->request->post->get('school_name', '', 'string');
        $data['t_count'] = $this->request->post->get('t_count', '', 'string');
        $data['addr1'] = $this->request->post->get('addr1', '', 'string');
        $data['addr2'] = $this->request->post->get('addr2', '', 'string');
        $data['city'] = $this->request->post->get('city', '', 'string');
        $data['state'] = $this->request->post->get('state', '', 'string');
        $data['zip'] = $this->request->post->get('zip', '', 'string');
        $data['country'] = $this->request->post->get('country', '', 'string');
        $data['time_zone'] = $this->request->post->get('time_zone', '', 'string');
        $data['start_time'] = $this->request->post->get('start_time', '', 'string');
        $data['end_time'] = $this->request->post->get('end_time', '', 'string');
        $data['start_date'] = $this->request->post->get('start_date', '', 'string');
        $data['payment_date'] = $this->request->post->get('payment_date', '0000-00-00', 'string');
        $data['expire_date'] = $this->request->post->get('expire_date', '0000-00-00', 'string');
        $data['gift_name'] = $this->request->post->get('gift_name', '', 'string');
        $data['ip_addr1'] = $this->request->post->get('ip_login', '', 'string');
        $data['ip_addr2'] = $this->request->post->get('ip_addr2', '', 'string');
        $data['expire_date'] = $data['expire_date'] ? $data['expire_date'] : '0000-00-00';
        $data['payment_date'] = $data['payment_date'] ? $data['payment_date'] : '0000-00-00';
        $validate = $this->UserModel->validate($data);
        $validate['expire_date'] = $validate['expire_date'] == '0000-00-00' ? null : $validate['expire_date'];
        $validate['payment_date'] = $validate['payment_date'] == '0000-00-00' ? null : $validate['payment_date'];
        if (!$validate['err_flg'])
        {
            $new_id = $this->UserEntity->add([
                'userid' => $validate['nuserid'],
                'u_type' => $validate['nu_type'],
                'u_email' => $validate['nu_email'],
                'psw' => $this->HelperModel->enscrypt($validate['u_psw']),
                's_type' => $validate['s_type'],
                'phone' => $validate['phone'],
                'gift_name' => $validate['gift_name'],
                't_count' => $validate['t_count'],
                'grade_level' => $validate['grade_level'],
                'u_f_name' => $validate['u_f_name'],
                'u_l_name' => $validate['u_l_name'],
                'school_name' => $validate['school_name'],
                'addr1' => $validate['addr1'],
                'addr2' => $validate['addr2'],
                'city' => $validate['city'],
                'state' => $validate['state'],
                'time_zone' => $validate['time_zone'],
                'start_date' => $validate['start_date'],
                'zip' => $validate['zip'],
                'start_time' => $validate['start_time'],
                'expire_date' => $validate['expire_date'],
                'country' => $validate['country'],
                'end_time' => $validate['end_time'],
                'payment_date' => $validate['payment_date'],
                'created_by' => $this->user->get('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'modified_by' => $this->user->get('id'),
                'modified_at' => date('Y-m-d H:i:s')
    
            ]);
            if ($validate['ip_addr1'] && $new_id)
            {
                $this->IPLoginEntity->add([
                    'u_id' => $new_id,
                    'ip_addr' => $validate['ip_addr1'],
                ]);
            }

            if ($new_id)
            {
                $this->session->set('flashMsg', 'Create User: '. $validate['nuserid'] .' Successfully.');
                $this->app->redirect($this->router->url('admin/user/'. $new_id));
            }
            else
            {
                $this->session->set('flashMsg', 'Create User Failed.');
                $this->app->redirect($this->router->url('admin/user/0'));
            }
            
        }
        else
        {
            $this->session->set('flashMsg', $validate['err_msg']);
            $this->app->redirect($this->router->url('admin/user/0'));
        }
        
    }

    public function update()
    {
        $this->isAdmin();
        $this->validateToken();

        $u_id = $this->validateId();
        $data = [];
        if ($u_id)
        {
            $data = [
                'nuserid' => $this->request->post->get('userid', '', 'string'),
                'nu_email' => $this->request->post->get('u_email', '', 'string'),
                'nu_type' => $this->request->post->get('u_type', '', 'string'),
                'u_psw' => $this->request->post->get('psw', '', 'string'),
                's_type' => $this->request->post->get('s_type', '', 'string'),
                'u_f_name' => $this->request->post->get('u_f_name', '', 'string'),
                'grade_level' => $this->request->post->get('grade_level', '', 'string'),
                'u_l_name' => $this->request->post->get('u_l_name', '', 'string'),
                'phone' => $this->request->post->get('phone', '', 'string'),
                'school_name' => $this->request->post->get('school_name', '', 'string'),
                't_count' => $this->request->post->get('t_count', '', 'string'),
                'addr1' => $this->request->post->get('addr1', '', 'string'),
                'addr2' => $this->request->post->get('addr2', '', 'string'),
                'city' => $this->request->post->get('city', '', 'string'),
                'state' => $this->request->post->get('state', '', 'string'),
                'zip' => $this->request->post->get('zip', '', 'string'),
                'country' => $this->request->post->get('country', '', 'string'),
                'time_zone' => $this->request->post->get('time_zone', '', 'string'),
                'start_time' => $this->request->post->get('start_time', '', 'string'),
                'end_time' => $this->request->post->get('end_time', '', 'string'),
                'start_date' => $this->request->post->get('start_date', '', 'string'),
                'payment_date' => $this->request->post->get('payment_date', '', 'string'),
                'expire_date' => $this->request->post->get('expire_date', '', 'string'),
                'gift_name' => $this->request->post->get('gift_name', '', 'string'),
                'ip_addr1' => $this->request->post->get('ip_login', '', 'string'),
                'ip_addr2' => $this->request->post->get('ip_addr2', '', 'string'),
            ];
            $data['expire_date'] = $data['expire_date'] ? $data['expire_date'] : '0000-00-00';
            $data['payment_date'] = $data['payment_date'] ? $data['payment_date'] : '0000-00-00';
    
            $validate = $this->UserModel->validate($data, $u_id);
            $validate['expire_date'] = $validate['expire_date'] == '0000-00-00' ? null : $validate['expire_date'];
            $validate['payment_date'] = $validate['payment_date'] == '0000-00-00' ? null : $validate['payment_date'];
    
            if (!$validate['err_flg'])
            {
                $user_update = [
                    'userid' => $validate['nuserid'],
                    'u_type' => $validate['nu_type'],
                    'u_email' => $validate['nu_email'],
                    's_type' => $validate['s_type'],
                    'phone' => $validate['phone'],
                    'gift_name' => $validate['gift_name'],
                    't_count' => $validate['t_count'],
                    'grade_level' => $validate['grade_level'],
                    'u_f_name' => $validate['u_f_name'],
                    'u_l_name' => $validate['u_l_name'],
                    'school_name' => $validate['school_name'],
                    'addr1' => $validate['addr1'],
                    'addr2' => $validate['addr2'],
                    'city' => $validate['city'],
                    'state' => $validate['state'],
                    'time_zone' => $validate['time_zone'],
                    'start_date' => $validate['start_date'],
                    'zip' => $validate['zip'],
                    'start_time' => $validate['start_time'],
                    'expire_date' => $validate['expire_date'],
                    'country' => $validate['country'],
                    'end_time' => $validate['end_time'],
                    'payment_date' => $validate['payment_date'],
                    'u_id' => $u_id,
                    'modified_by' => $this->user->get('id'),
                    'modified_at' => date('Y-m-d H:i:s'),
                ];

                if ($data['u_psw'])
                {
                    $user_update['psw'] = $this->HelperModel->enscrypt($validate['u_psw']);
                }
                $try = $this->UserEntity->update($user_update);
                // remove ip_login
                $ip_login = $this->IPLoginEntity->findOne(['u_id' => $u_id]);
                
                if (isset($validate['ip_addr1']) && strlen(trim($validate['ip_addr1'])) > 2 && $try)
                {
                    if ($ip_login)
                    {
                        $this->IPLoginEntity->update([
                            'u_id' => $u_id,
                            'ip_addr' => $validate['ip_addr1'],
                            'id' => $ip_login['id'],
                        ]);
                    }
                    else
                    {
                        $this->IPLoginEntity->add([
                            'u_id' => $u_id,
                            'ip_addr' => $validate['ip_addr1'],
                        ]);
                    }
                    
                }

                if ($try)
                {
                    $this->session->set('flashMsg', 'Update User: '. $validate['nuserid'] .' Successfully');
                    $this->app->redirect($this->router->url('admin/users'));
                }
                else
                {
                    $this->session->set('flashMsg', 'Update User: '. $validate['nuserid'] .' Fail');
                    $this->app->redirect($this->router->url('admin/user/'. $u_id));
                }
            }
            else
            {
                $this->session->set('flashMsg', $validate['err_msg']);
                $this->app->redirect($this->router->url('admin/user/'. $u_id));
            }
        }

        $this->session->set('flashMsg', 'Invalid User');

        $this->app->redirect(
            $this->router->url('admin/users'),
        );
    }

    public function delete()
    {
        $this->isAdmin();
        $this->validateToken();

        $id = $this->validateId();

        if ($id && !is_array($id))
        {
            $try = $this->UserEntity->remove($id);
            
            if ($try)
            {
                $this->IPLoginEntity->remove_bulks($id, 'u_id');
                $this->session->set('flashMsg', "Delete of user id ". $id." was successful");
            }
            else
            {
                $this->session->set('flashMsg', "Delete of user id ". $id." fail");
            }
        }
        elseif(is_array($id))
        {
            $count = 0;
            foreach ($id as $item)
            {
                $try = $this->UserEntity->remove($id);
                $this->IPLoginEntity->remove_bulks($id, 'u_id');
                $count = $try ? $count + 1 : $count;
            }

            $this->session->set('flashMsg', "Delete ". $count." user was successful");
        }

        $this->app->redirect(
            $this->router->url('admin/users'),
        );
    }

    public function validateId()
    {
        $urlVars = $this->request->get('urlVars');
        $id = (int) $urlVars['id'];
        if(empty($id))
        {
            $id = $this->request->post->post('ids', [], 'array');
            if (!$id)
            {
                $this->session->set('flashMsg', 'Invalid User');

                $this->app->redirect(
                    $this->router->url('admin/users'),
                );
            }
        }

        return $id;
    }
}