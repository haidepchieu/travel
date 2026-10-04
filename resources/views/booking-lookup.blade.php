@extends('layouts.app')

@section('title', 'Tra Cứu Đơn Đặt Tour | Chestnut Travel')
@section('meta_description', 'Kiểm tra trạng thái đơn đặt tour và chi tiết chuyến đi của bạn tại Chestnut Travel.')

@section('content')
<div class="py-16 bg-gray-50 min-h-[70vh]">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-orange-100 text-chestnut mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Tra Cứu Đơn Đặt Tour</h1>
            <p class="text-xs text-gray-500 mt-1">Dành cho Khách vãng lai và Thành viên kiểm tra trạng thái hành trình</p>
        </div>

        <!-- Lookup Form -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-6 sm:p-8 mb-8">
            <form action="{{ route('booking.lookup') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mã đơn đặt tour (Booking Code) *</label>
                    <input type="text" name="booking_code" required value="{{ request('booking_code') }}" placeholder="VD: CNT-HG889 hoặc CNT-XXXXXX" class="w-full px-4 py-3 border border-gray-300 rounded-xl text-xs uppercase font-mono font-bold focus:outline-none focus:border-chestnut transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email đăng ký</label>
                        <input type="email" name="email" value="{{ request('email') }}" placeholder="email@example.com" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Hoặc Số điện thoại</label>
                        <input type="tel" name="phone" value="{{ request('phone') }}" placeholder="0987654321" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                    </div>
                </div>

                <button type="submit" class="w-full bg-chestnut hover:bg-orange-600 text-white font-bold py-3 rounded-xl text-xs shadow-md shadow-orange-500/25 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-search"></i>
                    <span>TRA CỨU NGAY</span>
                </button>
            </form>
        </div>

        <!-- Lookup Results -->
        @if($searched)
            @if($booking)
                <div class="bg-white rounded-3xl shadow-md border border-gray-200 overflow-hidden animate-fadeIn">
                    <div class="bg-gradient-to-r from-[#181C20] to-[#2B313A] text-white p-6 flex flex-wrap justify-between items-center gap-4">
                        <div>
                            <span class="text-[10px] text-gray-400 uppercase font-semibold block">MÃ ĐƠN HÀNG</span>
                            <span class="text-xl font-mono font-extrabold text-amber-400">{{ $booking->booking_code }}</span>
                        </div>
                        <div>
                            @if($booking->booking_status === 'confirmed')
                                <span class="bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fa-solid fa-circle-check"></i> ĐÃ XÁC NHẬN
                                </span>
                            @elseif($booking->booking_status === 'cancelled')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fa-solid fa-circle-xmark"></i> ĐÃ HỦY
                                </span>
                            @else
                                <span class="bg-amber-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    <i class="fa-regular fa-clock"></i> ĐANG CHỜ XÁC NHẬN
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 space-y-4 text-xs">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-500 font-medium">Tên Tour:</span>
                            <span class="font-bold text-gray-900 text-right">{{ $booking->tour->title ?? 'Tour du lịch' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-500 font-medium">Khách hàng:</span>
                            <span class="font-bold text-gray-900">{{ $booking->customer_name }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-500 font-medium">Ngày khởi hành:</span>
                            <span class="font-bold text-gray-900">{{ $booking->departure_date->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-500 font-medium">Số lượng khách:</span>
                            <span class="font-bold text-gray-900">{{ $booking->adults }} Người lớn {{ $booking->children ? '+ ' . $booking->children . ' Trẻ em' : '' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <span class="text-gray-500 font-medium">Tổng chi phí:</span>
                            <span class="text-base font-extrabold text-chestnut">${{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-medium">Tình trạng thanh toán:</span>
                            <span class="font-bold capitalize text-gray-700">{{ $booking->payment_status === 'paid' ? 'Đã thanh toán đủ' : 'Chưa thanh toán' }}</span>
                        </div>

                        @if($booking->special_requests)
                            <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                <span class="text-[11px] font-bold text-gray-500 block mb-1">Ghi chú yêu cầu đặc biệt:</span>
                                <p class="text-gray-700 italic">{{ $booking->special_requests }}</p>
                            </div>
                        @endif

                        <div class="pt-4 flex gap-3">
                            <a href="{{ option('site_whatsapp_link', 'https://wa.me/' . preg_replace('/[^0-9]/', '', option('site_whatsapp', '84867216850'))) }}?text={{ urlencode('Xin chào! Tôi muốn hỏi về đơn đặt tour: ' . $booking->booking_code) }}" target="_blank" rel="noopener" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl text-center transition flex items-center justify-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>Liên hệ hỗ trợ</span>
                            </a>
                            <a href="{{ route('home') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-center transition">
                                Về trang chủ
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-red-50 text-red-700 border border-red-200 rounded-2xl p-6 text-center text-xs animate-fadeIn">
                    <i class="fa-solid fa-triangle-exclamation text-2xl text-red-500 mb-2"></i>
                    <h4 class="font-bold text-sm text-red-900">Không tìm thấy đơn đặt tour</h4>
                    <p class="mt-1">Vui lòng kiểm tra lại Mã đơn (bắt đầu bằng CNT-) và Email/SĐT đã cung cấp khi đặt tour.</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
