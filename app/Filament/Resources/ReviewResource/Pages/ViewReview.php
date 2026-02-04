<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReview extends ViewRecord
{
    protected static string $resource = ReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('delete')
                ->label('Delete Review')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->delete();
                    \Filament\Notifications\Notification::make()
                        ->title('Review Deleted')
                        ->body('The review has been removed successfully.')
                        ->success()
                        ->send();
                    redirect()->route('filament.admin.resources.reviews.index');
                }),
        ];
    }
}
