<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng thành viên mới - Chestnut Travel</title>
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
                            <div style="display: inline-block; background-color: rgba(40, 181, 164, 0.15); color: #28B5A4; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; padding: 4px 12px; border-radius: 20px; margin-bottom: 12px;">
                                CHESTNUT TRAVEL • THÀNH VIÊN MỚI
                            </div>
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: 900; margin: 0 0 6px 0;">
                                CHÀO MỪNG BẠN GIA NHẬP!
                            </h1>
                            <p style="color: #9CA3AF; font-size: 13px; margin: 0;">
                                Khám phá vẻ đẹp Việt Nam cùng trải nghiệm bản địa đích thực
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 15px; margin-top: 0; color: #1E2329;">
                                Xin chào <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="font-size: 14px; color: #4B5563; margin-bottom: 24px;">
                                Chúc mừng bạn đã đăng ký tài khoản thành công tại <strong>Chestnut Travel</strong>! Chúng tôi rất vui mừng được chào đón bạn vào cộng đồng những người đam mê xê dịch và khám phá cảnh sắc Việt Nam.
                            </p>

                            <!-- Account Details Card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #F9FAFB; border-radius: 16px; border: 1px solid #E5E7EB; margin-bottom: 26px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 12px; font-weight: 800; color: #28B5A4; text-transform: uppercase; margin-bottom: 12px;">
                                            Thông tin tài khoản của bạn:
                                        </div>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="6" border="0" style="font-size: 13px; color: #374151;">
                                            <tr>
                                                <td width="35%" style="color: #6B7280; font-weight: 600;">Họ và tên:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Email đăng nhập:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $user->email }}</td>
                                            </tr>
                                            @if($user->phone)
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Số điện thoại:</td>
                                                <td style="color: #111827;">{{ $user->phone }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Thời gian đăng ký:</td>
                                                <td style="color: #111827;">{{ now()->format('H:i d/m/Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Features List -->
                            <div style="margin-bottom: 28px;">
                                <div style="font-size: 13px; font-weight: 800; color: #111827; margin-bottom: 10px;">
                                    Đặc quyền dành cho thành viên Chestnut Travel:
                                </div>
                                <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: #4B5563; line-height: 1.8;">
                                    <li>Tra cứu và theo dõi tình trạng các chuyến đi đã đặt mọi lúc mọi nơi.</li>
                                    <li>Lưu trữ danh sách tour yêu thích (Wishlist) để lên kế hoạch du lịch dễ dàng.</li>
                                    <li>Ưu tiên nhận thông tin các hành trình mới độc quyền (Hà Giang Loop, Sa Pa, Vịnh Lan Hạ...).</li>
                                    <li>Hỗ trợ 24/7 trực tiếp từ đội ngũ hướng dẫn viên và chuyên viên bản địa.</li>
                                </ul>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <a href="{{ route('my-account') }}" 
                                   style="display: inline-block; background-color: #28B5A4; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 800; padding: 14px 32px; border-radius: 14px; box-shadow: 0 4px 12px rgba(40, 181, 164, 0.35);">
                                    Truy cập trang cá nhân &rarr;
                                </a>
                            </div>

                            <!-- Support info -->
                            <div style="border-top: 1px solid #E5E7EB; padding-top: 20px; font-size: 12px; color: #6B7280; line-height: 1.6;">
                                <p style="margin: 0 0 6px 0;">
                                    <strong>Bạn cần tư vấn lên lịch trình chuyến đi?</strong>
                                </p>
                                <p style="margin: 0;">
                                    📞 Hotline / WhatsApp: <a href="https://wa.me/84867216850" style="color: #28B5A4; text-decoration: none; font-weight: 700;">+84 867 216 850</a><br>
                                    ✉️ Email: <a href="mailto:info@chestnuttravel.net" style="color: #28B5A4; text-decoration: none; font-weight: 700;">info@chestnuttravel.net</a>
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F9FAFB; padding: 20px 30px; text-align: center; font-size: 11px; color: #9CA3AF; border-top: 1px solid #E5E7EB;">
                            © {{ date('Y') }} Chestnut Travel. All rights reserved.<br>
                            Email tự động gửi từ hệ thống quản lý tài khoản của Chestnut Travel.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
