<?php

namespace App\Mail\User;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewPassword extends Mailable
{
    use Queueable, SerializesModels;

	public $password;
	public $user;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user,$password)
	{
		$this->user = $user;
		$this->password = $password;
	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		return $this->view('mail.user.new_password')->subject('Новий пароль для сайту naprobu.ua');
    }
}
