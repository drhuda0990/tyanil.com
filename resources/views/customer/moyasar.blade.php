@extends('layouts.app')
@section('title', 'الدفع الإلكتروني')
@section('meta_title', 'الدفع الإلكتروني | تيانيل')
@section('meta_description', 'إتمام الدفع الآمن في متجر تيانيل عبر مدى، فيزا، ماستركارد وApple Pay.')

@section('SCSS')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.2.9/dist/moyasar.css">
    <style>
        .ty-payment-page {
            min-height: 70vh;
            padding: 140px 0 90px;
            background:
                radial-gradient(circle at 18% 18%, rgba(217, 137, 163, 0.18), transparent 28%),
                radial-gradient(circle at 82% 12%, rgba(180, 145, 93, 0.15), transparent 32%),
                linear-gradient(145deg, #fff8f5 0%, #fff1f6 45%, #fffaf6 100%);
        }

        .ty-payment-shell {
            display: grid;
            grid-template-columns: minmax(260px, 0.85fr) minmax(300px, 1.15fr);
            gap: 28px;
            align-items: start;
        }

        .ty-payment-summary,
        .ty-payment-form {
            border: 1px solid rgba(75, 33, 63, 0.16);
            background: rgba(255, 255, 255, 0.74);
            box-shadow: 0 28px 80px rgba(75, 33, 63, 0.13);
            backdrop-filter: blur(18px);
            border-radius: 22px;
            padding: 28px;
        }

        .ty-payment-summary__brand {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 26px;
        }

        .ty-payment-summary__brand img {
            width: 86px;
            height: 86px;
            object-fit: contain;
            border-radius: 18px;
            background: #fff;
            border: 1px solid rgba(217, 137, 163, 0.28);
            padding: 8px;
        }

        .ty-payment-summary h1 {
            color: #4b213f;
            font-size: clamp(28px, 4vw, 44px);
            margin: 0;
            line-height: 1.35;
        }

        .ty-payment-summary p {
            color: #7d6272;
            font-size: 17px;
            line-height: 1.9;
            margin: 0 0 24px;
        }

        .ty-payment-amount {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            border-radius: 18px;
            padding: 18px 20px;
            color: #fff;
            background: linear-gradient(135deg, #4b213f, #7e365a);
        }

        .ty-payment-amount span {
            color: rgba(255, 255, 255, 0.78);
            font-size: 15px;
        }

        .ty-payment-amount strong {
            font-size: 28px;
            letter-spacing: 0;
        }

        .ty-payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .ty-payment-methods span,
        .ty-payment-alert {
            border-radius: 999px;
            border: 1px solid rgba(217, 137, 163, 0.3);
            background: rgba(255, 255, 255, 0.72);
            color: #4b213f;
            padding: 10px 14px;
            font-weight: 700;
        }

        .ty-payment-alert {
            border-radius: 18px;
            color: #6f284e;
            line-height: 1.9;
            margin-bottom: 18px;
        }

        .ty-payment-form .mysr-form,
        .ty-payment-form #mysr {
            direction: ltr;
        }

        .ty-payment-form [class*="mysr"] {
            font-family: inherit;
        }

        @media (max-width: 991px) {
            .ty-payment-page {
                padding: 110px 0 70px;
            }

            .ty-payment-shell {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <section class="ty-payment-page rtlDirection">
        <div class="container">
            <div class="ty-payment-shell">
                <aside class="ty-payment-summary">
                    <div class="ty-payment-summary__brand">
                        <img src="{{ asset('storage/' . ($gSetting->logo2 ?: $gSetting->logo)) }}" alt="{{ $gSetting->name }}">
                        <h1>إتمام الدفع</h1>
                    </div>
                    <p>
                        ادفعي بأمان عبر مدى، فيزا، ماستركارد أو Apple Pay. بعد نجاح العملية سيتم تأكيد طلبك مباشرة داخل حسابك.
                    </p>
                    <div class="ty-payment-amount">
                        <span>إجمالي الطلب</span>
                        <strong>{{ number_format($paymentRequest->amount, 2) }} ر.س</strong>
                    </div>
                    <div class="ty-payment-methods" aria-label="طرق الدفع المتاحة">
                        <span>Apple Pay</span>
                        <span>Mada</span>
                        <span>Visa</span>
                        <span>Mastercard</span>
                    </div>
                </aside>

                <div class="ty-payment-form">
                    @if ($isLiveKeyOnHttp)
                        <div class="ty-payment-alert">
                            مفاتيح الدفع الفعلية تعمل على رابط آمن HTTPS فقط. عند رفع الموقع وتشغيله على www.tyanil.com ستظهر بوابة الدفع هنا تلقائياً.
                        </div>
                    @else
                        <div class="mysr-form"></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('JScript')
    @unless ($isLiveKeyOnHttp)
        <script src="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.2.9/dist/moyasar.umd.js"></script>
        <script>
            Moyasar.init({
                element: '.mysr-form',
                amount: @json($amountHalalas),
                currency: 'SAR',
                description: @json('طلب متجر تيانيل رقم ' . $paymentRequest->id),
                publishable_api_key: @json($publicKey),
                callback_url: @json($callbackUrl),
                methods: ['creditcard', 'applepay'],
                supported_networks: ['mada', 'visa', 'mastercard'],
                language: 'ar',
                apple_pay: {
                    country: 'SA',
                    label: 'Tyanil',
                    validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate'
                },
                metadata: {
                    payment_request_id: @json((string) $paymentRequest->id),
                    customer_id: @json((string) $paymentRequest->customer_id)
                }
            });
        </script>
    @endunless
@endsection
