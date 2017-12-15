<?php

namespace App\Mail;

use App\Task;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMultiTaskRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $task;
    public $time;
    public $day;
    public $filepath;
    public $actionURL;

    public function __construct($user, $task, $time, $day, $filepath, $actionURL)
    {
        $this->user = $user;
        $this->task = $task;
        $this->time = $time;
        $this->day = $day;
        $this->filepath = $filepath;
        $this->actionURL = $actionURL;
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
                ->subject('[Nieuw herhaalverzoek] '.$this->task['title'].' (bijlage)')
                ->from($this->user->email, $this->user->name)
                ->replyTo($this->user->email, $this->user->name)
                ->markdown('emails.multitaskrequest');

                foreach($this->filepath as $file) {
                    $email->attach(storage_path().'/app/'.$file);
                }

            } else {
                $email = $this
                ->subject('[Nieuw herhaalverzoek] '.$this->task['title'])
                ->from($this->user->email, $this->user->name)
                ->replyTo($this->user->email, $this->user->name)
                ->markdown('emails.multitaskrequest');
            }

            return $email;

        }

}
