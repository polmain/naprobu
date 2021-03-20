<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Lang;

class ResetPassword extends ResetPasswordNotification
{
    use Queueable;
	public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
		if (static::$toMailCallback) {
			return call_user_func(static::$toMailCallback, $notifiable, $this->token);
		}

		return (new MailMessage)
			->subject(Lang::getFromJson(trans('mail.reset_password_subject')))
			->line(Lang::getFromJson(trans('mail.reset_password_line_1')))
			->action(Lang::getFromJson(trans('mail.reset_password_button')), url(config('app.url').route('password.reset', $this->token, false)))
			->line(Lang::getFromJson(trans('mail.reset_password_line_2')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
