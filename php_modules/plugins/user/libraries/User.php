<?php
/**
 * SPT software - Basic User 
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Basic User for application using SPT
 * 
 */

namespace App\plugins\user\libraries;

use SPT\User\SPT\User as UserParent;

class User extends UserParent
{
    public function login(string $username, string $password, $ip_addr = false)
    {
        // TODO apply middleware or authentication
        $where = $ip_addr ? ['userid' => $username] : ['userid' => $username, 'psw' => $this->enscrypt($password)];
        $user = $this->entity->findOne($where);
        if ($user)
        {
            unset($user['psw']);
            $now = strtotime("now");
            $expire_date = strtotime($user['expire_date']);
            if ($now >= $expire_date)
            {
	            $today = date('Y-m-d');
                // <br>User name (' . $username . ') is NOT a valid user!
                $this->session->set('login_error_msg', 'The access for user ' . $username . ' has expired!<br>today:*' . $today . '* expire:*' . $user['expire_date'] . '*');
                $this->session->set('login_error', 'ERROR');
                return false;
            }
            // check user type
            if ($user['s_type'] == 'teacher' || $user['s_type'] == 'school')
            {
                $hours = $this->getTimeZone('H:i', $user['time_zone']); 
                $day = $this->getTimeZone('w', $user['time_zone']);
                $start_time = strtotime($user['start_time']. ' '. $this->getTimeZoneID($time_zone));
                $end_time = strtotime($user['end_time']. ' '. $this->getTimeZoneID($time_zone));
                if (strtotime($hours) < $start_time || strtotime($hours) > $end_time || $day == 0 || $day == 6)
                {
                    $this->session->set('login_error_msg', 'Your account can only be logged in from '. date('H:i', strtotime($user['start_time'])).' to '. date('H:i', strtotime($user['end_time'])).' and from Monday to Friday');
                    $this->session->set('login_error', 'ERROR');
                    return false;
                }
            }
            $this->session->reload($user['userid'], $user['u_id']);
            $this->data = $user;

            $storage = $this->getContext();
            $this->session->set($storage, $this->data); 
            return $user;
        }
        $this->session->set('login_error_msg', 'USER or PASSWORD not a valid');
        $this->session->set('login_error', 'ERROR');
        return false;
    }

    public function logout()
    {
        if ( $this->get('u_id') )
        {
            $this->reset();
        }

        return true;
    }

    public function enscrypt($str)
    {
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "CxXb";
        $encryption = openssl_encrypt($str, $ciphering, $encryption_key, $options, $encryption_iv);

        return $encryption;
    }

    public function getTimeZone($format, $time_zone)
    {
        return date($format, strtotime( $this->getTimeZoneID($time_zone)));
    }

    public function getTimeZoneID($time_zone)
    {
        $time_zone_list = [
            'EST' => '-5 hours UTC',
            'CST' => '-6 hours UTC',
            'MST' => '-7 hours UTC',
            'PST' => '-8 hours UTC',
            'AKST' => '-9 hours UTC',
            'HAST' => '-10 hours UTC',
            'AST' => '-4 hours UTC',
            'NZST' => '+12 hours UTC',
            'AEST' => '+10 hours UTC',
            'ACWST' => '+8.75 hours UTC',
            'WST' => '+8 hours UTC',
            'EET' => '+2 hours UTC',
            'CET' => '+1 hours UTC',
            'GMT' => '+0 hours UTC',
            'IST' => '+0 hours UTC',
            'WET' => '+0 hours UTC',
            'EGT' => '-1 hours UTC',
            'CGT' => '-3 hours UTC',
            'NST' => '-3.5 hours UTC',
        ];

        return $time_zone_list[$time_zone];
    }
}
