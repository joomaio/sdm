<?php
/**
 * SPT software - Model
 * 
 * @project: https://github.com/smpleader/spt
 * @author: Pham Minh - smpleader
 * @description: Just a basic model
 * 
 */

namespace App\plugins\setting\models;

use PHPMailer\PHPMailer\PHPMailer;
use SPT\JDIContainer\Base; 

class EmailModel extends Base 
{ 
    public function send($to_addr, $to_name, $body, $subject, $from_addr = '', $from_name = '', $content_type = 'text/html')
    {
        $from_addr = $from_addr ? $from_addr : $this->OptionModel->get('email_from_addr', '');
        $from_name = $from_name ? $from_name : $this->OptionModel->get('email_from_name', '');
        $email_host = $this->OptionModel->get('email_host', '');
        $email_username = $this->OptionModel->get('email_username', '');
        $email_password = $this->OptionModel->get('email_password', '');

        $mailer = new PHPMailer();
        
        $mailer->Mailer = 'smtp';		
		$mailer->ContentType = $content_type;		
		$mailer->From = $from_addr;
		$mailer->FromName = $from_name;
		$mailer->Host = $email_host;
		$mailer->Username = $email_username;
		$mailer->Password = $email_password;
		$mailer->SMTPAuth = true;
		$mailer->AddReplyTo($from_addr, $from_name);		
		$mailer->Subject = $subject;
		$mailer->Body = $body;
		$mailer->AddAddress($to_addr, $to_name);

        if(!$mailer->Send()) {
            $this->session->set('flashMsg', 'Error: '. $mailer->ErrorInfo);
            return false;
        }         

        return true;
    }
}
