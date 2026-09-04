{{ $title }}

{{ \App\Support\EmailCompliance::plainText($body ?? '') }}

@if (!empty($actionUrl))
{{ $actionText ?? 'متابعة' }}:
{{ $actionUrl }}

@endif
@php
    $settings = \App\Support\StoreSettings::get();
    $registrationNumber = $settings->business_register_number ?: $settings->commercial_register;
@endphp
{{ $settings->name ?? config('app.name', 'تيانيل') }} - أنت تستحقين الأجمل
{{ $settings->address }}
@if ($registrationNumber)
الرقم الموحد للمنشأة: {{ $registrationNumber }}
@endif
{{ $settings->website ?: url('/') }}
{{ $settings->email_1 ?: config('mail.from.address') }}
