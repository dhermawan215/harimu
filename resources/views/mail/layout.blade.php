<!DOCTYPE html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>Harimu Apps</title>
    <!--[if mso]>
    <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <style>
        /* Reset */
        html, body { margin: 0 !important; padding: 0 !important; width: 100% !important; height: 100% !important; }
        * { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; display: block; }
        a { text-decoration: none; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; }
        u + #body a { color: inherit; text-decoration: none; }

        /* Typography */
        body, td, p, a, li { font-family: 'Helvetica Neue', Helvetica, Arial, 'Segoe UI', sans-serif; }
        .h1 { margin: 0 0 12px; font-size: 26px; line-height: 34px; font-weight: 700; color: #2b2530; }
        .h2 { margin: 24px 0 8px; font-size: 18px; line-height: 26px; font-weight: 700; color: #2b2530; }
        .text { margin: 0 0 16px; font-size: 15px; line-height: 24px; color: #4a424d; }
        .muted { font-size: 13px; line-height: 20px; color: #7a7078; }
        .link { color: #b76e79; text-decoration: underline; word-break: break-all; }

        /* Components */
        .btn-cell { border-radius: 8px; background-color: #b76e79; }
        .btn { display: inline-block; padding: 14px 32px; font-size: 15px; line-height: 20px; font-weight: 700; color: #ffffff !important; text-decoration: none; border-radius: 8px; }
        .box { background-color: #faf5f2; border: 1px solid #efe4de; border-radius: 8px; }
        .code { font-family: 'Courier New', Courier, monospace; font-size: 28px; line-height: 36px; font-weight: 700; letter-spacing: 8px; color: #2b2530; }
        .divider { border-top: 1px solid #efe4de; font-size: 0; line-height: 0; height: 1px; }

        /* Responsive */
        @media screen and (max-width: 640px) {
            .container { width: 100% !important; }
            .px { padding-left: 24px !important; padding-right: 24px !important; }
            .h1 { font-size: 22px !important; line-height: 30px !important; }
            .btn { display: block !important; text-align: center !important; }
            .btn-cell { display: block !important; width: 100% !important; }
        }

        /* Dark mode */
        @media (prefers-color-scheme: dark) {
            .bg-page { background-color: #1b171d !important; }
            .bg-card { background-color: #26212a !important; }
            .h1, .h2, .code { color: #f5eef0 !important; }
            .text { color: #d6ccd2 !important; }
            .muted { color: #a79ca4 !important; }
            .link { color: #e2a1ab !important; }
            .box { background-color: #2f2933 !important; border-color: #3d3542 !important; }
            .divider { border-top-color: #3d3542 !important; }
        }
    </style>
</head>
<body id="body" class="bg-page" style="margin:0; padding:0; background-color:#f6f1ee; word-spacing:normal;">

    <!-- Preheader: teks pratinjau di inbox, tersembunyi di badan email -->
    <div style="display:none; font-size:1px; line-height:1px; max-height:0; max-width:0; opacity:0; overflow:hidden; mso-hide:all;">
        {{$preheader}}&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;&#847;&zwnj;&nbsp;
    </div>

    <table role="presentation" class="bg-page" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f6f1ee" style="background-color:#f6f1ee;">
        <tr>
            <td align="center" style="padding:32px 16px;">

                <!--[if mso]><table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" align="center"><tr><td><![endif]-->
                <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;">

                    <!-- Header / brand -->
                    <tr>
                        <td align="center" style="padding:0 0 24px;">
                            <a href="#" style="text-decoration:none;">
                                <img src="#" alt="#" height="40" style="height:40px; width:auto; margin:0 auto;">
                            </a>
                        </td>
                    </tr>

                    <!-- Card -->
                    <tr>
                        <td class="bg-card" bgcolor="#ffffff" style="background-color:#ffffff; border-radius:12px; overflow:hidden;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <!-- Accent bar -->
                                <tr>
                                    <td height="4" style="height:4px; font-size:0; line-height:0; background-color:#b76e79;">&nbsp;</td>
                                </tr>
                                <!-- Content -->
                                <tr>
                                    <td class="px" style="padding:40px 40px 32px;">
                                        @yield('mail_content')
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" class="px" style="padding:24px 40px 0;">
                            <p class="muted" style="margin:0 0 8px; font-size:13px; line-height:20px; color:#7a7078;">
                                
                            </p>
                            <p class="muted" style="margin:0 0 8px; font-size:13px; line-height:20px; color:#7a7078;">
                                Butuh bantuan? Hubungi kami <a href="mailto:support@nusainnotech.com" class="link" style="color:#b76e79;">support@nusainnotech.com</a>
                            </p>
                            <p class="muted" style="margin:0; font-size:12px; line-height:18px; color:#a39aa1;">
                                &copy; {{date('Y')}} - Harimu Apps | Product of HansSuite | All right reserved.
                            </p>
                        </td>
                    </tr>

                </table>
                <!--[if mso]></td></tr></table><![endif]-->

            </td>
        </tr>
    </table>
</body>
</html>
