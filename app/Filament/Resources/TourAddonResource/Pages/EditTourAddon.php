<?php

namespace App\Filament\Resources\TourAddonResource\Pages;

use App\Filament\Resources\TourAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourAddon extends EditRecord
{
    protected static string $resource = TourAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
