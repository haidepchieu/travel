<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo đăng nhập tài khoản - Chestnut Travel</title>
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
                                CHESTNUT TRAVEL • BẢO MẬT TÀI KHOẢN
                            </div>
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: 900; margin: 0 0 6px 0;">
                                ĐĂNG NHẬP THÀNH CÔNG
                            </h1>
                            <p style="color: #9CA3AF; font-size: 13px; margin: 0;">
                                Thông báo bảo mật tài khoản người dùng
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
                                Tài khoản Chestnut Travel của bạn vừa được đăng nhập thành công vào hệ thống. Để đảm bảo an toàn cho tài khoản, chúng tôi gửi cho bạn thông tin chi tiết về phiên đăng nhập này:
                            </p>

                            <!-- Login Info Card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #F9FAFB; border-radius: 16px; border: 1px solid #E5E7EB; margin-bottom: 24px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 12px; font-weight: 800; color: #28B5A4; text-transform: uppercase; margin-bottom: 12px;">
                                            Chi tiết phiên đăng nhập:
                                        </div>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="6" border="0" style="font-size: 13px; color: #374151;">
                                            <tr>
                                                <td width="35%" style="color: #6B7280; font-weight: 600;">Tài khoản email:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Thời gian:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $loginTime }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Địa chỉ IP:</td>
                                                <td style="color: #111827; font-family: monospace; font-weight: 600;">{{ $ip }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Trình duyệt / Thiết bị:</td>
                                                <td style="color: #111827; font-size: 12px;">{{ Str::limit($userAgent, 80) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Warning -->
                            <div style="background-color: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 14px; padding: 16px 20px; margin-bottom: 26px;">
                                <p style="margin: 0; font-size: 13px; color: #1E40AF; line-height: 1.6;">
                                    <strong>Lưu ý bảo mật:</strong> Nếu chính bạn là người vừa thực hiện đăng nhập này, bạn hoàn toàn có thể yên tâm bỏ qua email này.<br><br>
                                    Nếu <strong>KHÔNG PHẢI BẠN</strong>, hãy đổi mật khẩu tài khoản ngay lập tức hoặc liên hệ ngay với chúng tôi qua hotline <strong style="color: #1E3A8A;">+84 867 216 850</strong> để được hỗ trợ bảo vệ tài khoản kịp thời.
                                </p>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <a href="{{ route('my-account') }}" 
                                   style="display: inline-block; background-color: #28B5A4; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 800; padding: 14px 32px; border-radius: 14px; box-shadow: 0 4px 12px rgba(40, 181, 164, 0.35);">
                                    Quản lý tài khoản của bạn &rarr;
                                </a>
                            </div>

                            <!-- Support info -->
                            <div style="border-top: 1px solid #E5E7EB; padding-top: 20px; font-size: 12px; color: #6B7280; line-height: 1.6;">
                                <p style="margin: 0;">
                                    📞 Hotline hỗ trợ bảo mật: <a href="tel:+84867216850" style="color: #28B5A4; text-decoration: none; font-weight: 700;">+84 867 216 850</a><br>
                                    ✉️ Email: <a href="mailto:info@chestnuttravel.net" style="color: #28B5A4; text-decoration: none; font-weight: 700;">info@chestnuttravel.net</a>
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #F9FAFB; padding: 20px 30px; text-align: center; font-size: 11px; color: #9CA3AF; border-top: 1px solid #E5E7EB;">
                            © {{ date('Y') }} Chestnut Travel. All rights reserved.<br>
                            Email tự động gửi vì lý do bảo mật tài khoản.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
