<?php

namespace App\Filament\Instructor\Resources\LiveClassResource\Pages;

use App\Filament\Instructor\Resources\LiveClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLiveClasses extends ListRecords
{
    protected static string $resource = LiveClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
