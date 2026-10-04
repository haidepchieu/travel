<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourBookingResource\Pages;
use App\Models\TourBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TourBookingResource extends Resource
{
    protected static ?string $model = TourBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Đơn đặt & Khách hàng';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Đơn đặt tour';

    protected static ?string $pluralModelLabel = 'Quản lý Đặt tour';

    protected static ?string $navigationLabel = 'Đơn đặt tour';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin Đặt tour')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('booking_code')
                                    ->label('Mã đơn đặt')
                                    ->placeholder('Tự động tạo (VD: CNT-A1B2C3)')
                                    ->disabled()
                                    ->dehydrated(false),

                                Forms\Components\Select::make('booking_type')
                                    ->label('Loại đặt tour')
                                    ->options([
                                        'standard' => 'Đặt tour có sẵn',
                                        'customized_tour' => 'Tour tự thiết kế (Customized Tour)',
                                        'enquiry' => 'Yêu cầu tư vấn nhanh',
                                    ])
                                    ->default('standard')
                                    ->required(),

                                Forms\Components\Select::make('tour_id')
                                    ->label('Tour đã đặt (Để trống nếu là tour tùy chỉnh riêng)')
                                    ->relationship('tour', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('package_option')
                                    ->label('Gói dịch vụ đã chọn')
                                    ->placeholder('VD: Easy Rider (Có tài xế) hoặc Self-Drive')
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('departure_time')
                                    ->label('Khung giờ đón')
                                    ->placeholder('VD: 07:30 AM hoặc 08:30 PM')
                                    ->default('07:30 AM'),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('departure_date')
                                    ->label('Ngày khởi hành')
                                    ->required(),

                                Forms\Components\TextInput::make('adults')
                                    ->label('Người lớn')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),

                                Forms\Components\TextInput::make('children')
                                    ->label('Trẻ em')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ]),
                    ]),

                Forms\Components\Section::make('Thông tin Khách hàng')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('customer_name')
                                    ->label('Họ và tên khách')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('customer_email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('customer_phone')
                                    ->label('Số điện thoại / Zalo')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\TextInput::make('hotel_pickup')
                            ->label('Điểm đón / Khách sạn')
                            ->placeholder('VD: Khách sạn Phố Cổ Hà Nội hoặc TP Hà Giang')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('special_requests')
                            ->label('Yêu cầu đặc biệt / Chế độ ăn uống')
                            ->placeholder('VD: Ăn chay, mũ bảo hiểm cỡ L, phòng riêng...')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Thanh toán & Trạng thái Đơn')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('total_price')
                                    ->label('Tổng tiền ($)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0.00)
                                    ->required(),

                                Forms\Components\Select::make('payment_type')
                                    ->label('Hình thức thanh toán')
                                    ->options([
                                        'deposit' => 'Đặt cọc 30%',
                                        'full' => 'Thanh toán 100%',
                                        'later' => 'Thanh toán khi đón tour',
                                    ])
                                    ->default('deposit'),

                                Forms\Components\TextInput::make('deposit_amount')
                                    ->label('Số tiền đã cọc/trả ($)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0.00),

                                Forms\Components\TextInput::make('remaining_amount')
                                    ->label('Số tiền còn lại ($)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0.00),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('payment_method')
                                    ->label('Phương thức thanh toán')
                                    ->options([
                                        'vietqr' => 'VietQR Ngân hàng (24/7)',
                                        'credit_card' => 'Thẻ quốc tế (Visa/Master)',
                                        'pay_on_arrival' => 'Thanh toán khi đón tour',
                                    ])
                                    ->default('vietqr'),

                                Forms\Components\Select::make('payment_status')
                                    ->label('Trạng thái thanh toán')
                                    ->options([
                                        'pending' => 'Chờ thanh toán',
                                        'partial' => 'Đã cọc một phần',
                                        'paid' => 'Đã thanh toán đủ',
                                        'refunded' => 'Đã hoàn tiền',
                                    ])
                                    ->default('pending')
                                    ->required(),

                                Forms\Components\Select::make('booking_status')
                                    ->label('Trạng thái đặt tour')
                                    ->options([
                                        'pending' => 'Chờ xác nhận',
                                        'enquiry' => 'Yêu cầu tư vấn (Enquiry)',
                                        'confirmed' => 'Đã xác nhận',
                                        'cancelled' => 'Đã hủy',
                                        'completed' => 'Đã hoàn thành',
                                    ])
                                    ->default('pending')
                                    ->required(),
                            ]),

                        Forms\Components\TextInput::make('payment_transaction_id')
                            ->label('Mã chuẩn chi / Giao dịch (Transaction ID)')
                            ->placeholder('VD: CC-FULL-XXXXXX hoặc CNT-XXXXXX')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_code')
                    ->label('Mã đơn')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->description(fn (TourBooking $record): string => $record->customer_email . ' | ' . $record->customer_phone)
                    ->url(fn (TourBooking $record): ?string => $record->user_id ? route('filament.admin.resources.customers.edit', $record->user_id) : null)
                    ->tooltip('Xem hồ sơ & lịch sử của khách hàng'),

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
                    ->default('Tour thiết kế riêng (Customized)')
                    ->searchable()
                    ->limit(25)
                    ->description(fn (TourBooking $record): ?string => $record->package_option),

                Tables\Columns\TextColumn::make('departure_date')
                    ->label('Khởi hành')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('guests')
                    ->label('Số khách')
                    ->state(fn (TourBooking $record): string => $record->adults . ' Lớn' . ($record->children ? (' + ' . $record->children . ' Trẻ') : '')),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Tổng tiền')
                    ->money('USD')
                    ->sortable()
                    ->description(fn (TourBooking $record): ?string => $record->deposit_amount > 0 ? ('Cọc: $' . number_format($record->deposit_amount, 0) . ' | Còn: $' . number_format($record->remaining_amount, 0)) : null),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Cổng thanh toán')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'vietqr' => 'VietQR',
                        'credit_card' => 'Thẻ quốc tế',
                        'pay_on_arrival' => 'Khi đón tour',
                        default => $state ?? 'Chưa chọn',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'vietqr' => 'warning',
                        'credit_card' => 'primary',
                        'pay_on_arrival' => 'gray',
                        default => 'gray',
                    }),

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
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('booking_status')
                    ->label('Trạng thái đặt tour')
                    ->options([
                        'pending' => 'Chờ xác nhận',
                        'enquiry' => 'Yêu cầu tư vấn (Enquiry)',
                        'confirmed' => 'Đã xác nhận',
                        'cancelled' => 'Đã hủy',
                        'completed' => 'Đã hoàn thành',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Trạng thái thanh toán')
                    ->options([
                        'pending' => 'Chờ thanh toán',
                        'partial' => 'Đã cọc một phần',
                        'paid' => 'Đã thanh toán đủ',
                        'refunded' => 'Đã hoàn tiền',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Duyệt đơn & Gửi Mail')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (TourBooking $record) => $record->booking_status !== 'confirmed')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận duyệt đơn đặt tour')
                    ->modalDescription(fn (TourBooking $record) => "Bạn có chắc muốn duyệt đơn {$record->booking_code}? Hệ thống sẽ đổi trạng thái sang 'Đã xác nhận' và gửi email thông báo đặt tour thành công tới {$record->customer_email}.")
                    ->modalSubmitActionLabel('Xác nhận & Gửi Mail')
                    ->action(function (TourBooking $record) {
                        $record->booking_status = 'confirmed';
                        if ($record->payment_method === 'vietqr' && $record->payment_status === 'pending') {
                            $record->payment_status = 'paid';
                        }
                        $record->save();

                        try {
                            if (!empty($record->customer_email)) {
                                \Illuminate\Support\Facades\Mail::to($record->customer_email)->send(new \App\Mail\BookingConfirmedMail($record));
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Đã xác nhận đơn hàng!')
                                ->body('Đã chuyển trạng thái sang "Đã xác nhận" và gửi email thành công tới ' . $record->customer_email)
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            \Filament\Notifications\Notification::make()
                                ->title('Đã xác nhận đơn hàng')
                                ->body('Trạng thái đã cập nhật nhưng lỗi khi gửi mail: ' . $e->getMessage())
                                ->warning()
                                ->send();
                        }
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTourBookings::route('/'),
            'create' => Pages\CreateTourBooking::route('/create'),
            'edit' => Pages\EditTourBooking::route('/{record}/edit'),
        ];
    }
}
