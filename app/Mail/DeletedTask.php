<?php

namespace App\Mail;

use App\Task;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeletedTask extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $task;
    public $user;
    public $date;
    public $time;

    public function __construct($task, $user, $date, $time)
    {
        $this->task = $task;
        $this->user = $user;
        $this->date = $date;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this
        ->subject('[Verwijderd] ' . $this->task['title'])
        ->from($this->user['email'], $this->user['name'])
        ->markdown('emails.deleted-task');
    }
}
