<?php

namespace App\Filament\Instructor\Resources\EnrollmentResource\Pages;

use App\Filament\Instructor\Resources\EnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getRedirectUrl(): string
    {
        return EnrollmentResource::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): string
    {
        return 'Student Enrolled';
    }

    protected function getCreatedNotificationMessage(): string
    {
        return 'The student has been successfully enrolled in the course.';
    }
}
