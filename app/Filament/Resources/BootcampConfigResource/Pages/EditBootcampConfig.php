<?php

namespace App\Filament\Resources\BootcampConfigResource\Pages;

use App\Filament\Resources\BootcampConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBootcampConfig extends EditRecord
{
    protected static string $resource = BootcampConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
