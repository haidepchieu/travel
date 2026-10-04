@extends('layouts.app')

@section('title', 'Thiết Kế Tour Riêng Theo Yêu Cầu - ' . option('site_name', 'Chestnut Travel'))
@section('meta_description', 'Thiết kế kỳ nghỉ mơ ước tại Việt Nam cùng Chestnut Travel: Tùy chỉnh lịch trình, ngày khởi hành, ngân sách và phương tiện theo ý bạn.')

@section('content')
<!-- HERO SECTION -->
<div class="relative bg-gradient-to-br from-[#1b5e56] via-[#26786e] to-[#1d5c54] text-white pt-12 pb-20 overflow-hidden">
    <!-- Background subtle texture & glow -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#28B5A4]/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-black/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb matching Chestnut Travel -->
        <nav class="flex items-center space-x-2 text-xs text-teal-100/80 mb-6 font-medium">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1.5">
                <i class="fa-solid fa-house text-[11px]"></i>
                <span>Trang chủ</span>
            </a>
            <span class="text-teal-200/50">/</span>
            <span class="text-white font-semibold">Thiết kế tour riêng</span>
        </nav>

        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white/10 backdrop-blur-md text-teal-100 border border-white/15 mb-4 shadow-sm">
                <i class="fa-solid fa-sliders text-[#28B5A4]"></i>
                Trải nghiệm độc bản theo yêu cầu
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-5 font-serif-display leading-tight">
                Thiết Kế Tour Riêng Theo Ý Bạn
            </h1>
            <div class="space-y-3 text-teal-50/90 text-sm sm:text-base leading-relaxed font-light">
                <p>
                    Chúng tôi chuẩn bị biểu mẫu chi tiết dưới đây để bạn dễ dàng chia sẻ ý tưởng và mong muốn về chuyến đi của mình.
                </p>
                <p>
                    Bạn có thể tùy chọn ngày đi, điểm đến yêu thích, tiêu chuẩn phòng nghỉ, phương tiện di chuyển và ngân sách dự kiến. Đội ngũ chuyên gia bản địa của Chestnut Travel sẽ thiết kế lịch trình tối ưu nhất dành riêng cho bạn!
                </p>
                <p class="font-normal text-white">
                    Tất cả tư vấn và lên lịch trình đều hoàn toàn miễn phí và được phản hồi trong vòng 30 phút.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- MAIN FORM CONTAINER -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 pb-20 relative z-20">

    @if(session('custom_tour_message'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-lg flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
            <i class="fa-solid fa-check text-lg"></i>
        </div>
        <div>
            <h3 class="font-bold text-emerald-900 text-base mb-1">Gửi yêu cầu thành công!</h3>
            <p class="text-emerald-700 text-sm">{{ session('custom_tour_message') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl shadow-teal-900/5 border border-gray-100 overflow-hidden">
        <!-- Progress / Header Bar -->
        <div class="bg-gray-50/80 px-6 sm:px-10 py-5 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#26786e] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                    <i class="fa-solid fa-pencil"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900">Chi tiết Tour theo yêu cầu của bạn</h2>
                    <p class="text-xs text-gray-500">Chỉ mất 2 phút để hoàn thiện - Đội ngũ chuyên gia sẽ thiết kế lịch trình miễn phí</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold text-teal-800 bg-teal-50 px-3 py-1.5 rounded-full border border-teal-100">
                <i class="fa-regular fa-clock text-teal-600"></i>
                <span>Phản hồi trong 30 phút</span>
            </div>
        </div>

        <form action="{{ route('customized-tour.store') }}" method="POST" id="customized-tour-form" class="p-6 sm:p-10 space-y-10">
            @csrf

            <!-- SECTION 1: CONTACT INFORMATION -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">1</span>
                    <h3 class="text-base font-bold text-gray-900">Thông tin liên hệ</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Họ và tên của bạn <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="customer_name" required value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}"
                                   placeholder="VD: Nguyen Van A / John Smith"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Email nhận lịch trình & báo giá <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email" name="customer_email" required value="{{ Auth::check() ? Auth::user()->email : old('customer_email') }}"
                                   placeholder="email@example.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Số điện thoại <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-brands fa-whatsapp absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-base"></i>
                            <input type="tel" name="customer_phone" required value="{{ Auth::check() ? (Auth::user()->phone ?? '') : old('customer_phone') }}"
                                   placeholder="+84 867 216 850 hoặc số Zalo"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Quốc tịch / Nơi sinh sống
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-globe absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="nationality" value="{{ old('nationality') }}"
                                   placeholder="VD: Vietnam, Australia, United States, France..."
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: TRIP DATES & TRAVELERS -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">2</span>
                    <h3 class="text-base font-bold text-gray-900">Thời gian & Số lượng khách</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Ngày dự kiến khởi hành
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="date" name="departure_date" min="{{ date('Y-m-d') }}" value="{{ old('departure_date') }}"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Thời gian chuyến đi (Số ngày)
                        </label>
                        <select name="duration" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition bg-white">
                            <option value="2-3 ngày (Cuối tuần ngắn ngày)">2 - 3 ngày (Chuyến đi ngắn)</option>
                            <option value="4-5 ngày (Tour phổ biến nhất)" selected>4 - 5 ngày (Phổ biến nhất)</option>
                            <option value="6-7 ngày (1 tuần trải nghiệm)">6 - 7 ngày (1 tuần trọn vẹn)</option>
                            <option value="8-10 ngày (Khám phá sâu)">8 - 10 ngày (Bắc & Trung Bộ)</option>
                            <option value="Trên 10 ngày (Xuyên Việt)">Trên 10 ngày (Grand Tour)</option>
                            <option value="Linh hoạt theo tư vấn">Linh hoạt theo tư vấn chuyên gia</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Người lớn <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="adults" min="1" max="50" value="2" required
                                   class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition text-center font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Trẻ em (&lt;12t)
                            </label>
                            <input type="number" name="children" min="0" max="20" value="0"
                                   class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition text-center font-bold">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: PREFERRED DESTINATIONS -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">3</span>
                        <h3 class="text-base font-bold text-gray-900">Điểm đến mong muốn</h3>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">Có thể chọn nhiều điểm</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5">
                    @php
                        $presetDestinations = [
                            ['name' => 'Hà Giang (Loop)', 'icon' => 'fa-mountain', 'color' => 'text-teal-600'],
                            ['name' => 'Sa Pa', 'icon' => 'fa-person-hiking', 'color' => 'text-emerald-600'],
                            ['name' => 'Ninh Bình (Tràng An)', 'icon' => 'fa-water', 'color' => 'text-cyan-600'],
                            ['name' => 'Cát Bà / Vịnh Lan Hạ', 'icon' => 'fa-ship', 'color' => 'text-blue-600'],
                            ['name' => 'Vịnh Hạ Long', 'icon' => 'fa-anchor', 'color' => 'text-indigo-600'],
                            ['name' => 'Tà Xùa (Săn Mây)', 'icon' => 'fa-cloud', 'color' => 'text-purple-600'],
                            ['name' => 'Hà Nội (Phố Cổ)', 'icon' => 'fa-city', 'color' => 'text-amber-600'],
                            ['name' => 'Hội An', 'icon' => 'fa-lightbulb', 'color' => 'text-orange-500'],
                            ['name' => 'Đà Nẵng', 'icon' => 'fa-umbrella-beach', 'color' => 'text-yellow-600'],
                            ['name' => 'Huế Cố Đô', 'icon' => 'fa-landmark', 'color' => 'text-red-500'],
                            ['name' => 'Cao Bằng (Bản Giốc)', 'icon' => 'fa-gem', 'color' => 'text-teal-500'],
                            ['name' => 'Mai Châu / Mộc Châu', 'icon' => 'fa-seedling', 'color' => 'text-green-600'],
                        ];
                    @endphp

                    @foreach($presetDestinations as $dest)
                    <label class="relative flex items-center gap-2.5 p-3 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/40 cursor-pointer transition select-none group has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <input type="checkbox" name="destinations[]" value="{{ $dest['name'] }}" class="rounded text-[#26786e] focus:ring-[#26786e] w-4 h-4 border-gray-300">
                        <i class="fa-solid {{ $dest['icon'] }} {{ $dest['color'] }} text-xs group-hover:scale-110 transition"></i>
                        <span class="text-xs font-semibold text-gray-800">{{ $dest['name'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 4: LODGING & ACCOMMODATION -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">4</span>
                    <h3 class="text-base font-bold text-gray-900">Tiêu chuẩn chỗ ở</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-house-chimney text-emerald-600 text-lg"></i>
                            <input type="radio" name="accommodation" value="Homestay bản địa" checked class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">Homestay Bản Địa</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Ấm cúng, trải nghiệm văn hóa địa phương gần gũi</span>
                    </label>

                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-hotel text-blue-600 text-lg"></i>
                            <input type="radio" name="accommodation" value="Khách sạn 3 sao tiện nghi" class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">Khách sạn 3 Sao</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Phòng riêng tiện nghi, sạch đẹp, vị trí trung tâm</span>
                    </label>

                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-crown text-amber-500 text-lg"></i>
                            <input type="radio" name="accommodation" value="Resort & Khách sạn 4-5 sao" class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">Resort 4 - 5 Sao</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Sang trọng, cao cấp, bể bơi vô cực & dịch vụ VIP</span>
                    </label>

                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-ship text-teal-600 text-lg"></i>
                            <input type="radio" name="accommodation" value="Du thuyền cao cấp / Boutique Cruise" class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">Boutique Cruise</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Du thuyền nghỉ đêm trên Vịnh Lan Hạ / Hạ Long</span>
                    </label>
                </div>
            </div>

            <!-- SECTION 5: ACTIVITIES OF INTEREST -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">5</span>
                        <h3 class="text-base font-bold text-gray-900">Hoạt động trải nghiệm quan tâm</h3>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">Tùy chọn theo sở thích</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @php
                        $presetActivities = [
                            ['name' => 'Motorbike Tour (Easy Rider)', 'desc' => 'Tự lái hoặc có tài xế bản địa chở sau', 'icon' => 'fa-motorcycle', 'color' => 'text-orange-500'],
                            ['name' => 'Trekking & Hiking', 'desc' => 'Đi bộ qua ruộng bậc thang & núi đồi', 'icon' => 'fa-person-hiking', 'color' => 'text-emerald-500'],
                            ['name' => 'Boating & Kayak', 'desc' => 'Chèo kayak, đi thuyền kayak ngắm vịnh/hang động', 'icon' => 'fa-ship', 'color' => 'text-blue-500'],
                            ['name' => 'Street Food Tour', 'desc' => 'Thưởng thức ẩm thực đặc sản đường phố', 'icon' => 'fa-utensils', 'color' => 'text-red-500'],
                            ['name' => 'Văn hóa bản địa & Làng nghề', 'desc' => 'Dệt thổ cẩm, làm nón lá, thưởng trà', 'icon' => 'fa-landmark', 'color' => 'text-amber-500'],
                            ['name' => 'Nghỉ dưỡng & Chụp ảnh', 'desc' => 'Thư giãn, săn mây, check-in view đẹp', 'icon' => 'fa-camera', 'color' => 'text-purple-500'],
                        ];
                    @endphp

                    @foreach($presetActivities as $act)
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none group has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <input type="checkbox" name="activities[]" value="{{ $act['name'] }}" class="rounded text-[#26786e] focus:ring-[#26786e] w-4 h-4 border-gray-300 mt-0.5">
                        <div>
                            <div class="flex items-center gap-1.5 font-bold text-xs text-gray-900">
                                <i class="fa-solid {{ $act['icon'] }} {{ $act['color'] }} text-[11px]"></i>
                                <span>{{ $act['name'] }}</span>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-0.5 leading-tight">{{ $act['desc'] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 6: BUDGET ESTIMATE & SPECIAL NOTES -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Budget -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-700">
                        Mức ngân sách ước tính / người
                    </label>
                    <select name="budget" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition bg-white">
                        <option value="Tiết kiệm / Backpacking (&lt; $40 / ngày)">Tiết kiệm / Backpacking (&lt; $40 / ngày / người)</option>
                        <option value="Tiêu chuẩn linh hoạt ($50 - $90 / ngày)" selected>Tiêu chuẩn thoải mái ($50 - $90 / ngày / người)</option>
                        <option value="Cao cấp / Luxury (&gt; $100 / ngày)">Cao cấp & Riêng tư (&gt; $100 / ngày / người)</option>
                        <option value="Linh hoạt theo tư vấn của Chestnut Travel">Linh hoạt theo tư vấn lịch trình tốt nhất</option>
                    </select>
                    <p class="text-[11px] text-gray-400">Chestnut Travel cam kết giá trực tiếp từ đối tác bản địa, không qua trung gian.</p>
                </div>

                <!-- Special Requests -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-700">
                        Ghi chú & Yêu cầu đặc biệt
                    </label>
                    <textarea name="special_requests" rows="3"
                              placeholder="Lưu ý về ăn chay/dị ứng, có người lớn tuổi hoặc trẻ nhỏ, địa điểm nhất định muốn ghé thăm..."
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition resize-none"></textarea>
                </div>
            </div>

            <!-- SUBMIT BUTTON & DIRECT WHATSAPP -->
            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <i class="fa-solid fa-shield-halved text-[#26786e] text-base"></i>
                    <span>Thông tin của bạn được bảo mật tuyệt đối theo chính sách bảo vệ dữ liệu.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <!-- WhatsApp Direct -->
                    <a href="https://wa.me/84867216850?text={{ urlencode('Xin chào Chestnut Travel, tôi muốn tư vấn thiết kế tour riêng tại Việt Nam.') }}"
                       target="_blank" rel="noopener"
                       class="px-5 py-3 rounded-full border border-emerald-500 text-emerald-700 hover:bg-emerald-50 text-xs font-bold transition flex items-center justify-center gap-2 shrink-0">
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                        <span>Chat WhatsApp</span>
                    </a>

                    <!-- Submit Button -->
                    <button type="submit" id="submit-custom-tour-btn"
                            class="w-full sm:w-auto bg-[#26786e] hover:bg-[#1f625a] text-white px-8 py-3.5 rounded-full text-sm font-bold shadow-lg shadow-teal-900/20 transition transform active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                        <span>Gửi Yêu Cầu Thiết Kế Tour</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- WHY CHOOSE CHESTNUT TRAVEL FOR CUSTOMIZED TOURS -->
    <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-[#26786e] flex items-center justify-center shrink-0 text-xl font-bold">
                <i class="fa-solid fa-compass"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">Chuyên gia bản địa (Local Experts)</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Đội ngũ hướng dẫn viên sinh ra và lớn lên tại địa phương, am hiểu sâu sắc từng con đèo, bản làng.</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 text-xl font-bold">
                <i class="fa-solid fa-badge-percent"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">Cam kết giá tốt nhất (Best Price)</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Tối ưu chi phí theo ngân sách của bạn với chất lượng dịch vụ minh bạch, không phụ phí phát sinh ẩn.</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 text-xl font-bold">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">Hỗ trợ 24/7 (Always By Your Side)</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Nhân viên đồng hành hỗ trợ mọi phát sinh trên đường đi qua WhatsApp, hotline và trực tiếp tại điểm đón.</p>
            </div>
        </div>
    </div>
</div>
@endsection
