<?php

namespace App\Services;

use Mail;

class EmailService
{
    /**
     * @var Mail
     */
    protected $mail;

    /**
     * EmailService constructor.
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * 发送邮件
     * @param $email
     * @param $subject
     * @param $view
     * @param array $data
     */
    public function sendEmail($email, $subject, $view, $data = []){
        $this->mail::queue($view, $data, function($message) use($email, $subject){
            $message->to($email)->subject($subject);
        });
    }
}