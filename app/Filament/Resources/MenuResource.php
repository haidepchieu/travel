<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static ?string $navigationGroup = 'Cấu hình hệ thống';

    protected static ?int $navigationSort = 95;

    protected static ?string $modelLabel = 'Menu Website';

    protected static ?string $pluralModelLabel = 'Quản lý Menu Website';

    protected static ?string $navigationLabel = 'Quản lý Menu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin Menu')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên Menu')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('VD: Menu Chính (Header Navigation)'),

                                Forms\Components\TextInput::make('code')
                                    ->label('Mã vị trí (Code)')
                                    ->helperText('Vị trí hiển thị: header = đầu trang, footer = chân trang')
                                    ->required()
                                    ->unique(Menu::class, 'code', ignoreRecord: true)
                                    ->maxLength(50),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt')
                                    ->default(true),
                            ]),
                    ]),

                Forms\Components\Section::make('Các mục Menu (Menu Items)')
                    ->description('Thêm, sửa, xóa và kéo thả thay đổi thứ tự các liên kết menu hiển thị trên website.')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('Danh sách các mục Menu')
                            ->itemLabel(fn (array $state): ?string => (!empty($state['title']) ? ($state['title'] . ' (' . ($state['type'] ?? 'link') . ')') : 'Mục Menu'))
                            ->reorderable()
                            ->collapsible()
                            ->addActionLabel('+ Thêm mục menu mới')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Tiêu đề hiển thị')
                                            ->required()
                                            ->placeholder('VD: Trang chủ, Điểm đến, Tùy chỉnh Tour'),

                                        Forms\Components\Select::make('type')
                                            ->label('Loại mục Menu')
                                            ->options([
                                                'link' => 'Đường dẫn đơn (Link thường)',
                                                'destinations_dropdown' => 'Dropdown Điểm đến (Tự động lấy từ CSDL)',
                                                'activities_dropdown' => 'Dropdown Hoạt động (Tự động lấy từ CSDL)',
                                                'custom_dropdown' => 'Dropdown tùy chỉnh (Tự tạo các mục con)',
                                            ])
                                            ->default('link')
                                            ->reactive()
                                            ->required(),

                                        Forms\Components\TextInput::make('badge')
                                            ->label('Huy hiệu / Badge (Tùy chọn)')
                                            ->placeholder('VD: Hot, New'),
                                    ]),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('url')
                                            ->label('Đường dẫn URL')
                                            ->placeholder('/customized-tour hoặc https://...')
                                            ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['link', 'custom_dropdown', null])),

                                        Forms\Components\Select::make('target')
                                            ->label('Cách mở link')
                                            ->options([
                                                '_self' => 'Mở trong cùng tab',
                                                '_blank' => 'Mở tab mới (_blank)',
                                            ])
                                            ->default('_self'),
                                    ]),

                                Forms\Components\Repeater::make('children')
                                    ->label('Các mục con (Sub-items)')
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'custom_dropdown')
                                    ->reorderable()
                                    ->collapsible()
                                    ->addActionLabel('+ Thêm mục con')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Tên mục con')
                                                    ->required(),
                                                Forms\Components\TextInput::make('subtitle')
                                                    ->label('Mô tả phụ'),
                                                Forms\Components\TextInput::make('url')
                                                    ->label('Đường dẫn URL')
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên Menu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('code')
                    ->label('Mã vị trí (Code)')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('items')
                    ->label('Số lượng mục')
                    ->state(fn (Menu $record): int => is_array($record->items) ? count($record->items) : 0)
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Kích hoạt')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Cập nhật lần cuối')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
