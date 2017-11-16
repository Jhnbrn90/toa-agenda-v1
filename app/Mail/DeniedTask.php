<?php

namespace App\Mail;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeniedTask extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $task;
    public $time;
    public $day;

    public function __construct(Task $task, $time, $day)
    {
        $this->task = $task;
        $this->time = $time;
        $this->day = $day;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this
        ->subject('[Geweigerd] '.$this->task->title)
        ->from(env('APP_ADMIN_EMAIL'), env('APP_ADMIN_NAME'))
        ->replyTo(env('APP_ADMIN_EMAIL'), env('APP_ADMIN_NAME'))
        ->markdown('emails.task-denied');

        return $email;

    }
}
