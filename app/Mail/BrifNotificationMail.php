<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\EmailTemplate;

class BrifNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($answers)
    {

		$this->body  = $answers;

		$this->subject  = "Заполнен бриф на сайте naprobu.ua";
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
