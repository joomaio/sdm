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

    public function validate($data, $id = false)
    {
        // check username
        $where_check = isset($data['id']) ? ['username' => $data['username'], 'email' => $data['email'], "id NOT LIKE '" . $data['id'] ."'"] : ['username' => $data['username'], 'email' => 'email'];

        $check = $this->UserEntity->findOne($where_check);
        if ($check)
        {
            $err_msg[]= 'Username or Email is already in use';
            $err_flg = true;
        }

        else
        {
            $data['start_time'] = "00:00:00";
        }

        if (strlen($data['end_time']) != 0)
        {
            $end_time = $this->HelperModel->validateDate($data['end_time'], 'H:i:s');
            if (!$end_time)
            {
                $err_msg[] = 'The end time is not valied!!';
                $err_flg = true;
            }
            else
            {
                $data['end_time'] = $data['end_time'];
            }
        }
        else
        {
            $data['end_time'] = "00:00:00";
        }

        if (strlen($data['start_date']) == 0)
        {
            $err_msg[] = 'A start date MUST be specified!!';
            $err_flg = true;
        }
        else
        {
            $s_date = $this->HelperModel->validateDate($data['start_date'], 'Y-m-d');
            if (!$s_date)
            {
                $err_msg[] = 'A start date of ' . $data['start_date'] . ' is not a valid date!';
                $err_flg = true;
            }
            else
            {
            }
        }

        if (strlen($data['expire_date']) == 0)
        {
            $err_msg[] = 'An end date MUST be specified!!';
            $err_flg = true;
        }
        else
        {
            $e_date = $this->HelperModel->validateDate($data['expire_date'], 'Y-m-d');
            if (!$e_date)
            {
                $err_msg[] = 'An end date of ' . $data['expire_date'] . ' is not a valid date!';
                $err_flg = true;
            }
            else
            {
            }
        }

        if (strlen($data['payment_date']) == 0)
        {
            $err_msg[] = 'A payment date MUST be specified!!';
            $err_flg = true;
        }
        else
        {
            $p_date = $this->HelperModel->validateDate($data['payment_date'], 'Y-m-d');
            if (!$p_date)
            {
                $err_msg[] = 'A payment date of ' . $data['payment_date'] . ' is not a valid date!';
                $err_flg = true;
            }
            else
            {
            }
        }

        if ($data['s_type'] == "school" && strlen($data['school_name']) == 0)
        {
            $err_msg[] = 'A school name MUST be specified!';
            $err_flg = true;
        }

        if (strlen($data['nu_email']) == 0)
        {
            $err_msg[] = 'An email address MUST be specified!';
            $err_flg = true;
        }

        if (strlen($data['nuserid']) == 0)
        {
            $err_msg[] = 'A userid MUST be specified!';
            $err_flg = true;
        }

        if (strlen($data['u_psw']) == 0 && !$u_id)
        {
            $err_msg[] = 'A password MUST be specified!';
            $err_flg = true;
        }

        if (strlen($data['u_f_name']) == 0)
        {
            $err_msg[] = 'A first name MUST be specified!!';
            $err_flg = true;
        }

        if (strlen($data['u_l_name']) == 0)
        {
            $err_msg[] = 'A last name MUST be specified!!';
            $err_flg = true;
        }

        if (strlen($data['phone']) == 0)
        {
            $err_msg[] = 'A phone number MUST be specified!!';
            $err_flg = true;
        }

        if (strlen($data['addr1']) == 0)
        {
            $err_msg[] = 'An address MUST be specified!!';
            $err_flg = true;
        }

        if (strlen($data['city']) == 0)
        {
            $err_msg[] = 'A city MUST be specified!!';
            $err_flg = true;
        }

        if (strlen($data['state']) == 0)
        {
            $err_msg[] = 'A state MUST be specified!!';
            $err_flg = true;
        }

        if (strlen($data['zip']) == 0)
        {
            $err_msg[] = 'A zip or postal code MUST be specified!!';
            $err_flg = true;
        }

        if ($data['t_count'] < 1)
        {
            $err_msg[] = 'A teacher count MUST be specified!!';
            $err_flg = true;
        }

        if (strlen($data['time_zone']) == 0)
        {
            $err_msg[] = 'A time zone MUST be specified!!';
            $err_flg = true;
        }

        if ($err_flg)
        {
            return [
                'err_flg' => $err_flg,
                'err_msg' => $err_msg,
    
            ];
        }
        return $data;
    }
}
