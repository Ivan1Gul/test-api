<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $attachmentPath;

    public function __construct($details, $attachmentPath)
    {
        $this->details = $details;
        $this->attachmentPath = $attachmentPath;
    }

    public function build()
    {
        $email = $this->subject($this->details['subject'])
            ->view('emails.ads')
            ->with('details', $this->details);

        if ($this->attachmentPath) {
            $email->attach($this->attachmentPath);
        }

        return $email;
    }
}
