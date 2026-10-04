<?php

namespace App\Filament\Resources\TourResource\RelationManagers;

use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $title = 'Đánh giá du khách thực tế của Tour này';

    protected static ?string $modelLabel = 'Đánh giá';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('author_name')
                            ->label('Tên du khách')
                            ->required()
                            ->placeholder('VD: John Smith, Alexander Way...')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('author_location')
                            ->label('Địa chỉ / Quốc tịch')
                            ->placeholder('VD: United States, Australia...')
                            ->maxLength(255),

                        Forms\Components\Select::make('rating')
                            ->label('Số sao')
                            ->options([
                                5 => '★★★★★ (5 sao)',
                                4 => '★★★★☆ (4 sao)',
                                3 => '★★★☆☆ (3 sao)',
                                2 => '★★☆☆☆ (2 sao)',
                                1 => '★☆☆☆☆ (1 sao)',
                            ])
                            ->default(5)
                            ->required(),

                        Forms\Components\TextInput::make('review_date')
                            ->label('Thời gian')
                            ->default(fn () => 'Tháng ' . date('n') . ', ' . date('Y'))
                            ->maxLength(100),

                        Forms\Components\TextInput::make('source')
                            ->label('Nguồn đánh giá')
                            ->default('Tripadvisor')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('title')
                            ->label('Tiêu đề')
                            ->placeholder('VD: Amazing experience with Easy Rider!')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('comment')
                            ->label('Nội dung đánh giá')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_approved')
                            ->label('Duyệt hiển thị trên web')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Đánh giá nổi bật trang chủ')
                            ->default(false),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('author_name')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Du khách')
                    ->weight('bold')
                    ->description(fn (Review $record): string => $record->author_location ?? ''),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Đánh giá')
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state) . str_repeat('☆', 5 - $state))
                    ->color('warning'),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Nội dung')
                    ->limit(60)
                    ->tooltip(fn (Review $record): string => $record->comment ?? ''),

                Tables\Columns\TextColumn::make('source')
                    ->label('Nguồn')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('review_date')
                    ->label('Thời gian'),

                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Hiển thị')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Đã duyệt hiển thị'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Thêm đánh giá cho Tour này'),
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
}
