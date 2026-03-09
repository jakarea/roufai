<?php

namespace App\Filament\Instructor\Resources\BlogPostResource\Pages;

use App\Filament\Instructor\Resources\BlogPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBlogPost extends ViewRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
