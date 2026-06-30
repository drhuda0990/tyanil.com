{{ $title }}

{{ \App\Support\EmailCompliance::plainText($body ?? '') }}

@if (!empty($actionUrl))
{{ $actionText ?? 'متابعة' }}:
{{ $actionUrl }}

@endif
{{ \App\Support\StoreSettings::get()->name ?? config('app.name', 'تيانيل') }}
{{ \App\Support\StoreSettings::get()->website ?: url('/') }}
{{ \App\Support\StoreSettings::get()->email_1 ?: config('mail.from.address') }}
