<?php

namespace App\Filament\Instructor\Resources\EnrollmentRequestResource\Pages;

use App\Filament\Instructor\Resources\EnrollmentRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEnrollmentRequest extends ViewRecord
{
    protected static string $resource = EnrollmentRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(), // No editing allowed
        ];
    }
}
