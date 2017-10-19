<?php

namespace App\Mail;

use App\Task;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTaskRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $task;
    public $actionURL;
    public $time;
    public $day;

    public function __construct(User $user, Task $task, $actionURL, $time, $day)
    {
        $this->user = $user;
        $this->task = $task;
        $this->actionURL = $actionURL;
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
        return $this
        ->subject('[Nieuw verzoek] '.$this->task->title)
        ->from($this->user->email, $this->user->name)
        ->markdown('emails.newtask');
    }
}
