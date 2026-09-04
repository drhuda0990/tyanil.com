@php
    $settings = \App\Support\StoreSettings::get();
    $storeName = $settings->name ?? config('app.name', 'تيانيل');
    $registrationNumber = $settings->business_register_number ?: $settings->commercial_register;
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>

<body style="margin:0;padding:0;background:#fff7f4;color:#4b213f;font-family:Tahoma,Arial,sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#fff7f4;padding:28px 14px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                    style="max-width:640px;background:#ffffff;border:1px solid #ead3dc;border-radius:18px;overflow:hidden;box-shadow:0 18px 45px rgba(75,33,63,.12);">
                    <tr>
                        <td align="center" style="background:#4b213f;padding:28px 24px 22px;">
                            <div style="font-size:30px;line-height:1.5;font-weight:700;color:#ffffff;">{{ $storeName }}</div>
                            <div style="font-size:22px;line-height:1.7;font-weight:700;color:#fff4ef;">{{ $title }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px 28px;font-size:16px;line-height:2;color:#5d4052;">
                            {!! $body !!}
                            @if (!empty($actionUrl))
                                <div style="text-align:center;margin-top:28px;">
                                    <a href="{{ $actionUrl }}"
                                        style="display:inline-block;background:#d989a3;color:#ffffff;text-decoration:none;border-radius:999px;padding:13px 28px;font-weight:700;">
                                        {{ $actionText ?? 'متابعة' }}
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px;background:#fff4ef;color:#7b6574;font-size:13px;line-height:1.8;text-align:center;">
                            <div>{{ $storeName }} - أنت تستحقين الأجمل</div>
                            @if ($settings->address)
                                <div>{{ $settings->address }}</div>
                            @endif
                            @if ($registrationNumber)
                                <div>الرقم الموحد للمنشأة: {{ $registrationNumber }}</div>
                            @endif
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
            </td>
        </tr>
    </table>
</body>

</html>
