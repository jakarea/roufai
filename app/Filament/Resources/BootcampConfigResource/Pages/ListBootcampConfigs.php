<?php

namespace App\Filament\Resources\BootcampConfigResource\Pages;

use App\Filament\Resources\BootcampConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBootcampConfigs extends ListRecords
{
    protected static string $resource = BootcampConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
