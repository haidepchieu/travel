<?php

namespace App\Filament\Resources\TourBookingResource\Pages;

use App\Filament\Resources\TourBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourBooking extends EditRecord
{
    protected static string $resource = TourBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('confirm')
                ->label('Duyệt đơn & Gửi Mail')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->booking_status !== 'confirmed')
                ->requiresConfirmation()
                ->modalHeading('Xác nhận duyệt đơn đặt tour')
                ->modalDescription(fn () => "Bạn có chắc muốn duyệt đơn {$this->record->booking_code}? Hệ thống sẽ đổi trạng thái sang 'Đã xác nhận' và gửi email thông báo đặt tour thành công tới {$this->record->customer_email}.")
                ->modalSubmitActionLabel('Xác nhận & Gửi Mail')
                ->action(function () {
                    $this->record->booking_status = 'confirmed';
                    if ($this->record->payment_method === 'vietqr' && $this->record->payment_status === 'pending') {
                        $this->record->payment_status = 'paid';
                    }
                    $this->record->save();

                    try {
                        if (!empty($this->record->customer_email)) {
                            \Illuminate\Support\Facades\Mail::to($this->record->customer_email)->send(new \App\Mail\BookingConfirmedMail($this->record));
                        }
                        \Filament\Notifications\Notification::make()
                            ->title('Đã xác nhận đơn hàng thành công!')
                            ->body('Đã gửi email thông báo đặt tour thành công tới ' . $this->record->customer_email)
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('Lỗi gửi email')
                            ->body($e->getMessage())
                            ->warning()
                            ->send();
                    }
                }),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        // If status was changed to 'confirmed' upon form submission
        if ($record->wasChanged('booking_status') && $record->booking_status === 'confirmed') {
            try {
                if (!empty($record->customer_email)) {
                    \Illuminate\Support\Facades\Mail::to($record->customer_email)->send(new \App\Mail\BookingConfirmedMail($record));
                    \Filament\Notifications\Notification::make()
                        ->title('Đã gửi email xác nhận đặt tour thành công tới ' . $record->customer_email)
                        ->success()
                        ->send();
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Lỗi gửi email sau khi lưu đơn đặt tour: ' . $e->getMessage());
            }
        }
    }
}
