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
    public $filepath;

    public function __construct(User $user, Task $task, $actionURL, $time, $day, $filepath)
    {
        $this->user = $user;
        $this->task = $task;
        $this->actionURL = $actionURL;
        $this->time = $time;
        $this->day = $day;
        $this->filepath = $filepath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->filepath !== null) {
            $email = $this
            ->subject('[Nieuw verzoek] '.$this->task->title.' (bijlage)')
            ->from($this->user->email, $this->user->name)
            ->replyTo($this->user->email, $this->user->name)
            ->markdown('emails.newtask');

            foreach($this->filepath as $file) {
                $email->attach(storage_path().'/app/'.$file);

            }

        } else {
            $email = $this
            ->subject('[Nieuw verzoek] '.$this->task->title)
            ->from(env('MAIL_FROM_ADDRESS'), $this->user->name)
            ->replyTo($this->user->email, $this->user->name)
            ->markdown('emails.newtask');
        }

        return $email;

    }
}
