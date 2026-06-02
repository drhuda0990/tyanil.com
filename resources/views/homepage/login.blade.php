@extends('layouts.app')
@section('title', 'الدخول والتسجيل')

@section('SCSS')
    <style>
        .ty-auth {
            padding: 120px 0 90px;
            background:
                linear-gradient(135deg, rgba(255, 248, 245, .92), rgba(255, 240, 247, .82)),
                var(--tyanil-soft-grid, transparent);
        }

        .ty-auth__heading {
            max-width: 760px;
            margin: 0 auto 34px;
            text-align: center;
        }

        .ty-auth__heading h1 {
            color: #4f183f;
            font-size: clamp(2rem, 4vw, 3.3rem);
            font-weight: 900;
            margin-bottom: 12px;
        }

        .ty-auth__heading p {
            color: #806173;
            font-size: 1.05rem;
            margin: 0;
        }

        .ty-auth__grid {
            display: grid;
            grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr);
            gap: 24px;
            align-items: start;
        }

        .ty-auth-card {
            border: 1px solid rgba(224, 150, 181, .32);
            border-radius: 22px;
            background: rgba(255, 255, 255, .72);
            box-shadow: 0 24px 70px rgba(79, 24, 63, .14);
            backdrop-filter: blur(18px);
            padding: clamp(22px, 3vw, 34px);
        }

        .ty-auth-card--dark {
            color: #fff;
            background:
                linear-gradient(145deg, rgba(79, 24, 63, .94), rgba(112, 62, 91, .82)),
                rgba(79, 24, 63, .9);
        }

        .ty-auth-card--dark h2,
        .ty-auth-card--dark p {
            color: #fff !important;
        }

        .ty-auth-card h2 {
            margin-bottom: 8px;
            font-size: 1.65rem;
            font-weight: 900;
        }

        .ty-auth-card p {
            color: inherit;
        }

        .ty-auth-card--dark p {
            color: rgba(255, 255, 255, .78) !important;
        }

        .ty-auth-form {
            display: grid;
            gap: 16px;
        }

        .ty-auth-form__row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .ty-auth-field label {
            display: block;
            margin-bottom: 8px;
            color: #5b304d;
            font-weight: 800;
        }

        .ty-auth-card--dark .ty-auth-field label {
            color: rgba(255, 255, 255, .9) !important;
        }

        .ty-auth-field input {
            width: 100%;
            height: 54px;
            border: 1px solid rgba(224, 150, 181, .42);
            border-radius: 16px;
            background: rgba(255, 255, 255, .86);
            color: #4f183f;
            padding: 0 18px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .ty-auth-field input:focus {
            border-color: #d980a5;
            box-shadow: 0 0 0 4px rgba(217, 128, 165, .18);
        }

        .ty-auth-check {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6d4a60;
            font-weight: 700;
        }

        .ty-auth-card--dark .ty-auth-check {
            color: rgba(255, 255, 255, .84) !important;
        }

        .ty-auth-check input {
            width: 18px;
            height: 18px;
            accent-color: #d980a5;
        }

        .ty-auth-error {
            border: 1px solid rgba(204, 72, 109, .28);
            border-radius: 16px;
            background: rgba(255, 241, 246, .9);
            color: #8d2445;
            padding: 14px 18px;
            margin-bottom: 18px;
        }

        .ty-auth-error ul {
            margin: 0;
            padding-inline-start: 20px;
        }

        .ty-auth-otp {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, .2);
        }

        .ty-auth-link {
            color: #c96f98;
            font-weight: 900;
        }

        .ty-auth-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .ty-auth-actions .btn-one {
            border: 0;
        }

        @media (max-width: 991px) {
            .ty-auth {
                padding-top: 80px;
            }

            .ty-auth__grid,
            .ty-auth-form__row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <section class="ty-auth">
        <div class="container">
            <div class="ty-auth__heading">
                <h1>انضمي إلى تيانيل</h1>
                <p>سجلي دخولك بالبريد الإلكتروني أو رقم الجوال، أو أنشئي حسابك ببياناتك الأساسية.</p>
            </div>

            @if (count($errors) > 0)
                <div class="ty-auth-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('info'))
                <div class="ty-auth-error">{{ session('info') }}</div>
            @endif

            <div class="ty-auth__grid">
                <div class="ty-auth-card ty-auth-card--dark">
                    <h2>تسجيل الدخول</h2>
                    <p>ادخلي بحسابك عبر البريد الإلكتروني أو رقم الجوال أو رقم الهوية.</p>

                    @if (session()->has('code_send'))
                        <form method="POST" class="ty-auth-form" action="{{ route('customer.login.access_code') }}">
                            @csrf
                            <input type="hidden" name="id_login" value="{{ session()->get('id_login') }}" required>

                            <div class="ty-auth-field">
                                <label for="code_send">الكود المرسل</label>
                                <input id="code_send" minlength="5" maxlength="6" type="text" pattern="[0-9]+"
                                    name="code_send" value="{{ old('code_send') }}" required autofocus>
                            </div>

                            <div class="ty-auth-actions">
                                <button class="btn-one" type="submit">دخول<i class="fa-light fa-arrow-right-long"></i></button>
                            </div>
                        </form>
                    @else
                        <form method="POST" class="ty-auth-form" action="{{ route('customer.login.post') }}">
                            @csrf

                            <div class="ty-auth-field">
                                <label for="login">البريد الإلكتروني أو الجوال</label>
                                <input id="login" name="login" type="text" value="{{ old('login') }}"
                                    placeholder="info@example.com أو 5XXXXXXXX" autocomplete="username" autofocus required>
                            </div>

                            <div class="ty-auth-field">
                                <label for="login_password">كلمة المرور</label>
                                <input id="login_password" name="password" type="password" autocomplete="current-password"
                                    required>
                            </div>

                            <label class="ty-auth-check" for="remember">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>تذكرني</span>
                            </label>

                            <div class="ty-auth-actions">
                                <button class="btn-one" type="submit">تسجيل الدخول<i class="fa-light fa-arrow-right-long"></i></button>
                            </div>
                        </form>

                        <div class="ty-auth-otp">
                            <p>حسابك القديم بالجوال فقط؟</p>
                            <form method="POST" class="ty-auth-form" action="{{ route('customer.login.post') }}">
                                @csrf
                                <div class="ty-auth-field">
                                    <label for="otp_phone">رقم الجوال</label>
                                    <input id="otp_phone" name="phone" type="text" value="{{ old('phone') }}"
                                        placeholder="5XXXXXXXX">
                                </div>
                                <div class="ty-auth-actions">
                                    <button class="btn-one" type="submit">إرسال رمز الدخول<i class="fa-light fa-arrow-right-long"></i></button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="ty-auth-card">
                    <h2>تسجيل حساب جديد</h2>
                    <p>املئي بياناتك مرة واحدة لتسهيل الطلبات والشحن لاحقاً.</p>

                    <form method="POST" class="ty-auth-form" action="{{ route('customer.register.post') }}">
                        @csrf

                        <div class="ty-auth-field">
                            <label for="name">الاسم الكامل</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name"
                                required>
                        </div>

                        <div class="ty-auth-form__row">
                            <div class="ty-auth-field">
                                <label for="email">البريد الإلكتروني</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    autocomplete="email" required>
                            </div>

                            <div class="ty-auth-field">
                                <label for="phone">رقم الجوال</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                                    placeholder="5XXXXXXXX" autocomplete="tel" required>
                            </div>
                        </div>

                        <div class="ty-auth-form__row">
                            <div class="ty-auth-field">
                                <label for="password">كلمة المرور</label>
                                <input id="password" name="password" type="password" autocomplete="new-password"
                                    required>
                            </div>

                            <div class="ty-auth-field">
                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    autocomplete="new-password" required>
                            </div>
                        </div>

                        <label class="ty-auth-check" for="newsletter">
                            <input type="checkbox" id="newsletter" name="newsletter" value="1" checked>
                            <span>استقبال تحديثات وعروض تيانيل</span>
                        </label>

                        <label class="ty-auth-check" for="terms">
                            <input type="checkbox" id="terms" name="terms" value="1" required>
                            <span>أوافق على <a class="ty-auth-link" href="{{ route('pages', 5) }}" target="_blank">الشروط والأحكام</a></span>
                        </label>

                        <div class="ty-auth-actions">
                            <button class="btn-one" type="submit">إنشاء الحساب<i class="fa-light fa-arrow-right-long"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
