<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectedMultiTask extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $title;
    public $time;
    public $dates;
    public $message;

    public function __construct($title, $time, $dates, $message)
    {
        //
        $this->title = $title;
        $this->time = $time;
        $this->dates = $dates;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this
            ->subject('[Geweigerd] ' . $this->title)
            ->from(env('MAIL_FROM_ADDRESS'), env('APP_ADMIN_NAME'))
            ->replyTo(env('APP_ADMIN_EMAIL'), env('APP_ADMIN_NAME'))
            ->markdown('emails.rejectedmultitask');

        return $email;
    }
}
