<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $subject;
    public $messageContent;
    public $submissionId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $phone, $subject, $messageContent, $submissionId = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->submissionId = $submissionId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            return $this->markdown('emails.contact-form')
                        ->subject("New Contact Form Submission: {$this->subject}")
                        ->with([
                            'name' => $this->name,
                            'email' => $this->email,
                            'phone' => $this->phone,
                            'subject' => $this->subject,
                            'messageContent' => $this->messageContent,
                            'submissionId' => $this->submissionId,
                        ]);
        } catch (\Exception $e) {
            Log::error('Failed to build contact form email: ' . $e->getMessage());
            throw $e;
        }
    }
}
