<?php

namespace App\Filament\Pages;

use App\Models\Option;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Cấu hình hệ thống';

    protected static ?string $navigationLabel = 'Cấu hình website';

    protected static ?string $title = 'Cấu hình thông tin website';

    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Tải toàn bộ cấu hình trực tiếp từ Database (bảng options)
        $options = Option::asArray();

        // Giải mã JSON cho danh sách Hero Banners
        if (!empty($options['hero_banners'])) {
            if (is_string($options['hero_banners'])) {
                $options['hero_banners'] = json_decode($options['hero_banners'], true) ?: [];
            }
        } else {
            $options['hero_banners'] = [];
        }

        $this->form->fill($options);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('SettingsTabs')
                    ->tabs([
                        Tabs\Tab::make('Hero Banner Trang Chủ')
                            ->icon('heroicon-o-presentation-chart-bar')
                            ->schema([
                                Section::make('Cấu hình Trình chiếu Banner Hero (Slider)')
                                    ->description('Thêm hoặc chỉnh sửa các slide banner trên đầu trang chủ. Hỗ trợ hiệu ứng lướt 2 bên và zoom-in nhẹ nhàng.')
                                    ->schema([
                                        Repeater::make('hero_banners')
                                            ->label('Danh sách Banner trình chiếu')
                                            ->itemLabel(fn (array $state): ?string => (!empty($state['title']) ? ($state['title'] . ' ' . ($state['title_highlight'] ?? '')) : 'Banner trình chiếu'))
                                            ->reorderable()
                                            ->collapsible()
                                            ->defaultItems(1)
                                            ->addActionLabel('+ Thêm banner mới')
                                            ->schema([
                                                Grid::make(2)->schema([
                                                    FileUpload::make('image')
                                                        ->label('Tải lên ảnh banner')
                                                        ->disk('public')
                                                        ->directory('banners')
                                                        ->image()
                                                        ->helperText('Khuyên dùng ảnh phong cảnh ngang 1920x800px hoặc 2000x900px.'),
                                                    TextInput::make('image_url')
                                                        ->label('Hoặc URL ảnh bên ngoài (nếu không tải ảnh)')
                                                        ->placeholder('https://images.unsplash.com/...'),
                                                    TextInput::make('badge')
                                                        ->label('Huy hiệu nhỏ (Badge)')
                                                        ->placeholder('#1 Du Lịch Trải Nghiệm Bản Địa'),
                                                    TextInput::make('button_text')
                                                        ->label('Chữ trên nút bấm (Tùy chọn)')
                                                        ->placeholder('Khám phá tour ngay'),
                                                    TextInput::make('title')
                                                        ->label('Tiêu đề chính')
                                                        ->placeholder('Handling all your')
                                                        ->required(),
                                                    TextInput::make('title_highlight')
                                                        ->label('Từ khóa nổi bật (Màu cam gradient)')
                                                        ->placeholder('travel issues'),
                                                    Textarea::make('subtitle')
                                                        ->label('Mô tả phụ')
                                                        ->rows(2)
                                                        ->columnSpanFull()
                                                        ->placeholder('Let us be your travel partner — Đồng hành cùng bạn trên mọi cung đường kỳ vĩ.'),
                                                    TextInput::make('button_link')
                                                        ->label('Đường dẫn nút bấm (Link URL)')
                                                        ->columnSpanFull()
                                                        ->placeholder('#tours-section hoặc /tours'),
                                                ]),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Giải thưởng & Cam kết (Travellers\' Choice)')
                            ->icon('heroicon-o-trophy')
                            ->schema([
                                Section::make('Khối Giải thưởng Tripadvisor Travellers\' Choice')
                                    ->description('Cấu hình biểu tượng và nội dung giải thưởng hiển thị dưới banner trang chủ (như thiết kế Chestnut Travel)')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            FileUpload::make('award_badge_image')
                                                ->label('Tải lên ảnh Huy hiệu / Giải thưởng')
                                                ->disk('public')
                                                ->directory('options')
                                                ->image()
                                                ->helperText('Nếu không tải lên, hệ thống sẽ tự động dùng link ảnh Tripadvisor bên dưới.'),
                                            TextInput::make('award_badge_image_url')
                                                ->label('Hoặc URL ảnh Huy hiệu bên ngoài')
                                                ->placeholder('https://chestnuttravel.net/wp-content/uploads/2026/03/...'),
                                            TextInput::make('award_badge_title')
                                                ->label('Tiêu đề giải thưởng')
                                                ->placeholder('Travellers\' Choice')
                                                ->required(),
                                            TextInput::make('award_badge_link')
                                                ->label('Link chứng nhận Tripadvisor (Tùy chọn)')
                                                ->placeholder('https://www.tripadvisor.com/...'),
                                            Textarea::make('award_badge_text')
                                                ->label('Nội dung giải thích / Thông báo giải thưởng')
                                                ->rows(2)
                                                ->columnSpanFull()
                                                ->placeholder('We\'re excited to announce that Chestnut Travel has received the Travellers\' Choice Award 2025 from Tripadvisor!'),
                                        ]),
                                    ]),
                                Section::make('3 Cột Cam kết Dịch vụ Cốt lõi')
                                    ->description('Cấu hình 3 giá trị nổi bật hiển thị ngay dưới giải thưởng Travellers\' Choice')
                                    ->schema([
                                        Grid::make(3)->schema([
                                            Section::make('Cột 1: Chuyên gia bản địa')->schema([
                                                TextInput::make('feature_1_title')
                                                    ->label('Tiêu đề cột 1')
                                                    ->default('Local Travel Experts')
                                                    ->required(),
                                                Textarea::make('feature_1_desc')
                                                    ->label('Mô tả cột 1')
                                                    ->rows(4)
                                                    ->default('Our knowledgeable staff will advise you in finding the most appropriate and fantastic itineraries based on your preferences of each place.'),
                                            ]),
                                            Section::make('Cột 2: Đảm bảo giá tốt nhất')->schema([
                                                TextInput::make('feature_2_title')
                                                    ->label('Tiêu đề cột 2')
                                                    ->default('Best Price Guaranteed')
                                                    ->required(),
                                                Textarea::make('feature_2_desc')
                                                    ->label('Mô tả cột 2')
                                                    ->rows(4)
                                                    ->default('Our Best Price Guarantee means that you can be sure of booking at the best rate.'),
                                            ]),
                                            Section::make('Cột 3: Hỗ trợ 24/7')->schema([
                                                TextInput::make('feature_3_title')
                                                    ->label('Tiêu đề cột 3')
                                                    ->default('24/7 Customer Service')
                                                    ->required(),
                                                Textarea::make('feature_3_desc')
                                                    ->label('Mô tả cột 3')
                                                    ->rows(4)
                                                    ->default('Our customer are standing by 24/7 to make your experience incredible.'),
                                            ]),
                                        ]),
                                    ]),
                                Section::make('Tiêu đề & Giới thiệu Mục "Popular Trips"')
                                    ->description('Cấu hình tiêu đề căn giữa của danh sách tour nổi bật trang chủ')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('popular_trips_badge')
                                                ->label('Nhãn phụ (Badge)')
                                                ->default('Popular Trips'),
                                            TextInput::make('popular_trips_title')
                                                ->label('Tiêu đề chính')
                                                ->default('Explore popular trips.')
                                                ->required(),
                                            Textarea::make('popular_trips_subtitle')
                                                ->label('Đoạn mô tả ngắn')
                                                ->rows(2)
                                                ->columnSpanFull()
                                                ->default('Các chuyến đi được yêu thích nhất với lịch trình được tối ưu kỹ lưỡng và dịch vụ trọn gói chất lượng cao.'),
                                        ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Liên hệ & Hotline')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('site_hotline')
                                        ->label('Hotline hiển thị')
                                        ->placeholder('+84 867 216 850')
                                        ->required(),
                                    TextInput::make('site_email')
                                        ->label('Email liên hệ & hỗ trợ')
                                        ->email()
                                        ->placeholder('info@chestnuttravel.net')
                                        ->required(),
                                    TextInput::make('site_whatsapp')
                                        ->label('Số WhatsApp hỗ trợ')
                                        ->placeholder('+84 867 216 850'),
                                    TextInput::make('site_whatsapp_link')
                                        ->label('Đường dẫn trực tiếp WhatsApp (Link chat)')
                                        ->placeholder('https://wa.me/84867216850'),
                                    TextInput::make('site_address')
                                        ->label('Địa chỉ trụ sở / Văn phòng')
                                        ->columnSpanFull()
                                        ->placeholder('Số 15 Ngõ Cầu Gỗ, Hoàn Kiếm, Hà Nội'),
                                    TextInput::make('working_hours')
                                        ->label('Thời gian làm việc hỗ trợ khách')
                                        ->columnSpanFull()
                                        ->placeholder('07:30 - 22:00 (Thứ 2 - Chủ Nhật)'),
                                ]),
                            ]),

                        Tabs\Tab::make('Thương hiệu & Hình ảnh')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('site_name')
                                        ->label('Tên thương hiệu / Website')
                                        ->required()
                                        ->placeholder('Chestnut Travel'),
                                    TextInput::make('site_tagline')
                                        ->label('Slogan / Khẩu hiệu')
                                        ->placeholder('Authentic Vietnam Tours & Experiences'),
                                ]),
                                Section::make('Logo Website')->schema([
                                    FileUpload::make('site_logo')
                                        ->label('Tải lên Logo mới (từ máy tính)')
                                        ->disk('public')
                                        ->directory('options')
                                        ->image()
                                        ->helperText('Hệ thống hỗ trợ file PNG, JPG, WEBP, SVG. Để trống nếu muốn giữ nguyên logo hiện tại.'),
                                    TextInput::make('site_logo_url')
                                        ->label('Hoặc Đường dẫn URL Logo bên ngoài (nếu không tải ảnh lên)')
                                        ->placeholder('https://chestnuttravel.net/wp-content/uploads/2023/12/logo-chestnut.png'),
                                ]),
                                Section::make('Favicon (Biểu tượng trên tab trình duyệt)')->schema([
                                    FileUpload::make('site_favicon')
                                        ->label('Tải lên Favicon mới')
                                        ->disk('public')
                                        ->directory('options')
                                        ->image()
                                        ->helperText('Khuyên dùng ảnh vuông 32x32px hoặc 64x64px định dạng PNG/ICO.'),
                                    TextInput::make('site_favicon_url')
                                        ->label('Hoặc Đường dẫn URL Favicon bên ngoài')
                                        ->placeholder('https://chestnuttravel.net/wp-content/uploads/2023/12/cropped-favicon-32x32.png'),
                                ]),
                                Section::make('Ảnh dải thanh toán Footer (Secured Payment)')
                                    ->description('Ảnh hiển thị các logo phương thức thanh toán ở cuối footer (Visa, Mastercard, PayPal...)')
                                    ->schema([
                                        FileUpload::make('footer_payment_image')
                                            ->label('Tải lên ảnh dải thanh toán')
                                            ->disk('public')
                                            ->directory('options')
                                            ->image()
                                            ->helperText('Khuyên dùng ảnh ngang PNG/WEBP khoảng 196x26px hoặc lớn hơn.'),
                                        TextInput::make('footer_payment_image_url')
                                            ->label('Hoặc URL ảnh bên ngoài')
                                            ->placeholder('https://example.com/payment-icons.png'),
                                    ]),
                                Section::make('Ảnh branding Booking Modal')
                                    ->description('Logo hoặc ảnh thương hiệu hiển thị trong hộp thoại đặt tour')
                                    ->schema([
                                        FileUpload::make('booking_modal_logo')
                                            ->label('Tải lên logo booking modal')
                                            ->disk('public')
                                            ->directory('options')
                                            ->image()
                                            ->helperText('Hiển thị bên trong modal đặt tour. Để trống sẽ dùng logo chính.'),
                                        TextInput::make('booking_modal_logo_url')
                                            ->label('Hoặc URL ảnh booking modal')
                                            ->placeholder('https://example.com/booking-logo.png'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Mạng xã hội')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('social_facebook')
                                        ->label('Facebook URL')
                                        ->placeholder('https://facebook.com/chestnuttravel'),
                                    TextInput::make('social_instagram')
                                        ->label('Instagram URL')
                                        ->placeholder('https://instagram.com/chestnuttravel'),
                                    TextInput::make('social_tripadvisor')
                                        ->label('TripAdvisor URL')
                                        ->placeholder('https://tripadvisor.com/...'),
                                    TextInput::make('social_tiktok')
                                        ->label('TikTok URL')
                                        ->placeholder('https://tiktok.com/@chestnuttravel'),
                                    TextInput::make('social_youtube')
                                        ->label('YouTube URL')
                                        ->placeholder('https://youtube.com/@chestnuttravel'),
                                ]),
                            ]),

                        Tabs\Tab::make('Chân trang & Pháp lý')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Textarea::make('footer_about')
                                    ->label('Đoạn giới thiệu ngắn ở chân trang')
                                    ->rows(3),
                                TextInput::make('footer_license')
                                    ->label('Giấy phép kinh doanh lữ hành')
                                    ->placeholder('Giấy phép Lữ hành Quốc tế số: 01-1898/2023/TCDL-GP LHQT'),
                                TextInput::make('footer_copyright')
                                    ->label('Dòng bản quyền Footer')
                                    ->placeholder('© 2026 Chestnut Travel. Tất cả các quyền được bảo lưu.'),
                            ]),

                        Tabs\Tab::make('Cấu hình Đặt tour')
                            ->icon('heroicon-o-ticket')
                            ->schema([
                                Textarea::make('booking_notice')
                                    ->label('Thông báo / Lưu ý cho khách khi đặt tour')
                                    ->rows(3)
                                    ->helperText('Hiển thị trong hộp thoại đặt tour nhanh cho khách hàng.'),
                                TextInput::make('child_discount_percent')
                                    ->label('Phần trăm giảm giá cho trẻ em (%)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->suffix('%')
                                    ->default(25),
                            ]),

                        Tabs\Tab::make('Thanh toán VietQR & Ngân hàng')
                            ->icon('heroicon-o-qr-code')
                            ->schema([
                                Section::make('Thông tin Tài khoản Ngân hàng nhận thanh toán (VietQR)')
                                    ->description('Cấu hình số tài khoản để khách hàng quét mã VietQR tự động hoặc chuyển khoản khi đặt tour.')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('site_bank_name')
                                                ->label('Tên Ngân hàng')
                                                ->required()
                                                ->default('MB Bank (Ngân hàng Quân Đội)')
                                                ->placeholder('VD: MB Bank, Vietcombank, Techcombank, ACB, VPBank...'),

                                            TextInput::make('site_bank_bin')
                                                ->label('Mã ngân hàng VietQR (Shortcode / BIN)')
                                                ->default('MB')
                                                ->helperText('Dùng để tạo link mã QR VietQR tự động (VD: MB, VCB, TCB, ACB, VPB, ICB, BIDV, TPB...)')
                                                ->placeholder('MB'),

                                            TextInput::make('site_bank_account')
                                                ->label('Số tài khoản ngân hàng (STK)')
                                                ->required()
                                                ->default('0348788668')
                                                ->placeholder('VD: 0348788668'),

                                            TextInput::make('site_bank_owner')
                                                ->label('Tên chủ tài khoản (In hoa không dấu)')
                                                ->required()
                                                ->default('CHESTNUT TRAVEL VN')
                                                ->placeholder('VD: NGUYEN TRUNG HIEU hoặc CHESTNUT TRAVEL'),
                                        ]),

                                        FileUpload::make('site_bank_qr_image')
                                            ->label('Tải lên ảnh Mã QR ngân hàng cố định (Tùy chọn)')
                                            ->disk('public')
                                            ->directory('options')
                                            ->image()
                                            ->helperText('Nếu không tải ảnh lên, hệ thống sẽ tự động dùng VietQR API chuẩn để sinh mã QR kèm chính xác số tiền và mã đơn tour.'),

                                        Textarea::make('site_bank_note')
                                            ->label('Ghi chú / Hướng dẫn thanh toán cho khách')
                                            ->rows(3)
                                            ->default('Vui lòng quét mã QR hoặc chuyển khoản với nội dung là Mã đơn đặt tour (VD: CNT-A1B2C3). Đơn hàng sẽ được quản trị viên duyệt và gửi email xác nhận ngay khi nhận được thanh toán.')
                                            ->helperText('Hiển thị trên hộp thoại đặt tour và trang xác nhận đơn hàng.'),
                                    ]),
                            ]),
                    ])
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            // Preserve existing uploaded file if user did not choose a new file
            if (in_array($key, ['site_logo', 'site_favicon', 'award_badge_image', 'footer_payment_image', 'booking_modal_logo', 'site_bank_qr_image']) && $value === null) {
                continue;
            }

            if (is_array($value)) {
                Option::set($key, $value, 'general', 'json');
            } else {
                Option::set($key, (string) ($value ?? ''));
            }
        }

        Notification::make()
            ->title('Đã lưu cấu hình website thành công!')
            ->success()
            ->send();
    }
}
