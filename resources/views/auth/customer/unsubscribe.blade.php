@php
    $settings = \App\Support\StoreSettings::get();
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إلغاء الاشتراك - {{ $settings->name ?? config('app.name', 'تيانيل') }}</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: #fff7f4;
            color: #4b213f;
            font-family: Tahoma, Arial, sans-serif;
        }

        .panel {
            width: min(92vw, 520px);
            padding: 34px 28px;
            border: 1px solid #ead3dc;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(75, 33, 63, .12);
            text-align: center;
        }

        h1 {
            margin: 0 0 14px;
            font-size: 26px;
        }

        p {
            margin: 0;
            color: #6b5261;
            line-height: 2;
        }

        a {
            display: inline-block;
            margin-top: 24px;
            color: #fff;
            background: #4b213f;
            text-decoration: none;
            border-radius: 999px;
            padding: 12px 22px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <main class="panel">
        <h1>تم إلغاء الاشتراك</h1>
        <p>لن تصلك الرسائل التسويقية من متجر {{ $settings->name ?? 'تيانيل' }} على هذا البريد.</p>
        <p>ستستمر رسائل الطلبات، الدفع، والشحن لأنها رسائل خدمة مهمة.</p>
        <a href="{{ url('/') }}">العودة للمتجر</a>
    </main>
</body>

</html>
