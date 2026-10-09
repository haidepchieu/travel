<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?string $navigationGroup = 'Quản lý Tour';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Tour du lịch';

    protected static ?string $pluralModelLabel = 'Danh sách Tour';

    protected static ?string $navigationLabel = 'Tất cả Tour';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Chi tiết Tour')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Thông tin chung')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Tiêu đề Tour')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Đường dẫn URL (Slug)')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(Tour::class, 'slug', ignoreRecord: true),

                                        Forms\Components\TextInput::make('tagline')
                                            ->label('Nhãn nổi bật / Phụ đề')
                                            ->placeholder('VD: Bán chạy nhất, Tour Hà Giang Loop hot nhất')
                                            ->maxLength(255),

                                        Forms\Components\Select::make('destination_id')
                                            ->label('Điểm đến')
                                            ->relationship('destination', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')->label('Tên điểm đến')->required(),
                                                Forms\Components\TextInput::make('slug')->label('Đường dẫn URL')->required(),
                                            ]),

                                        Forms\Components\Select::make('activities')
                                            ->label('Danh mục / Hoạt động trải nghiệm')
                                            ->relationship('activities', 'name')
                                            ->multiple()
                                            ->preload(),

                                        Forms\Components\Select::make('trip_type')
                                            ->label('Loại hình chuyến đi')
                                            ->options([
                                                'Xe máy có lái xe (Easy Rider)' => 'Xe máy có lái xe (Easy Rider)',
                                                'Tự lái xe máy (Self-Drive)' => 'Tự lái xe máy (Self-Drive)',
                                                'Tour ghép đoàn chất lượng cao' => 'Tour ghép đoàn chất lượng cao',
                                                'Tour riêng theo yêu cầu' => 'Tour riêng theo yêu cầu',
                                                'Trekking & Đi bộ bản địa' => 'Trekking & Đi bộ bản địa',
                                                'Du thuyền nghỉ dưỡng' => 'Du thuyền nghỉ dưỡng',
                                                'Du thuyền trong ngày' => 'Du thuyền trong ngày',
                                                'Gói Combo Trọn Gói' => 'Gói Combo Trọn Gói (Nhiều chặng)',
                                                'Sinh thái & Nghỉ dưỡng' => 'Sinh thái & Nghỉ dưỡng',
                                                'Trekking & Săn mây' => 'Trekking & Săn mây',
                                                'Du thuyền & Chèo Kayak' => 'Du thuyền & Chèo Kayak',
                                                'Khám phá & Nghỉ dưỡng' => 'Khám phá & Nghỉ dưỡng',
                                                // Tương thích dữ liệu cũ
                                                'Easy Rider (Motorbike with Guide)' => 'Easy Rider (Lái xe kèm hướng dẫn)',
                                                'Self-Driving Motorbike' => 'Tự lái xe máy',
                                                'Group Tour' => 'Tour ghép đoàn',
                                                'Private Tour' => 'Tour riêng (Private Tour)',
                                                'Trekking & Hiking' => 'Đi bộ leo núi (Trekking & Hiking)',
                                                'Cruise & Island' => 'Du thuyền & Biển đảo',
                                                'Package Combo' => 'Gói Combo (Package Combo)',
                                            ])
                                            ->searchable(),

                                        Forms\Components\TextInput::make('duration_days')
                                            ->label('Số ngày')
                                            ->numeric()
                                            ->default(3)
                                            ->required(),

                                        Forms\Components\TextInput::make('duration_nights')
                                            ->label('Số đêm')
                                            ->numeric()
                                            ->default(2)
                                            ->required(),

                                        Forms\Components\TextInput::make('departure_from')
                                            ->label('Điểm khởi hành')
                                            ->placeholder('VD: Phố cổ Hà Nội / Hà Giang')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('group_size')
                                            ->label('Quy mô đoàn')
                                            ->placeholder('VD: Nhóm nhỏ 6 - 10 khách')
                                            ->maxLength(255),

                                        Forms\Components\Select::make('difficulty')
                                            ->label('Độ khó')
                                            ->options([
                                                'Dễ' => 'Dễ (Thư giãn, nhẹ nhàng)',
                                                'Vừa phải' => 'Vừa phải (Phù hợp đại đa số)',
                                                'Trung bình' => 'Trung bình',
                                                'Thử thách' => 'Thử thách (Đòi hỏi thể lực / Săn mây)',
                                                'Khó' => 'Khó (Trekking đường dài)',
                                                // Tương thích dữ liệu cũ
                                                'Easy' => 'Dễ (Easy)',
                                                'Medium' => 'Vừa phải (Medium)',
                                                'Moderate' => 'Vừa phải (Moderate)',
                                                'Challenging' => 'Thử thách (Challenging)',
                                                'Difficult' => 'Khó (Difficult)',
                                            ])
                                            ->default('Easy')
                                            ->required(),

                                        Forms\Components\TextInput::make('transportation')
                                            ->label('Phương tiện di chuyển')
                                            ->placeholder('VD: Xe limousine giường nằm + Xe máy')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\RichEditor::make('overview')
                                    ->label('Bài viết chi tiết & Giới thiệu Tour (Soạn thảo văn bản, hình ảnh, tiêu đề...)')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('tours/articles')
                                    ->toolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Lịch trình theo ngày')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Forms\Components\Repeater::make('itineraries')
                                    ->relationship('itineraries')
                                    ->label('Lịch trình chi tiết từng ngày')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('day_number')
                                                    ->label('Ngày số')
                                                    ->numeric()
                                                    ->default(1)
                                                    ->required(),

                                                Forms\Components\TextInput::make('title')
                                                    ->label('Tiêu đề ngày')
                                                    ->placeholder('VD: Ngày 1: Hà Giang - Quản Bạ - Yên Minh')
                                                    ->required()
                                                    ->columnSpan(2),

                                                Forms\Components\TextInput::make('meals')
                                                    ->label('Bữa ăn bao gồm')
                                                    ->placeholder('VD: Sáng, Trưa, Tối'),

                                                Forms\Components\TextInput::make('accommodation')
                                                    ->label('Nơi lưu trú')
                                                    ->placeholder('VD: Homestay bản làng / Khách sạn 3 sao')
                                                    ->columnSpan(2),
                                            ]),

                                        Forms\Components\RichEditor::make('description')
                                            ->label('Chi tiết hoạt động trong ngày')
                                            ->columnSpanFull(),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => ($state['day_number'] ?? '') ? ('Ngày ' . $state['day_number'] . ': ' . ($state['title'] ?? '')) : null)
                                    ->collapsible()
                                    ->cloneable()
                                    ->reorderable('order')
                                    ->orderColumn('order')
                                    ->defaultItems(0)
                                    ->addActionLabel('Thêm ngày vào lịch trình'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Giá & Gói dịch vụ')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('price')
                                            ->label('Giá cơ bản ($)')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required(),

                                        Forms\Components\TextInput::make('sale_price')
                                            ->label('Giá khuyến mãi ($)')
                                            ->numeric()
                                            ->prefix('$'),

                                        Forms\Components\TextInput::make('rating')
                                            ->label('Điểm đánh giá')
                                            ->numeric()
                                            ->default(5.00),
                                    ]),

                                Forms\Components\Repeater::make('prices')
                                    ->relationship('prices')
                                    ->label('Tùy chọn gói giá (VD: Tự lái vs Easy Rider)')
                                    ->schema([
                                        Forms\Components\TextInput::make('option_name')
                                            ->label('Tên gói / Tùy chọn')
                                            ->placeholder('VD: Gói Easy Rider (Ngồi sau hướng dẫn viên)')
                                            ->required(),
                                        Forms\Components\TextInput::make('price')
                                            ->label('Giá ($)')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required(),
                                        Forms\Components\TextInput::make('sale_price')
                                            ->label('Giá khuyến mãi ($)')
                                            ->numeric()
                                            ->prefix('$'),
                                        Forms\Components\TextInput::make('notes')
                                            ->label('Ghi chú gói')
                                            ->placeholder('VD: Bao gồm lái xe, xăng, mũ bảo hiểm...'),
                                    ])
                                    ->columns(4)
                                    ->defaultItems(0)
                                    ->addActionLabel('Thêm tùy chọn giá'),

                                Forms\Components\TagsInput::make('highlights')
                                    ->label('Điểm nổi bật của Tour')
                                    ->placeholder('Nhập điểm nổi bật và nhấn Enter')
                                    ->columnSpanFull(),

                                Forms\Components\TagsInput::make('inclusions')
                                    ->label('Dịch vụ bao gồm')
                                    ->placeholder('VD: Hướng dẫn viên tiếng Anh, Vé tham quan, Homestay...')
                                    ->columnSpanFull(),

                                Forms\Components\TagsInput::make('exclusions')
                                    ->label('Dịch vụ không bao gồm')
                                    ->placeholder('VD: Đồ uống cá nhân, Tiền tip, Bảo hiểm du lịch...')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Dịch vụ tùy chọn (Add-ons)')
                            ->icon('heroicon-o-puzzle-piece')
                            ->schema([
                                Forms\Components\Section::make('Cấu hình dịch vụ tùy chọn cộng thêm (Extra Services)')
                                    ->description('Cấu hình các dịch vụ khách hàng có thể chọn mua thêm khi đặt tour này (Quản lý và thêm mới danh mục dịch vụ tại menu Quản lý Tour > Dịch vụ cộng thêm).')
                                    ->schema([
                                        Forms\Components\Radio::make('extra_services_mode')
                                            ->label('Chế độ áp dụng dịch vụ cộng thêm cho Tour này')
                                            ->options([
                                                'all' => 'Áp dụng tất cả dịch vụ chung mặc định (Limousine, Phòng riêng, Bảo hiểm...)',
                                                'custom' => 'Tùy chọn cụ thể các dịch vụ áp dụng riêng cho tour này',
                                                'none' => 'Không áp dụng dịch vụ nào (Tour đã trọn gói, không có phí phát sinh)',
                                            ])
                                            ->default('all')
                                            ->live()
                                            ->required(),

                                        Forms\Components\CheckboxList::make('extraServices')
                                            ->relationship('extraServices', 'name', fn ($query) => $query->where('is_active', true)->orderBy('sort_order'))
                                            ->label('Danh sách dịch vụ áp dụng riêng cho Tour này')
                                            ->helperText('Tích chọn các dịch vụ khách hàng có thể chọn khi đặt tour này.')
                                            ->columns(2)
                                            ->bulkToggleable()
                                            ->searchable()
                                            ->visible(fn (Forms\Get $get) => $get('extra_services_mode') === 'custom'),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Gói Combo Tour (Package Bundle)')
                            ->icon('heroicon-o-gift')
                            ->schema([
                                Forms\Components\Section::make('Cấu hình Gói Tour Combo')
                                    ->description('Ghép nối nhiều tour thành phần vào một hành trình trọn gói liền mạch, kích thích khách đặt trọn gói.')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_combo')
                                            ->label('Kích hoạt: Đây là Gói Tour Combo (Package Combo)')
                                            ->helperText('Khi bật, tour sẽ có huy hiệu Combo, được xếp vào danh mục Package Combo và hiển thị các chặng hành trình chi tiết.')
                                            ->live(),

                                        Forms\Components\Grid::make(2)
                                            ->visible(fn (Forms\Get $get) => (bool) $get('is_combo'))
                                            ->schema([
                                                Forms\Components\TextInput::make('combo_badge')
                                                    ->label('Huy hiệu nổi bật')
                                                    ->placeholder('VD: TIẾT KIỆM $60 / BEST VALUE')
                                                    ->default('HOT COMBO'),

                                                Forms\Components\TextInput::make('combo_saving_amount')
                                                    ->label('Số tiền tiết kiệm ($)')
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->placeholder('VD: 60')
                                                    ->helperText('Hiển thị mức tiết kiệm so với mua lẻ từng tour'),
                                            ]),

                                        Forms\Components\Repeater::make('comboItems')
                                            ->relationship('comboItems')
                                            ->label('Các Tour & Chặng thành phần trong Combo')
                                            ->visible(fn (Forms\Get $get) => (bool) $get('is_combo'))
                                            ->schema([
                                                Forms\Components\Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\Select::make('child_tour_id')
                                                            ->label('Tour thành phần')
                                                            ->options(fn () => \App\Models\Tour::where('is_combo', false)->pluck('title', 'id'))
                                                            ->searchable()
                                                            ->required()
                                                            ->columnSpan(2),

                                                        Forms\Components\TextInput::make('stage_days')
                                                            ->label('Số ngày chặng này')
                                                            ->numeric()
                                                            ->default(1)
                                                            ->required(),

                                                        Forms\Components\TextInput::make('stage_title')
                                                            ->label('Tiêu đề chặng (Tùy chọn)')
                                                            ->placeholder('VD: Chặng 1: Trekking bản làng & Fansipan - Sa Pa')
                                                            ->columnSpan(2),

                                                        Forms\Components\TextInput::make('transit_notes')
                                                            ->label('Phương tiện & Ghi chú trung chuyển sang chặng tiếp')
                                                            ->placeholder('VD: Xe cabin giường nằm VIP đón lúc 21h00 di chuyển qua đêm sang Hà Giang')
                                                            ->columnSpanFull(),
                                                    ]),
                                            ])
                                            ->orderColumn('stage_order')
                                            ->itemLabel(fn (array $state): ?string => ($state['stage_title'] ?? '') ?: (isset($state['child_tour_id']) ? ('Tour #' . $state['child_tour_id']) : null))
                                            ->defaultItems(0)
                                            ->addActionLabel('Thêm chặng tour vào Combo')
                                            ->collapsible()
                                            ->cloneable(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Hình ảnh & Thư viện')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Ảnh đại diện chính')
                                    ->image()
                                    ->disk('public')
                                    ->directory('tours/featured')
                                    ->imageEditor()
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('gallery')
                                    ->label('Bộ sưu tập ảnh Tour (Tải lên nhiều ảnh từ máy tính)')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->disk('public')
                                    ->directory('tours/gallery')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('gallery_urls')
                                    ->label('Hoặc danh sách URL ảnh bên ngoài (Mỗi dòng 1 link ảnh)')
                                    ->placeholder("https://images.unsplash.com/photo-...\nhttps://chestnuttravel.net/wp-content/uploads/...")
                                    ->rows(4)
                                    ->helperText('Hệ thống sẽ tự động gộp cả ảnh tải lên và link ảnh ngoài này vào bộ sưu tập ảnh của Tour.')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Câu hỏi thường gặp (FAQ)')
                            ->icon('heroicon-o-question-mark-circle')
                            ->schema([
                                Forms\Components\Repeater::make('faqs')
                                    ->label('Danh sách Câu hỏi thường gặp & Giải đáp')
                                    ->schema([
                                        Forms\Components\TextInput::make('question')
                                            ->label('Câu hỏi')
                                            ->required()
                                            ->placeholder('VD: Tôi cần chuẩn bị trang phục và hành lý gì khi tham gia tour?')
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('answer')
                                            ->label('Câu trả lời chi tiết')
                                            ->required()
                                            ->rows(3)
                                            ->placeholder('Nhập nội dung giải đáp cặn kẽ cho du khách...')
                                            ->columnSpanFull(),
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['question'] ?? null)
                                    ->collapsible()
                                    ->cloneable()
                                    ->reorderable()
                                    ->defaultItems(0)
                                    ->addActionLabel('Thêm câu hỏi mới (Add FAQ)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Hiển thị & Trạng thái')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Kích hoạt / Đang mở bán')
                                    ->default(true),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Nổi bật trên trang chủ')
                                    ->default(false),

                                Forms\Components\Placeholder::make('real_review_count')
                                    ->label('Tổng lượt đánh giá thực tế')
                                    ->content(function (?Tour $record): string {
                                        if (!$record) {
                                            return '0 đánh giá (Chưa tạo tour)';
                                        }
                                        $total = $record->reviews()->count();
                                        $approved = $record->reviews()->where('is_approved', true)->count();
                                        $avg = $record->reviews()->avg('rating');
                                        $avgStr = $avg ? number_format($avg, 1) . '★' : 'Chưa có sao';
                                        return "{$total} đánh giá thực tế ({$approved} đã duyệt hiển thị) — Điểm trung bình: {$avgStr}";
                                    })
                                    ->helperText('Hệ thống tự động thống kê từ các đánh giá thực tế được khai báo ở tour này (xem chi tiết ở tab Đánh giá bên dưới).'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Ảnh đại diện')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Tên Tour')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Tour $record): string => $record->tagline ?? ($record->duration_days . 'N/' . $record->duration_nights . 'Đ')),

                Tables\Columns\TextColumn::make('destination.name')
                    ->label('Điểm đến')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Giá cơ bản')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('trip_type')
                    ->label('Loại hình')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'Easy Rider (Motorbike with Guide)' => 'Easy Rider',
                        'Self-Driving Motorbike' => 'Tự lái xe máy',
                        'Group Tour' => 'Tour ghép đoàn',
                        'Private Tour' => 'Tour riêng',
                        'Trekking & Hiking' => 'Trekking & Hiking',
                        'Cruise & Island' => 'Du thuyền & Đảo',
                        default => $state ?? '',
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('difficulty')
                    ->label('Độ khó')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Easy' => 'success',
                        'Medium', 'Moderate' => 'warning',
                        'Challenging', 'Difficult' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Nổi bật')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_combo')
                    ->label('Combo')
                    ->boolean()
                    ->trueIcon('heroicon-o-gift')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Mở bán')
                    ->boolean(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Điểm sao')
                    ->numeric(2)
                    ->sortable(),

                Tables\Columns\TextColumn::make('reviews_count')
                    ->counts('reviews')
                    ->label('Lượt ĐG')
                    ->badge()
                    ->color('info')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('destination')
                    ->label('Điểm đến')
                    ->relationship('destination', 'name'),
                Tables\Filters\TernaryFilter::make('is_combo')
                    ->label('Gói Tour Combo')
                    ->placeholder('Tất cả tour')
                    ->trueLabel('Chỉ các Gói Combo')
                    ->falseLabel('Chỉ Tour đơn lẻ'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Tour nổi bật'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Tour đang mở bán'),
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
            RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
