<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Quản lý Tour';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Danh mục / Hoạt động';

    protected static ?string $pluralModelLabel = 'Danh mục & Hoạt động';

    protected static ?string $navigationLabel = 'Danh mục & Hoạt động';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin Danh mục / Hoạt động')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên danh mục / hoạt động')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn URL (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Activity::class, 'slug', ignoreRecord: true),

                                Forms\Components\TextInput::make('icon')
                                    ->label('Tên Icon / Class')
                                    ->placeholder('VD: heroicon-o-fire, fa-motorcycle')
                                    ->maxLength(255),

                                Forms\Components\FileUpload::make('image')
                                    ->label('Hình ảnh đại diện hoạt động (Hiển thị thẻ trang chủ)')
                                    ->image()
                                    ->directory('activities')
                                    ->imageCropAspectRatio('4:3')
                                    ->columnSpanFull(),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt')
                                    ->default(true),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Mô tả')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Hình ảnh')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->image_url),

                Tables\Columns\TextColumn::make('name')
                    ->label('Danh mục / Hoạt động')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Đường dẫn (Slug)')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tours_count')
                    ->label('Số Tour')
                    ->counts('tours')
                    ->badge(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Kích hoạt')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái hoạt động'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
