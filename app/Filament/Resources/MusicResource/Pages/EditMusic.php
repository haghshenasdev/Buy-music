<?php

namespace App\Filament\Resources\MusicResource\Pages;

use App\Filament\Resources\MusicResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;

class EditMusic extends EditRecord
{
    protected static string $resource = MusicResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        return view('filament.settings.custom-header');
    }

    public function getFooter(): ?View
    {
        return view('filament.settings.custom-footer');
    }
}
