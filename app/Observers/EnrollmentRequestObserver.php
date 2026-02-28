<?php

namespace App\Observers;

use App\Models\EnrollmentRequest;
use App\Models\Enrollment;
use App\Services\SMSService;
use Illuminate\Support\Facades\Log;

class EnrollmentRequestObserver
{
    /**
     * Handle the EnrollmentRequest "updated" event.
     *
     * @param EnrollmentRequest $enrollmentRequest
     * @return void
     */
    public function updated(EnrollmentRequest $enrollmentRequest): void
    {
        // Only proceed if status has changed
        if ($enrollmentRequest->isDirty('status')) {
            $oldStatus = $enrollmentRequest->getOriginal('status');
            $newStatus = $enrollmentRequest->status;

            // If status changed from pending to approved
            if ($oldStatus === 'pending' && $newStatus === 'approved') {
                $this->handleApproval($enrollmentRequest);
            }

            // If status changed from pending to rejected
            if ($oldStatus === 'pending' && $newStatus === 'rejected') {
                $this->handleRejection($enrollmentRequest);
            }
        }
    }

    /**
     * Handle enrollment request approval
     *
     * @param EnrollmentRequest $enrollmentRequest
     * @return void
     */
    protected function handleApproval(EnrollmentRequest $enrollmentRequest): void
    {
        try {
            // Create enrollment if user_id exists
            if ($enrollmentRequest->user_id) {
                // Check if enrollment already exists
                $existingEnrollment = Enrollment::where('user_id', $enrollmentRequest->user_id)
                    ->where('course_id', $enrollmentRequest->course_id)
                    ->first();

                if (!$existingEnrollment) {
                    Enrollment::create([
                        'user_id' => $enrollmentRequest->user_id,
                        'course_id' => $enrollmentRequest->course_id,
                        'enrolled_at' => now(),
                    ]);

                    Log::info('Enrollment created from approved request', [
                        'enrollment_request_id' => $enrollmentRequest->id,
                        'user_id' => $enrollmentRequest->user_id,
                        'course_id' => $enrollmentRequest->course_id,
                    ]);
                }
            }

            // Send approval SMS
            if ($enrollmentRequest->phone) {
                $smsService = new SMSService();
                $smsService->sendEnrollmentApproved(
                    $enrollmentRequest->phone,
                    $enrollmentRequest->name,
                    $enrollmentRequest->course->title
                );
            }

        } catch (\Exception $e) {
            Log::error('Failed to process enrollment request approval', [
                'error' => $e->getMessage(),
                'enrollment_request_id' => $enrollmentRequest->id,
            ]);
        }
    }

    /**
     * Handle enrollment request rejection
     *
     * @param EnrollmentRequest $enrollmentRequest
     * @return void
     */
    protected function handleRejection(EnrollmentRequest $enrollmentRequest): void
    {
        try {
            // Send rejection SMS
            if ($enrollmentRequest->phone) {
                $smsService = new SMSService();
                $smsService->sendEnrollmentRejected(
                    $enrollmentRequest->phone,
                    $enrollmentRequest->name,
                    $enrollmentRequest->course->title,
                    $enrollmentRequest->rejection_reason
                );
            }

        } catch (\Exception $e) {
            Log::error('Failed to send enrollment rejection SMS', [
                'error' => $e->getMessage(),
                'enrollment_request_id' => $enrollmentRequest->id,
            ]);
        }
    }
}
