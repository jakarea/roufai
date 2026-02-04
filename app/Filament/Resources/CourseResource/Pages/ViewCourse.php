<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCourse extends ViewRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('unpublish')
                ->label('Unpublish Course')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->is_published)
                ->action(function () {
                    $this->record->update(['is_published' => false]);
                    \Filament\Notifications\Notification::make()
                        ->title('Course Unpublished')
                        ->body('The course has been unpublished successfully.')
                        ->success()
                        ->send();
                }),
            Actions\Action::make('publish')
                ->label('Publish Course')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => !$this->record->is_published)
                ->action(function () {
                    $this->record->update(['is_published' => true]);
                    \Filament\Notifications\Notification::make()
                        ->title('Course Published')
                        ->body('The course has been published successfully.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
