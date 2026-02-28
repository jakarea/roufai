<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SMSService
{
    protected string $apiUrl;
    protected string $username;
    protected string $password;
    protected string $senderId;

    public function __construct()
    {
        $this->apiUrl = config('services.sms.api_url', env('SMS_API_URL'));
        $this->username = config('services.sms.username', env('SMS_USERNAME'));
        $this->password = config('services.sms.password', env('SMS_PASSWORD'));
        $this->senderId = config('services.sms.sender_id', env('SMS_SENDER_ID', 'RoufAI'));
    }

    /**
     * Send SMS to a single phone number
     *
     * @param string $phoneNumber
     * @param string $message
     * @return array
     */
    public function send(string $phoneNumber, string $message): array
    {
        try {
            // Clean phone number - ensure it starts with 880 for Bangladesh
            $phone = $this->formatPhoneNumber($phoneNumber);

            // Prepare request data
            $data = [
                'username' => $this->username,
                'password' => $this->password,
                'number' => $phone,
                'message' => $message,
                'sender_id' => $this->senderId,
            ];

            // Send SMS via HTTP GET request (common for BD SMS gateways)
            $response = Http::get($this->apiUrl, $data);

            // Log the attempt
            Log::info('SMS Sent', [
                'phone' => $phone,
                'message' => substr($message, 0, 100) . '...',
                'response' => $response->body(),
            ]);

            return [
                'success' => true,
                'message' => 'SMS sent successfully',
                'response' => $response->body(),
            ];

        } catch (\Exception $e) {
            // Log error
            Log::error('SMS Sending Failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send bulk SMS to multiple numbers
     *
     * @param array $phoneNumbers
     * @param string $message
     * @return array
     */
    public function sendBulk(array $phoneNumbers, string $message): array
    {
        $results = [];

        foreach ($phoneNumbers as $phoneNumber) {
            $results[] = $this->send($phoneNumber, $message);
        }

        return $results;
    }

    /**
     * Format phone number to Bangladesh standard (880...)
     *
     * @param string $phone
     * @return string
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 0, replace with 880
        if (str_starts_with($phone, '0')) {
            $phone = '880' . substr($phone, 1);
        }

        // If doesn't start with 880, add it
        if (!str_starts_with($phone, '880')) {
            $phone = '880' . $phone;
        }

        return $phone;
    }

    /**
     * Send enrollment confirmation SMS
     *
     * @param string $phoneNumber
     * @param string $studentName
     * @param string $courseTitle
     * @return array
     */
    public function sendEnrollmentConfirmation(string $phoneNumber, string $studentName, string $courseTitle): array
    {
        $message = "Dear {$studentName},\n\n";
        $message .= "You have been successfully enrolled in '{$courseTitle}'.\n\n";
        $message .= "You can now access your course from the student dashboard.\n\n";
        $message .= "Thank you for choosing Rouf AI Academy!";

        return $this->send($phoneNumber, $message);
    }

    /**
     * Send enrollment request received SMS (for paid courses)
     *
     * @param string $phoneNumber
     * @param string $studentName
     * @param string $courseTitle
     * @param int $amountPaid
     * @return array
     */
    public function sendEnrollmentRequestReceived(string $phoneNumber, string $studentName, string $courseTitle, int $amountPaid): array
    {
        $message = "Dear {$studentName},\n\n";
        $message .= "We have received your enrollment request for '{$courseTitle}'.\n\n";
        $message .= "Amount Paid: ৳{$amountPaid}\n";
        $message .= "Transaction ID: {transaction_id}\n\n";
        $message .= "Your request is being reviewed. You will receive another SMS once approved.\n\n";
        $message .= "Thank you for choosing Rouf AI Academy!";

        return $this->send($phoneNumber, $message);
    }

    /**
     * Send enrollment approval SMS
     *
     * @param string $phoneNumber
     * @param string $studentName
     * @param string $courseTitle
     * @return array
     */
    public function sendEnrollmentApproved(string $phoneNumber, string $studentName, string $courseTitle): array
    {
        $message = "Congratulations {$studentName}! 🎉\n\n";
        $message .= "Your enrollment for '{$courseTitle}' has been APPROVED.\n\n";
        $message .= "You can now access your course from the student dashboard.\n\n";
        $message .= "Happy learning!\nRouf AI Academy";

        return $this->send($phoneNumber, $message);
    }

    /**
     * Send enrollment rejection SMS
     *
     * @param string $phoneNumber
     * @param string $studentName
     * @param string $courseTitle
     * @param string|null $reason
     * @return array
     */
    public function sendEnrollmentRejected(string $phoneNumber, string $studentName, string $courseTitle, ?string $reason = null): array
    {
        $message = "Dear {$studentName},\n\n";
        $message .= "Your enrollment request for '{$courseTitle}' could not be approved.\n\n";

        if ($reason) {
            $message .= "Reason: {$reason}\n\n";
        }

        $message .= "Please contact support for more information.\n\n";
        $message .= "Rouf AI Academy";

        return $this->send($phoneNumber, $message);
    }

    /**
     * Send welcome SMS to new student
     *
     * @param string $phoneNumber
     * @param string $studentName
     * @return array
     */
    public function sendWelcomeSMS(string $phoneNumber, string $studentName): array
    {
        $message = "Welcome to Rouf AI Academy, {$studentName}! 🎉\n\n";
        $message .= "Your account has been created successfully.\n\n";
        $message .= "Start learning now: Browse our courses and enroll in your favorite ones!\n\n";
        $message .= "Dashboard: " . route('student.dashboard') . "\n\n";
        $message .= "Happy learning! 🚀\n";
        $message .= "Rouf AI Academy";

        return $this->send($phoneNumber, $message);
    }
}
