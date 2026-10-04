@extends('layouts.app')

@section('title', 'Xác Nhận Đặt Tour & Thanh Toán - ' . $booking->booking_code . ' | Chestnut Travel')

@section('content')
@php
    $exchangeRate = 25400; // 1 USD = 25,400 VND
    $payableUsd = $booking->deposit_amount > 0 ? (float)$booking->deposit_amount : (float)$booking->total_price;
    $payableVnd = round($payableUsd * $exchangeRate);
    $bankName = option('site_bank_name', 'MB Bank (Ngân hàng Quân Đội)');
    $bankBin = option('site_bank_bin', 'MB');
    $accountNumber = option('site_bank_account', '0348788668');
    $accountName = option('site_bank_owner', 'CHESTNUT TRAVEL VN');
    $memo = $booking->booking_code;
    $customQr = option('site_bank_qr_image');
    $qrUrl = $customQr ? asset('storage/' . $customQr) : "https://img.vietqr.io/image/{$bankBin}-{$accountNumber}-compact2.png?amount={$payableVnd}&addInfo=" . urlencode($memo) . "&accountName=" . urlencode($accountName);
@endphp

<div class="py-12 bg-stone-100 min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        <!-- Header Status Banner -->
        <div class="bg-white rounded-3xl shadow-sm border border-stone-200 overflow-hidden mb-8">
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 border-b border-stone-100">
                <div class="flex items-center gap-4 text-center sm:text-left">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl shrink-0 shadow-inner">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 justify-center sm:justify-start">
                            @if($booking->booking_status === 'confirmed')
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    Đã xác nhận chính thức
                                </span>
                            @else
                                <span class="bg-amber-100 text-amber-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    Chờ quản trị viên duyệt đơn
                                </span>
                            @endif
                            <span class="text-xs text-stone-400">• {{ $booking->created_at->format('H:i d/m/Y') }}</span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-black text-gray-900 mt-1">Cảm ơn bạn, {{ $booking->customer_name }}!</h1>
                        <p class="text-xs text-gray-500 mt-0.5">Mã đơn đặt tour của bạn là <strong class="text-chestnut font-mono text-sm">{{ $booking->booking_code }}</strong></p>
                    </div>
                </div>

                <div class="text-center sm:text-right shrink-0">
                    <div class="text-[11px] font-bold uppercase text-gray-400">
                        {{ $booking->payment_method === 'vietqr' ? 'Số tiền chuyển khoản (100%)' : 'Số tiền thanh toán khi đón tour' }}
                    </div>
                    <div class="text-2xl sm:text-3xl font-black text-chestnut">${{ number_format($booking->total_price, 2) }}</div>
                    <div class="text-xs font-semibold text-emerald-600">~ {{ number_format($payableVnd) }} VNĐ</div>
                </div>
            </div>

            <!-- Notice based on payment status / method -->
            <div class="bg-stone-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-2 text-gray-600">
                    <i class="fa-solid fa-clock text-amber-500 text-sm"></i>
                    <span>
                        @if($booking->booking_status === 'confirmed')
                            Đơn đặt tour đã được Quản trị viên duyệt. Email thông báo vé tour đã được gửi tới <strong>{{ $booking->customer_email }}</strong>.
                        @else
                            Đơn tour đang chờ Quản trị viên duyệt. Sau khi quản trị viên xác nhận đơn, bạn sẽ nhận được <strong>Email thông báo đặt tour thành công</strong>.
                        @endif
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="window.print()" class="px-3 py-1.5 bg-white hover:bg-stone-100 text-gray-700 font-bold rounded-lg border border-stone-200 transition flex items-center gap-1.5 shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-print"></i> In đơn tour
                    </button>
                    <a href="{{ route('booking.lookup') }}?booking_code={{ $booking->booking_code }}&phone={{ $booking->customer_phone }}" class="px-3 py-1.5 bg-chestnut hover:bg-orange-600 text-white font-bold rounded-lg transition flex items-center gap-1.5 shadow-2xs">
                        <i class="fa-solid fa-magnifying-glass"></i> Tra cứu đơn
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT COLUMN: PAYMENT INSTRUCTIONS (7 Cols) -->
            <div class="lg:col-span-7 space-y-6">

                @if($booking->payment_method === 'vietqr')
                    <!-- VIETQR PAYMENT CARD -->
                    <div class="bg-white rounded-3xl shadow-sm border-2 border-orange-200 p-6 sm:p-7 relative overflow-hidden">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-ping"></span>
                                <h2 class="text-base font-black text-gray-900">Quét mã VietQR để thanh toán</h2>
                            </div>
                            <span class="bg-orange-100 text-orange-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase">
                                Chờ chuyển khoản
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 mt-3 leading-relaxed">
                            Mở ứng dụng ngân hàng bất kỳ, chọn tính năng <strong>Quét mã QR</strong> để chuyển tiền tức thì. Sau khi bạn chuyển khoản, Quản trị viên sẽ kiểm tra và xác nhận đơn của bạn.
                        </p>

                        <div class="mt-5 flex flex-col sm:flex-row gap-5 items-center bg-stone-50 p-4 rounded-2xl border border-stone-200">
                            <div class="bg-white p-2.5 rounded-xl border border-stone-200 shadow-xs shrink-0 text-center">
                                <img src="{{ $qrUrl }}" alt="VietQR Chestnut Travel" class="w-48 h-48 object-contain mx-auto rounded-lg">
                            </div>

                            <div class="flex-1 w-full space-y-2 text-xs">
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Ngân hàng thụ hưởng</span>
                                    <div class="font-extrabold text-gray-900">{{ $bankName }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Chủ tài khoản</span>
                                    <div class="font-extrabold text-gray-900 uppercase">{{ $accountName }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Số tài khoản</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-black text-chestnut text-sm">{{ $accountNumber }}</span>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $accountNumber }}'); alert('Đã sao chép số tài khoản!')" class="text-[10px] px-1.5 py-0.5 bg-stone-200 hover:bg-stone-300 rounded font-semibold text-stone-700">
                                            <i class="fa-regular fa-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Số tiền cần chuyển</span>
                                    <div class="font-black text-emerald-700 text-sm">{{ number_format($payableVnd) }} đ <span class="text-gray-400 text-xs font-normal">(${{ number_format($booking->total_price, 2) }})</span></div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Nội dung chuyển khoản (bắt buộc)</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-black text-amber-900 bg-amber-100 px-2 py-0.5 rounded text-xs">{{ $memo }}</span>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $memo }}'); alert('Đã sao chép mã chuyển khoản!')" class="text-[10px] px-1.5 py-0.5 bg-amber-200 hover:bg-amber-300 rounded font-semibold text-amber-900">
                                            <i class="fa-regular fa-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-xl text-[11px] text-amber-900 leading-relaxed">
                            <i class="fa-solid fa-circle-info text-amber-600 mr-1"></i>
                            <strong>Lưu ý:</strong> Sau khi nhận được chuyển khoản, Quản trị viên sẽ bấm xác nhận đơn hàng trong hệ thống. Ngay lúc đó, một email báo đặt tour thành công sẽ tự động gửi tới hòm thư của bạn!
                        </div>
                    </div>

                @elseif($booking->payment_method === 'pay_on_arrival' || $booking->payment_type === 'later')
                    <!-- PAY ON ARRIVAL CARD -->
                    <div class="bg-white rounded-3xl shadow-sm border-2 border-blue-200 p-6 sm:p-7">
                        <div class="flex items-center gap-3 pb-4 border-b border-stone-100">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                            <div>
                                <h2 class="text-base sm:text-lg font-black text-gray-900">Đặt Giữ Chỗ Thành Công - Thanh Toán Sau</h2>
                                <span class="text-[11px] text-blue-700 font-bold uppercase tracking-wider flex items-center gap-1.5 mt-0.5">
                                    <i class="fa-solid fa-clock"></i> Thanh toán khi đón tour (Pay on Arrival)
                                </span>
                            </div>
                        </div>

                        <div class="mt-5 bg-blue-50/70 border border-blue-200 rounded-2xl p-5 space-y-2.5 text-xs text-blue-950">
                            <div class="flex justify-between items-center py-1 border-b border-blue-100/80">
                                <span class="text-blue-700 font-medium">Hình thức thanh toán:</span>
                                <span class="font-extrabold uppercase bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-[10px]">Thanh toán khi đón tour</span>
                            </div>
                            <div class="flex justify-between items-center py-1 border-b border-blue-100/80">
                                <span class="text-blue-700 font-medium">Số tiền đã trả trước:</span>
                                <span class="font-bold text-gray-500">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-blue-700 font-medium">Số tiền thanh toán cho HDV khi đón:</span>
                                <span class="font-black text-chestnut text-sm sm:text-base">${{ number_format($booking->total_price, 2) }}</span>
                            </div>
                        </div>

                        <div class="mt-4 p-4 rounded-xl bg-stone-50 border border-stone-200 text-xs text-gray-600 leading-relaxed">
                            <p class="font-bold text-gray-800 mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i> Hướng dẫn thanh toán:
                            </p>
                            <p>Bạn không cần thanh toán ngay lúc này. Chỗ của bạn đã được đảm bảo 100%. Số tiền <strong>${{ number_format($booking->total_price, 2) }}</strong> sẽ được thanh toán cho trưởng đoàn / hướng dẫn viên của Chestnut Travel khi xe đón bạn tại khách sạn vào ngày khởi hành.</p>
                        </div>
                    </div>

                @else
                    <!-- VIETQR PAYMENT CARD (FALLBACK) -->
                    <div class="bg-white rounded-3xl shadow-sm border-2 border-orange-200 p-6 sm:p-7 relative overflow-hidden">
                        <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-ping"></span>
                                <h2 class="text-base font-black text-gray-900">Quét mã VietQR để thanh toán</h2>
                            </div>
                            <span class="bg-orange-100 text-orange-800 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase">
                                Chờ chuyển khoản
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 mt-3 leading-relaxed">
                            Mở ứng dụng ngân hàng bất kỳ, chọn tính năng <strong>Quét mã QR</strong> để chuyển tiền tức thì và giữ chỗ tour.
                        </p>

                        <div class="mt-5 flex flex-col sm:flex-row gap-5 items-center bg-stone-50 p-4 rounded-2xl border border-stone-200">
                            <div class="bg-white p-2.5 rounded-xl border border-stone-200 shadow-xs shrink-0 text-center">
                                <img src="{{ $qrUrl }}" alt="VietQR Chestnut Travel" class="w-44 h-44 object-contain mx-auto rounded-lg">
                            </div>

                            <div class="flex-1 w-full space-y-2 text-xs">
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Ngân hàng thụ hưởng</span>
                                    <div class="font-extrabold text-gray-900">{{ $bankName }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Chủ tài khoản</span>
                                    <div class="font-extrabold text-gray-900 uppercase">{{ $accountName }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Số tài khoản</span>
                                    <div class="font-mono font-black text-chestnut text-sm">{{ $accountNumber }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Số tiền (VNĐ)</span>
                                    <div class="font-black text-emerald-700 text-sm">{{ number_format($payableVnd) }} đ</div>
                                </div>
                                <div>
                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Nội dung chuyển khoản</span>
                                    <div class="font-mono font-black text-amber-900 bg-amber-100 px-2 py-0.5 rounded text-xs">{{ $memo }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- WhatsApp & Staff Assistance Card -->
                <div class="bg-gradient-to-br from-emerald-600 to-teal-800 rounded-3xl p-6 sm:p-7 text-white shadow-lg shadow-teal-900/10">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-2xl shrink-0">
                            <i class="fa-brands fa-whatsapp text-emerald-300"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-extrabold text-white">Cần hỗ trợ hoặc gửi ủy nhiệm chi?</h3>
                            <p class="text-xs text-emerald-100 mt-1 leading-relaxed">
                                Đội ngũ chuyên gia du lịch Chestnut Travel trực 24/7. Nhắn ngay cho chúng tôi qua WhatsApp để xác nhận chuyến đi nhanh nhất!
                            </p>
                            <a href="{{ option('site_whatsapp_link', 'https://wa.me/' . preg_replace('/[^0-9]/', '', option('site_whatsapp', '84867216850'))) }}?text={{ urlencode('Xin chào Chestnut Travel! Tôi đã đặt tour mã ' . $booking->booking_code . ' cho tour ' . ($booking->tour->title ?? 'Hà Giang') . ' ngày ' . ($booking->departure_date ? $booking->departure_date->format('d/m/Y') : '') . '. Nhờ anh/chị kiểm tra và xác nhận giúp tôi nhé.') }}" 
                               target="_blank" 
                               rel="noopener" 
                               class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-white hover:bg-emerald-50 text-emerald-800 font-bold rounded-xl text-xs transition shadow-md">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                                <span>Nhắn WhatsApp ngay ({{ option('site_whatsapp', option('site_hotline', '+84 867 216 850')) }})</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: DETAILED TOUR RECEIPT / INVOICE (5 Cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-stone-200 p-6 sm:p-7">
                    <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                        <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider">Chi Tiết Đơn Đặt Tour</h3>
                        <span class="text-[10px] font-mono text-gray-400 font-bold">#{{ $booking->booking_code }}</span>
                    </div>

                    <div class="mt-4 space-y-3.5 text-xs">
                        <!-- Tour Title -->
                        <div>
                            <span class="text-gray-400 text-[10px] uppercase font-bold block">Tên hành trình</span>
                            <div class="font-extrabold text-gray-900 text-sm mt-0.5 leading-snug">
                                @if($booking->booking_type === 'customized_tour')
                                    Tour Thiết Kế Riêng Theo Yêu Cầu (Customized Tour)
                                @else
                                    {{ $booking->tour->title ?? 'Hành trình khám phá' }}
                                @endif
                            </div>
                        </div>

                        <!-- Package Option -->
                        @if($booking->package_option)
                            <div class="bg-orange-50/80 border border-orange-200/80 rounded-xl p-2.5">
                                <span class="text-gray-500 text-[10px] uppercase font-bold block">Gói dịch vụ đã chọn</span>
                                <div class="font-bold text-chestnut text-xs mt-0.5">{{ $booking->package_option }}</div>
                            </div>
                        @endif

                        <!-- Schedule & Departure -->
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <div>
                                <span class="text-gray-400 text-[10px] uppercase font-bold block">Ngày khởi hành</span>
                                <div class="font-bold text-gray-900 mt-0.5">
                                    {{ $booking->departure_date ? $booking->departure_date->format('d/m/Y') : 'Linh hoạt' }}
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-400 text-[10px] uppercase font-bold block">Giờ đón dự kiến</span>
                                <div class="font-bold text-gray-900 mt-0.5">
                                    {{ $booking->departure_time ?? '07:30 AM' }}
                                </div>
                            </div>
                        </div>

                        <!-- Guests -->
                        <div>
                            <span class="text-gray-400 text-[10px] uppercase font-bold block">Số lượng du khách</span>
                            <div class="font-bold text-gray-900 mt-0.5">
                                {{ $booking->adults }} Người lớn
                                @if($booking->children > 0)
                                    + {{ $booking->children }} Trẻ em
                                @endif
                            </div>
                        </div>

                        <!-- Extra Services Selected -->
                        @if(!empty($booking->extra_services) && is_array($booking->extra_services))
                            <div class="pt-2 border-t border-stone-100">
                                <span class="text-gray-400 text-[10px] uppercase font-bold block mb-1.5">Dịch vụ cộng thêm</span>
                                <div class="space-y-1.5">
                                    @foreach($booking->extra_services as $addon)
                                        <div class="flex items-center justify-between bg-stone-50 px-2.5 py-1.5 rounded-lg text-[11px]">
                                            <span class="text-gray-700 font-medium">
                                                <i class="fa-solid fa-circle-check text-emerald-500 text-[9px] mr-1"></i>
                                                {{ $addon['name'] ?? 'Dịch vụ' }}
                                                @if(!empty($addon['quantity']) && $addon['quantity'] > 1)
                                                    <span class="text-stone-400 font-bold">(x{{ $addon['quantity'] }})</span>
                                                @endif
                                            </span>
                                            <span class="font-bold text-gray-900">+${{ number_format($addon['subtotal'] ?? 0, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Pickup & Contact -->
                        <div class="pt-2 border-t border-stone-100 space-y-2">
                            <div>
                                <span class="text-gray-400 text-[10px] uppercase font-bold block">Điểm đón khách</span>
                                <div class="font-bold text-gray-900 mt-0.5">
                                    {{ $booking->hotel_pickup ?: 'Đón tại văn phòng Chestnut Travel hoặc cập nhật sau' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <span class="text-gray-400 text-[10px] uppercase font-bold block">Số điện thoại</span>
                                    <div class="font-bold text-gray-900 mt-0.5">{{ $booking->customer_phone }}</div>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[10px] uppercase font-bold block">Email</span>
                                    <div class="font-bold text-gray-900 mt-0.5 truncate">{{ $booking->customer_email }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="pt-3 border-t border-stone-200 space-y-2 text-xs">
                            <div class="flex justify-between text-gray-600">
                                <span>Tổng tiền dịch vụ trọn gói:</span>
                                <span class="font-bold text-gray-900">${{ number_format($booking->total_price, 2) }}</span>
                            </div>

                            @if($booking->deposit_amount > 0 && $booking->deposit_amount < $booking->total_price)
                                <div class="flex justify-between text-emerald-700 font-bold bg-emerald-50 p-2 rounded-xl border border-emerald-100">
                                    <span>Đặt cọc giữ chỗ (30%):</span>
                                    <span>${{ number_format($booking->deposit_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-stone-600 text-[11px] px-1">
                                    <span>Còn lại thanh toán khi đón tour:</span>
                                    <span class="font-bold">${{ number_format($booking->remaining_amount, 2) }}</span>
                                </div>
                            @else
                                <div class="flex justify-between font-black text-gray-900 text-sm pt-1">
                                    <span>Thanh toán trọn gói 100%:</span>
                                    <span class="text-chestnut text-base">${{ number_format($booking->total_price, 2) }}</span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- Back to Homepage -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-chestnut transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Quay lại trang chủ Chestnut Travel</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function copyToClipboard(text, btnElement) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showCopiedFeedback(btnElement);
            });
        } else {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showCopiedFeedback(btnElement);
        }
    }

    function showCopiedFeedback(btnElement) {
        const originalHtml = btnElement.innerHTML;
        btnElement.innerHTML = '<i class="fa-solid fa-check text-emerald-600"></i> Đã sao chép!';
        btnElement.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
        setTimeout(() => {
            btnElement.innerHTML = originalHtml;
            btnElement.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
        }, 2000);
    }

    function markTransferred(btn) {
        btn.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-300"></i> Đã ghi nhận! Đang kiểm tra giao dịch...';
        btn.classList.add('bg-emerald-700');
        btn.disabled = true;

        setTimeout(() => {
            alert('Cảm ơn bạn! Hệ thống đã ghi nhận thông báo chuyển khoản của bạn. Bộ phận điều hành của Chestnut Travel sẽ xác nhận giao dịch trong vòng ít phút!');
        }, 500);
    }
</script>
@endsection
