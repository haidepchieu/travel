<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Quản lý Tour';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Đánh giá';

    protected static ?string $pluralModelLabel = 'Đánh giá du khách';

    protected static ?string $navigationLabel = 'Đánh giá du khách';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Chi tiết Đánh giá từ khách hàng')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('tour_id')
                                    ->label('Chuyến đi (Tour liên quan)')
                                    ->relationship('tour', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->placeholder('Chọn tour hoặc để trống nếu là đánh giá chung'),

                                Forms\Components\TextInput::make('title')
                                    ->label('Tiêu đề cảm nhận / Tên trải nghiệm')
                                    ->placeholder('VD: Ha Giang loop, 4 Day Ha Giang Loop...')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('author_name')
                                    ->label('Tên khách đánh giá')
                                    ->required()
                                    ->placeholder('VD: Kimber & Lindsey Walker, Alexander Way...')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('author_location')
                                    ->label('Địa chỉ / Quốc gia')
                                    ->placeholder('VD: United States, United Kingdom, Australia...')
                                    ->maxLength(255),

                                Forms\Components\Select::make('rating')
                                    ->label('Số sao đánh giá')
                                    ->options([
                                        5 => '★★★★★ (5 sao - Tuyệt vời)',
                                        4 => '★★★★☆ (4 sao - Tốt)',
                                        3 => '★★★☆☆ (3 sao - Trung bình)',
                                        2 => '★★☆☆☆ (2 sao - Tạm được)',
                                        1 => '★☆☆☆☆ (1 sao - Kém)',
                                    ])
                                    ->default(5)
                                    ->required(),

                                Forms\Components\TextInput::make('review_date')
                                    ->label('Thời gian đánh giá')
                                    ->default(fn () => 'Tháng ' . date('n') . ', ' . date('Y'))
                                    ->placeholder('VD: Tháng 8, 2026')
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('source')
                                    ->label('Nguồn đánh giá')
                                    ->default('Tripadvisor')
                                    ->placeholder('Tripadvisor, Google, Website...')
                                    ->maxLength(100),

                                Forms\Components\FileUpload::make('author_avatar')
                                    ->label('Ảnh khách / Ảnh trải nghiệm')
                                    ->directory('testimonials')
                                    ->image()
                                    ->imageEditor()
                                    ->helperText('Ảnh chân dung hoặc ảnh chuyến đi của khách du lịch'),

                                Forms\Components\Toggle::make('is_approved')
                                    ->label('Hiển thị trên website')
                                    ->helperText('Bật để đánh giá này được hiển thị công khai')
                                    ->default(true),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Đánh giá nổi bật (Slider trang chủ)')
                                    ->helperText('Bật để hiển thị trong khung trượt lớn ở Trang chủ')
                                    ->default(false),
                            ]),

                        Forms\Components\Textarea::make('comment')
                            ->label('Nội dung cảm nhận / Đánh giá')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull()
                            ->placeholder('Nhập nội dung chia sẻ trải nghiệm thực tế của du khách...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('author_avatar')
                    ->label('Ảnh')
                    ->circular()
                    ->defaultImageUrl(asset('storage/testimonials/lindsey-walker.png')),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->description(fn (Review $record): ?string => $record->title ? ($record->title . ' • ' . $record->author_location) : $record->author_location),

                Tables\Columns\TextColumn::make('tour.title')
                    ->label('Tour')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Đánh giá chung')
                    ->limit(30),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Đánh giá')
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state))
                    ->color('warning')
                    ->sortable(),

                Tables\Columns\TextColumn::make('review_date')
                    ->label('Thời gian')
                    ->sortable(),

                Tables\Columns\TextColumn::make('source')
                    ->label('Nguồn')
                    ->badge()
                    ->color('info'),

                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Duyệt'),

                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Nổi bật (Home)'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tour_id')
                    ->label('Lọc theo Tour')
                    ->relationship('tour', 'title')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Trạng thái duyệt'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
