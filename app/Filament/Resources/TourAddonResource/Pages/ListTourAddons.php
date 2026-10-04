<?php

namespace App\Filament\Resources\TourAddonResource\Pages;

use App\Filament\Resources\TourAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTourAddons extends ListRecords
{
    protected static string $resource = TourAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Thêm dịch vụ cộng thêm'),
        ];
    }
}
