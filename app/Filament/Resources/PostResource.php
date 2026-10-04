<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Nội dung & Tin tức';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Bài viết / Blog';

    protected static ?string $pluralModelLabel = 'Bài viết (Blog & Tips)';

    protected static ?string $navigationLabel = 'Bài viết Blog & Tips';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Nội dung bài viết')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Tiêu đề bài viết')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn tĩnh (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Post::class, 'slug', ignoreRecord: true),

                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Tóm tắt ngắn (Excerpt)')
                                    ->rows(3)
                                    ->columnSpanFull()
                                    ->helperText('Mô tả ngắn gọn hiển thị trên danh sách bài viết trang chủ.'),

                                Forms\Components\RichEditor::make('content')
                                    ->label('Nội dung chi tiết')
                                    ->required()
                                    ->fileAttachmentsDirectory('posts/content')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Hình ảnh & Xuất bản')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Ảnh đại diện bài viết')
                                    ->image()
                                    ->directory('posts')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:10'),

                                Forms\Components\TextInput::make('category')
                                    ->label('Chuyên mục / Danh mục')
                                    ->default('Travel Guide')
                                    ->required(),

                                Forms\Components\TextInput::make('author_name')
                                    ->label('Tác giả')
                                    ->default('admin')
                                    ->required(),

                                Forms\Components\TagsInput::make('tags')
                                    ->label('Thẻ từ khóa (Tags)')
                                    ->placeholder('Nhập tag và bấm Enter'),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Ngày xuất bản')
                                    ->default(now()),

                                Forms\Components\Toggle::make('is_published')
                                    ->label('Xuất bản công khai')
                                    ->default(true),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Nổi bật (Hiển thị Trang chủ)')
                                    ->default(false),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Ảnh')
                    ->circular(false)
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('category')
                    ->label('Chuyên mục')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('Tác giả')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Đã xuất bản')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Nổi bật')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Trạng thái xuất bản'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Bài nổi bật'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
