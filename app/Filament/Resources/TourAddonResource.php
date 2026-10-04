<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourAddonResource\Pages;
use App\Models\TourAddon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TourAddonResource extends Resource
{
    protected static ?string $model = TourAddon::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationGroup = 'Quản lý Tour';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Dịch vụ cộng thêm';

    protected static ?string $pluralModelLabel = 'Dịch vụ tùy chọn (Extra Services)';

    protected static ?string $navigationLabel = 'Dịch vụ tùy chọn (Extra Services)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin dịch vụ tùy chọn cộng thêm')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên dịch vụ')
                                    ->required()
                                    ->placeholder('VD: Nâng cấp xe Limousine VIP đưa đón Phố Cổ')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('code')
                                    ->label('Mã định danh (Code)')
                                    ->placeholder('VD: limousine, single_room, motorbike_insurance...')
                                    ->helperText('Dùng để nhận diện trong mã nguồn hoặc có thể để trống')
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('price')
                                    ->label('Đơn giá ($)')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0)
                                    ->required(),

                                Forms\Components\TextInput::make('price_unit')
                                    ->label('Đơn vị hiển thị')
                                    ->default('/người')
                                    ->placeholder('VD: /người, /đêm, /xe, /phòng')
                                    ->maxLength(50),

                                Forms\Components\Select::make('calculation_type')
                                    ->label('Cách tính thành tiền')
                                    ->options([
                                        'per_person' => 'Nhân theo số lượng khách (Tổng Người lớn + Trẻ em)',
                                        'per_booking' => 'Cố định theo đơn (Tính 1 lần khi chọn)',
                                    ])
                                    ->default('per_person')
                                    ->required(),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Thứ tự sắp xếp')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Số càng nhỏ hiển thị càng trước'),

                                Forms\Components\Textarea::make('description')
                                    ->label('Mô tả ngắn gọn')
                                    ->rows(2)
                                    ->placeholder('VD: Đưa đón tận cửa khách sạn, ghế massage bọc da cao cấp')
                                    ->columnSpanFull(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt hiển thị ở Modal đặt tour')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('sort_order', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên dịch vụ')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->description(fn (TourAddon $record): string => $record->description ?? ''),

                Tables\Columns\TextColumn::make('price')
                    ->label('Đơn giá')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_unit')
                    ->label('Đơn vị')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('calculation_type')
                    ->label('Cách tính tiền')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'per_person' => 'Nhân số khách',
                        'per_booking' => 'Cố định đơn',
                        default => $state ?? '',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'per_person' => 'primary',
                        'per_booking' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Đang bật')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Đang kích hoạt'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTourAddons::route('/'),
            'create' => Pages\CreateTourAddon::route('/create'),
            'edit' => Pages\EditTourAddon::route('/{record}/edit'),
        ];
    }
}
