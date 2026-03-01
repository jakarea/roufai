<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\CertificateSetting;
use App\Models\Course;
use Dompdf\Dompdf;

class CertificateController extends Controller
{
    /**
     * Download the certificate as PDF.
     */
    public function download($courseId)
    {
        $student = Auth::user();

        // Check if student is enrolled and has completed the course
        $enrollment = \App\Models\Enrollment::where('user_id', $student->id)
            ->where('course_id', $courseId)
            ->firstOrFail();

        $course = Course::with(['instructor', 'category', 'modules.lessons'])->findOrFail($courseId);

        // Get all lesson IDs from this course
        $courseLessonIds = $course->modules->flatMap(function ($module) {
            return $module->lessons->pluck('id');
        })->toArray();

        // Get all completed lessons for this student in this course
        $completedLessons = \App\Models\LessonCompletion::where('user_id', $student->id)
            ->whereIn('lesson_id', $courseLessonIds)
            ->pluck('lesson_id')
            ->toArray();

        // Calculate total lessons
        $totalLessons = count($courseLessonIds);

        // Check if course is completed
        if (count($completedLessons) !== $totalLessons || $totalLessons === 0) {
            return back()->with('error', 'You must complete all lessons before downloading the certificate.');
        }

        // Get or create certificate
        $certificate = Certificate::firstOrCreate(
            [
                'user_id' => $student->id,
                'course_id' => $courseId,
            ],
            [
                'certificate_number' => Certificate::generateCertificateNumber(),
                'issued_at' => now(),
            ]
        );

        // Get certificate settings
        $settings = CertificateSetting::getCurrent();

        // Generate PDF
        $pdf = new Dompdf();
        $html = view('certificate', [
            'certificate' => $certificate,
            'course' => $course,
            'student' => $student,
            'settings' => $settings,
        ])->render();

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        // Generate filename
        $filename = 'Certificate_' . str_replace(' ', '_', $course->title) . '_' . $student->name . '.pdf';

        // Download the PDF
        return $pdf->stream($filename);
    }

    /**
     * Generate certificate for a user (auto-called when course is completed).
     */
    public static function generateCertificate($userId, $courseId)
    {
        return Certificate::firstOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId,
            ],
            [
                'certificate_number' => Certificate::generateCertificateNumber(),
                'issued_at' => now(),
            ]
        );
    }
}
