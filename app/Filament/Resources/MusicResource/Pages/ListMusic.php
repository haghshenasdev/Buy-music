<?php

namespace App\Filament\Resources\MusicResource\Pages;

use App\Filament\Resources\MusicResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMusic extends ListRecords
{
    protected static string $resource = MusicResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
