<?php

namespace App\Mail;

use App\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->email->from, $this->email->alias)
            ->view('email')
            ->with(['email_content' => $this->email->content]);

        foreach ($this->data['file_urls'] as $index => $fileUrl) {
            $mail->attach(Storage::disk('email_attachment')->path($fileUrl),
                [
                    'as' => $this->data['file_names'][$index],
                    'mime' => $this->data['mimes'][$index]
                ]
            );
        }

        return $mail;
    }
}
