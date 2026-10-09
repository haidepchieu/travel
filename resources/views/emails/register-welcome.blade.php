<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, new member - Chestnut Travel</title>
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
                                CHESTNUT TRAVEL • NEW MEMBER
                            </div>
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: 900; margin: 0 0 6px 0;">
                                WELCOME ABOARD!
                            </h1>
                            <p style="color: #9CA3AF; font-size: 13px; margin: 0;">
                                Discover the beauty of Vietnam through authentic local experiences
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 15px; margin-top: 0; color: #1E2329;">
                                Hello <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="font-size: 14px; color: #4B5563; margin-bottom: 24px;">
                                Congratulations on creating your <strong>Chestnut Travel</strong> account! We are thrilled to welcome you to our community of travelers passionate about exploring Vietnam.
                            </p>

                            <!-- Account Details Card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #F9FAFB; border-radius: 16px; border: 1px solid #E5E7EB; margin-bottom: 26px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 12px; font-weight: 800; color: #28B5A4; text-transform: uppercase; margin-bottom: 12px;">
                                            Your account details:
                                        </div>

                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="6" border="0" style="font-size: 13px; color: #374151;">
                                            <tr>
                                                <td width="35%" style="color: #6B7280; font-weight: 600;">Full name:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Sign-in email:</td>
                                                <td style="color: #111827; font-weight: 700;">{{ $user->email }}</td>
                                            </tr>
                                            @if($user->phone)
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Phone number:</td>
                                                <td style="color: #111827;">{{ $user->phone }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="color: #6B7280; font-weight: 600;">Registered at:</td>
                                                <td style="color: #111827;">{{ now()->format('H:i d/m/Y') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Features List -->
                            <div style="margin-bottom: 28px;">
                                <div style="font-size: 13px; font-weight: 800; color: #111827; margin-bottom: 10px;">
                                    Chestnut Travel member benefits:
                                </div>
                                <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: #4B5563; line-height: 1.8;">
                                    <li>Look up and track the status of your bookings anytime, anywhere.</li>
                                    <li>Save your favorite tours to a wishlist for easy trip planning.</li>
                                    <li>Be the first to hear about exclusive new journeys (Ha Giang Loop, Sa Pa, Lan Ha Bay...).</li>
                                    <li>24/7 support directly from our local guides and travel specialists.</li>
                                </ul>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <a href="{{ route('my-account') }}" 
                                   style="display: inline-block; background-color: #28B5A4; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 800; padding: 14px 32px; border-radius: 14px; box-shadow: 0 4px 12px rgba(40, 181, 164, 0.35);">
                                    Go to my account &rarr;
                                </a>
                            </div>

                            <!-- Support info -->
                            <div style="border-top: 1px solid #E5E7EB; padding-top: 20px; font-size: 12px; color: #6B7280; line-height: 1.6;">
                                <p style="margin: 0 0 6px 0;">
                                    <strong>Need help planning your itinerary?</strong>
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
                            This is an automated email from Chestnut Travel's account system.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
