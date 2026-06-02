<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Message from Our Website' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            padding: 30px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }

        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        {{ $request['body'] }}
    </div>

    <div class="email-footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة لدى.
    </div>
</body>

</html>
