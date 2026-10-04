<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt tour thành công - Chestnut Travel</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F4F6F8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1E2329; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #F4F6F8; padding: 30px 10px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #E5E7EB;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #181C20; padding: 32px 30px; text-align: center; border-bottom: 3px solid #28B5A4;">
                            <div style="display: inline-block; background-color: rgba(40, 181, 164, 0.15); color: #28B5A4; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; padding: 4px 12px; rounded: 20px; border-radius: 20px; margin-bottom: 12px;">
                                CHESTNUT TRAVEL • XÁC NHẬN ĐẶT TOUR
                            </div>
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: 900; margin: 0 0 6px 0;">
                                ĐẶT TOUR THÀNH CÔNG!
                            </h1>
                            <p style="color: #9CA3AF; font-size: 13px; margin: 0;">
                                Mã đặt chỗ: <strong style="color: #E48E45; font-size: 15px; font-family: monospace;">#{{ $booking->booking_code }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 15px; margin-top: 0; color: #1E2329;">
                                Xin chào <strong>{{ $booking->customer_name }}</strong>,
                            </p>
                            <p style="font-size: 14px; color: #4B5563; margin-bottom: 24px;">
                                Cảm ơn bạn đã lựa chọn <strong>Chestnut Travel</strong>! Chúng tôi rất vinh hạnh được đồng hành cùng bạn trong chuyến đi khám phá cảnh sắc Việt Nam. Đơn đặt tour của bạn đã được ghi nhận thành công với các thông tin chi tiết dưới đây:
                            </p>

                            <!-- Tour Summary Card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #F9FAFB; border-radius: 16px; border: 1px solid #E5E7EB; margin-bottom: 24px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 12px; font-weight: 800; color: #28B5A4; text-transform: uppercase; margin-bottom: 4px;">
                                            Thông tin chuyến đi
                                        </div>
                                        <div style="font-size: 16px; font-weight: 900; color: #111827; margin-bottom: 14px;">
                                            {{ $booking->tour ? $booking->tour->title : 'Chuyến đi theo yêu cầu' }}
                                        </div>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="6" border="0" style="font-size: 13px; color: #374151;">
                                            <tr>
                                                <td width="38%" style="color: #6B7280; font-weight: 600;">Gói dịch vụ:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $booking->package_option ?? 'Tiêu chuẩn' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Ngày khởi hành:</td>
                                                <td style="color: #111827; font-weight: 700;">
                                                    {{ $booking->departure_date ? (is_string($booking->departure_date) ? $booking->departure_date : $booking->departure_date->format('d/m/Y')) : 'Chờ xác nhận' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Giờ khởi hành / đón:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $booking->departure_time ?? '07:30 AM' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Số lượng khách:</td>
                                                <td style="color: #111827; font-weight: 700;">
                                                    {{ $booking->adults }} Người lớn
                                                    @if($booking->children > 0)
                                                        , {{ $booking->children }} Trẻ em
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($booking->hotel_pickup)
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Điểm đón khách sạn:</td>
                                                <td style="color: #111827;">{{ $booking->hotel_pickup }}</td>
                                            </tr>
                                            @endif
                                            @if($booking->special_requests)
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Yêu cầu đặc biệt:</td>
                                                <td style="color: #111827; font-style: italic;">{{ $booking->special_requests }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Extra Services (if any) -->
                            @if(!empty($booking->extra_services) && is_array($booking->extra_services) && count($booking->extra_services) > 0)
                            <div style="margin-bottom: 24px;">
                                <div style="font-size: 13px; font-weight: 800; color: #111827; text-transform: uppercase; margin-bottom: 8px;">
                                    Dịch vụ cộng thêm đã chọn:
                                </div>
                                <table role="presentation" width="100%" cellspacing="0" cellpadding="8" border="0" style="background-color: #FFFDF9; border: 1px solid #FED7AA; border-radius: 12px; font-size: 13px;">
                                    @foreach($booking->extra_services as $addon)
                                    <tr>
                                        <td style="color: #1F2937; font-weight: 600;">
                                            • {{ $addon['name'] ?? 'Dịch vụ phụ trợ' }}
                                            @if(isset($addon['quantity']) && $addon['quantity'] > 1)
                                                <span style="color: #6B7280; font-weight: normal;">(x{{ $addon['quantity'] }})</span>
                                            @endif
                                        </td>
                                        <td align="right" style="color: #C2410C; font-weight: 800;">
                                            +${{ number_format($addon['subtotal'] ?? ($addon['unit_price'] ?? 0), 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            @endif

                            <!-- Payment Breakdown -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="10" border="0" style="background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; margin-bottom: 28px; font-size: 13px;">
                                <tr>
                                    <td style="color: #64748B;">Tổng giá trị chuyến đi:</td>
                                    <td align="right" style="color: #0F172A; font-weight: 800; font-size: 16px;">
                                        ${{ number_format($booking->total_price, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #64748B;">Phương thức thanh toán:</td>
                                    <td align="right" style="color: #0F172A; font-weight: 600;">
                                        {{ $booking->payment_method === 'credit_card' ? 'Thanh toán trực tuyến (Thẻ)' : 'Thanh toán khi đón tour' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #64748B;">Đã trả trước hôm nay:</td>
                                    <td align="right" style="color: #059669; font-weight: 800;">
                                        ${{ number_format($booking->deposit_amount, 2) }}
                                    </td>
                                </tr>
                                <tr style="border-top: 1px dashed #CBD5E1;">
                                    <td style="color: #64748B; font-weight: 700;">Còn lại thanh toán khi đón tour:</td>
                                    <td align="right" style="color: #DC2626; font-weight: 900; font-size: 15px;">
                                        ${{ number_format($booking->remaining_amount, 2) }}
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <a href="{{ route('booking.success', ['code' => $booking->booking_code]) }}" 
                                   style="display: inline-block; background-color: #28B5A4; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 800; padding: 14px 32px; border-radius: 14px; box-shadow: 0 4px 12px rgba(40, 181, 164, 0.35);">
                                    Xem chi tiết đơn &amp; Lịch trình tour &rarr;
                                </a>
                            </div>

                            <!-- Support info -->
                            <div style="border-top: 1px solid #E5E7EB; padding-top: 20px; font-size: 12px; color: #6B7280; line-height: 1.6;">
                                <p style="margin: 0 0 6px 0;">
                                    <strong>Cần thay đổi thông tin hoặc hỗ trợ gấp?</strong>
                                </p>
                                <p style="margin: 0;">
                                    📞 Hotline / WhatsApp: <a href="https://wa.me/84867216850" style="color: #28B5A4; text-decoration: none; font-weight: 700;">+84 867 216 850</a><br>
                                    ✉️ Email: <a href="mailto:info@chestnuttravel.net" style="color: #28B5A4; text-decoration: none; font-weight: 700;">info@chestnuttravel.net</a><br>
                                    📍 Văn phòng: Phố Cổ Hà Nội &amp; TP. Hà Giang
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F9FAFB; padding: 20px 30px; text-align: center; font-size: 11px; color: #9CA3AF; border-top: 1px solid #E5E7EB;">
                            © {{ date('Y') }} Chestnut Travel. All rights reserved.<br>
                            Email tự động gửi từ hệ thống đặt tour của Chestnut Travel.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
