<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\EnrollmentRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnrollmentRequestMail extends Mailable
{
    use SerializesModels;

    public $enrollmentRequest;
    public $course;

    /**
     * Create a new message instance.
     */
    public function __construct(EnrollmentRequest $enrollmentRequest, Course $course)
    {
        $this->enrollmentRequest = $enrollmentRequest;
        $this->course = $course;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Course Enrollment Request - ' . $this->course->title,
            to: [['email' => 'giopioservice@gmail.com', 'name' => 'Admin']],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.enrollment-request-admin',
            with: [
                'studentName' => $this->enrollmentRequest->name,
                'studentEmail' => $this->enrollmentRequest->email,
                'studentPhone' => $this->enrollmentRequest->phone,
                'courseTitle' => $this->course->title,
                'coursePrice' => $this->course->price,
                'paymentMethod' => $this->enrollmentRequest->payment_method,
                'transactionId' => $this->enrollmentRequest->transaction_id,
                'paidAmount' => $this->enrollmentRequest->amount_paid,
            ]
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
