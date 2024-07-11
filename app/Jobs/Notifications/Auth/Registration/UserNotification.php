<?php

namespace App\Jobs\Notifications\Auth\Registration; 

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->details['type'] == "confirm_email")
        {
            return $this->subject($this->details['title'])
            ->view('email.auth.registration.user');
        }
        if($this->details['type'] == "send_cred")
        {
            return $this->subject($this->details['title'])
            ->view('email.auth.registration.send_cred');
        }
        else{
            return $this->subject($this->details['title'])
            ->view('email.auth.registration.send_email');
        }
       
    }
}
