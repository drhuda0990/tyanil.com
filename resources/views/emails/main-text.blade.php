{{ $request['title'] ?? 'رسالة من تيانيل' }}

{{ $request['plain_body'] ?? \App\Support\EmailCompliance::plainText($request['body'] ?? '') }}

@if (!empty($request['unsubscribe_url']))
لإلغاء الاشتراك من الرسائل التسويقية:
{{ $request['unsubscribe_url'] }}

@endif
{{ \App\Support\StoreSettings::get()->name ?? config('app.name', 'تيانيل') }}
{{ \App\Support\StoreSettings::get()->website ?: url('/') }}
{{ \App\Support\StoreSettings::get()->email_1 ?: config('mail.from.address') }}
