<?php

namespace App\Filament\Resources\MusicResource\Pages;

use App\Filament\Resources\MusicResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMusic extends EditRecord
{
    protected static string $resource = MusicResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
