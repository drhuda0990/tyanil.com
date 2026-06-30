@php
    $settings = \App\Support\StoreSettings::get();
    $logo = $settings->logo2 ?: $settings->logo;
    $logoUrl = $logo ? asset('storage/' . $logo) : null;
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $request['title'] ?? config('app.name', 'تيانيل') }}</title>
</head>

<body style="margin:0;padding:0;background:#fff7f4;color:#4b213f;font-family:Tahoma,Arial,sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#fff7f4;padding:28px 14px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                    style="max-width:640px;background:#ffffff;border:1px solid #ead3dc;border-radius:18px;overflow:hidden;box-shadow:0 18px 45px rgba(75,33,63,.12);">
                    <tr>
                        <td align="center" style="background:#4b213f;padding:28px 24px 22px;">
                            @if ($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $settings->name }}" style="max-width:170px;height:auto;display:block;margin:0 auto 12px;">
                            @endif
                            <div style="font-size:22px;line-height:1.7;font-weight:700;color:#fff4ef;">
                                {{ $request['title'] ?? 'رسالة من تيانيل' }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px 28px;font-size:16px;line-height:2;color:#5d4052;">
                            {!! $request['body'] !!}
                            @if (!empty($request['unsubscribe_url']))
                                <div style="margin-top:26px;padding-top:18px;border-top:1px solid #ead3dc;color:#8a7281;font-size:13px;line-height:1.8;text-align:center;">
                                    وصلتك هذه الرسالة لأنك مشتركة في تحديثات متجر تيانيل.
                                    <a href="{{ $request['unsubscribe_url'] }}" style="color:#4b213f;text-decoration:underline;">إلغاء الاشتراك من الرسائل التسويقية</a>
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px;background:#fff4ef;color:#7b6574;font-size:13px;line-height:1.8;text-align:center;">
                            <div>{{ $settings->name ?? config('app.name', 'تيانيل') }} - أنت تستحقين الأجمل</div>
                            <div>
                                <a href="{{ $settings->website ?: url('/') }}" style="color:#4b213f;text-decoration:none;">{{ $settings->website ?: url('/') }}</a>
                                @if ($settings->email_1)
                                    <span style="color:#d989a3;"> | </span>
                                    <a href="mailto:{{ $settings->email_1 }}" style="color:#4b213f;text-decoration:none;">{{ $settings->email_1 }}</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="font-size:12px;color:#9a8291;margin-top:16px;">
                    &copy; {{ date('Y') }} {{ $settings->name ?? config('app.name', 'تيانيل') }}. جميع الحقوق محفوظة.
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
