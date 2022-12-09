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
        
        $mail->Mailer = 'smtp';		
		$mail->ContentType = $content_type;		
		$mail->From = $from_addr;
		$mail->FromName = $from_name;
		$mail->Host = $email_host;
		$mail->Username = $email_username;
		$mail->Password = $email_password;
		$mail->SMTPAuth = true;
		$mail->AddReplyTo($from_addr, $from_name);		
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($to_addr, $to_name);

        if(!$mail->Send()) {
            echo 'Message could not be sent.';
            $this->session('flashMsg', $mail->ErrorInfo);
            return false;
        }         

        return true;
    }
}
