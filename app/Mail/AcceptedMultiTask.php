<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptedMultiTask extends Mailable
{
    public $title;
    public $hour;
    public $acceptedDates;
    public $deniedDates;
    public $message;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $hour, $acceptedDates, $deniedDates, $message)
    {
        $this->title = $title;
        $this->hour = $hour;
        $this->acceptedDates = $acceptedDates;
        $this->deniedDates = $deniedDates;
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
        ->subject('[Geaccepteerd] ' . $this->title)
        ->from(env('MAIL_FROM_ADDRESS'), env('APP_ADMIN_NAME'))
        ->replyTo(env('APP_ADMIN_EMAIL'), env('APP_ADMIN_NAME'))
        ->markdown('emails.acceptedmultitask');

        return $email;
    }
}
