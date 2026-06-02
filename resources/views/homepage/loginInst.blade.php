@extends('layouts.app')
@section('title', 'تسجيل الدخول')
<!--* ********************************* -->
@section('SCSS')
    <style>
    </style>
@endsection
<!--* ********************************* -->
@section('content')
    <section class="contact-area pt-120 pb-120">
        <div class="container">
            <div class="contact__info pb-120">

                <div class="row g-5">

                    <div class="col-lg-12 order-1 order-lg-2">
                        <div class="contact__item">
                            <div class="section-header mb-40">
                                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> تسجيل الدخول
                                </h5>
                            </div>
                                <form method="POST" class="form-class" action="{{ route('customer.login.post') }}">
                                    @csrf
                                    <div class="col-12" >
                                        <label for="login">البريد الإلكتروني أو رقم الجوال</label>
                                        <input id="login" name="login" type="text" value="{{ old('login') }}" placeholder="" autofocus>
                                    </div>
                                        <div class="col-12" >
                                        <label for="password">  كلمة المرور</label>
                                        <input id="password" name="password" type="password" value="{{ old('password') }}" placeholder="">
                                    </div>
                                    <button class="btn-one" type="submit">تسجيل الدخول<i class="fa-light fa-arrow-right-long"></i></button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<!--* ********************************* -->
@section('JScript')
    <script></script>
@endsection
