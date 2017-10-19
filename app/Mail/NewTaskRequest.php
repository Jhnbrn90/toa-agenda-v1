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


    public function __construct(User $user, Task $task, $actionURL)
    {
        $this->user = $user;
        $this->task = $task;
        $this->actionURL = $actionURL;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('[Nieuw] Nieuw verzoek')
        ->markdown('emails.newtask');
    }
}
