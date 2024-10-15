<?php

namespace App\Mail\Backend;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class AdminForgotMail extends Mailable
{
    use Queueable, SerializesModels;
    public $template;
    public $admin;
    public $reset_link;
    public $from_email;
    public $from_name;
    public $subject;
    /**
     * Create a new message instance.
     */
    public function __construct($admin, $reset_link)
    {
        $this->admin = $admin;
        $this->reset_link = $reset_link;
        // $this->template = \App\Models\EmailTemplate::where('slug', 'admin-forgot-password')->active()->first();

        // $this->from_email = $this->template?->from_email ? $this->template->from_email : env('MAIL_FROM_ADDRESS', 'noreply@radioquery.com');
        // $this->from_name = $this->template?->from_name ? $this->template->from_name : env('MAIL_FROM_NAME', 'Radioquery');
        // $this->subject = $this->template?->subject ? $this->template->subject : 'Admin Forgot Password';

     

        $this->from_email = env('MAIL_FROM_ADDRESS', 'noreply@radioquery.com');
        $this->from_name =  env('MAIL_FROM_NAME', 'Radioquery');
        $this->subject =  'Admin Forgot Password';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->from_email, $this->from_name),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'backend.mail.admin_forgot_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
