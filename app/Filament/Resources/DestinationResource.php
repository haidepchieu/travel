<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinationResource\Pages;
use App\Models\Destination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Quản lý Tour';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Điểm đến';

    protected static ?string $pluralModelLabel = 'Điểm đến';

    protected static ?string $navigationLabel = 'Điểm đến';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin Điểm đến')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên điểm đến')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn URL (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Destination::class, 'slug', ignoreRecord: true),
                            ]),

                        Forms\Components\FileUpload::make('image')
                            ->label('Ảnh đại diện')
                            ->image()
                            ->disk('public')
                            ->directory('destinations')
                            ->imageEditor()
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Mô tả & Hướng dẫn du lịch')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Điểm đến nổi bật')
                                    ->default(false),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt / Hiển thị')
                                    ->default(true),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Thứ tự sắp xếp')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ảnh')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Điểm đến')
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

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Nổi bật')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Điểm đến nổi bật'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Đang hiển thị'),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
