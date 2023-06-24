<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContacUsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public array $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($data)
    {
        $this->mailData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ContacUsMail
    {
        return $this->view('mail.contact.contact-us')->subject($this->mailData['subject'])->with(['data'=>$this->mailData]);
    }
}
