<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\EmailTemplate;

class UserNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $body;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $action, $link = "", $params = [])
    {
		$this->user = $user;
		$template = EmailTemplate::where([
			['name', $action],
			['lang', $user->lang],
		])->first();

		$text = $template->template;

		foreach ($params as $key => $param){
			$text  = str_replace(':'.$key.':',$param, $text );
		}

		if(isset($link)){
			$text .= ' <a href="'.$link.'" target="_blank">'.trans('global.detail').'</a>';
		}
		$this->body  = $text;

		$this->subject  = $template->subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.notification')->subject($this->subject);
    }
}
