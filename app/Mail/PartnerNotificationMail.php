<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\EmailTemplate;

class PartnerNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body)
    {
        $this->body  = $body;
        $this->subject  = $subject;
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
