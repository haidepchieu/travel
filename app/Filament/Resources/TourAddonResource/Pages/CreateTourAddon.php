<?php

namespace App\Filament\Resources\TourAddonResource\Pages;

use App\Filament\Resources\TourAddonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTourAddon extends CreateRecord
{
    protected static string $resource = TourAddonResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
