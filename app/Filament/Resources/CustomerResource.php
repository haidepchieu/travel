<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Đơn đặt & Khách hàng';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Khách hàng';

    protected static ?string $pluralModelLabel = 'Danh sách khách hàng';

    protected static ?string $navigationLabel = 'Khách hàng';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', '!=', 'admin')
            ->withCount('bookings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin Hồ sơ Khách hàng')
                    ->description('Thông tin định danh và liên hệ của khách hàng đặt tour.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Họ và tên khách hàng')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('email')
                                    ->label('Địa chỉ Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(User::class, 'email', ignoreRecord: true),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Số điện thoại')
                                    ->tel()
                                    ->maxLength(50)
                                    ->placeholder('+84 867 216 850'),

                                Forms\Components\TextInput::make('nationality')
                                    ->label('Quốc tịch / Nơi cư trú')
                                    ->maxLength(100)
                                    ->placeholder('VD: Vietnam, Australia, United States, France...'),

                                Forms\Components\TextInput::make('address')
                                    ->label('Địa chỉ / Khách sạn lưu trú')
                                    ->columnSpanFull()
                                    ->placeholder('VD: Khách sạn Phố Cổ Hà Nội, 15 Hàng Buồm...'),

                                Forms\Components\Textarea::make('notes')
                                    ->label('Ghi chú nội bộ về khách (Chỉ Admin & Nhân viên thấy)')
                                    ->placeholder('Lưu ý sở thích ăn uống, thói quen đi tour, khách VIP, dị ứng, v.v.')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Forms\Components\Section::make('Tài khoản & Bảo mật')
                    ->description('Khách hàng có thể dùng email và mật khẩu này để đăng nhập tra cứu tour trên website.')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Mật khẩu mới (Để trống nếu không muốn đổi)')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state)),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (User $record): string => $record->email),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Số điện thoại')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->default('Chưa cập nhật')
                    ->copyable(),

                Tables\Columns\TextColumn::make('nationality')
                    ->label('Quốc tịch')
                    ->searchable()
                    ->default('Chưa rõ')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('bookings_count')
                    ->label('Số tour đã đặt')
                    ->counts('bookings')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_spent')
                    ->label('Tổng chi tiêu')
                    ->state(fn (User $record): string => '$' . number_format($record->total_spent, 2))
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo / Đặt đầu tiên')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_bookings')
                    ->label('Khách đã từng đặt tour')
                    ->query(fn (Builder $query): Builder => $query->has('bookings')),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')
                    ->label('Chat WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->visible(fn (User $record): bool => !empty($record->phone))
                    ->url(fn (User $record): string => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->phone), shouldOpenInNewTab: true),

                Tables\Actions\EditAction::make()
                    ->label('Xem & Sửa'),

                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\BookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
