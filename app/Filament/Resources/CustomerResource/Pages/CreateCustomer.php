<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'customer';
        if (empty($data['password'])) {
            $digits = preg_replace('/[^0-9]/', '', $data['phone'] ?? '');
            $data['password'] = Hash::make(strlen($digits) >= 6 ? substr($digits, -6) : 'travel123456');
        }
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
