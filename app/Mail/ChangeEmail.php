<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $user;
    public function __construct($title, $user)
    {
        // 
        $this->title = $title;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject($this->title)->view('change-email');
    }
    public function envelope()
    {
        return new Envelope(
            subject: 'Change Email',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'change-email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
