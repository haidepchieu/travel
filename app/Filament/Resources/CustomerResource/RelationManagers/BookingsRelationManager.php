<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models\TourBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'bookings';

    protected static ?string $title = 'Lịch sử Đặt Tour của Khách';

    protected static ?string $modelLabel = 'Đơn đặt tour';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('booking_code')
                    ->label('Mã đơn')
                    ->disabled(),
                Forms\Components\TextInput::make('customer_name')
                    ->label('Tên khách')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('booking_code')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('booking_code')
                    ->label('Mã đơn')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('booking_type')
                    ->label('Phân loại')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'customized_tour' => 'Tùy chỉnh Tour',
                        'enquiry' => 'Tư vấn nhanh',
                        default => 'Tour có sẵn',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'customized_tour' => 'primary',
                        'enquiry' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('tour.title')
                    ->label('Tour')
                    ->default('Tour thiết kế riêng')
                    ->limit(30),

                Tables\Columns\TextColumn::make('departure_date')
                    ->label('Khởi hành')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('guests')
                    ->label('Số khách')
                    ->state(fn (TourBooking $record): string => $record->adults . ' Lớn' . ($record->children ? (' + ' . $record->children . ' Trẻ') : '')),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Tổng tiền')
                    ->money('USD'),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Thanh toán')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Đã thanh toán',
                        'partial' => 'Đã cọc',
                        'pending' => 'Chờ trả',
                        'refunded' => 'Hoàn tiền',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'partial' => 'info',
                        'pending' => 'warning',
                        'refunded' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('booking_status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'confirmed' => 'Đã xác nhận',
                        'completed' => 'Hoàn thành',
                        'pending' => 'Chờ duyệt',
                        'enquiry' => 'Yêu cầu tư vấn',
                        'cancelled' => 'Đã hủy',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'completed' => 'primary',
                        'pending' => 'warning',
                        'enquiry' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày đặt')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_booking')
                    ->label('Xem chi tiết đơn')
                    ->icon('heroicon-o-eye')
                    ->url(fn (TourBooking $record): string => route('filament.admin.resources.tour-bookings.edit', $record)),
            ]);
    }
}
