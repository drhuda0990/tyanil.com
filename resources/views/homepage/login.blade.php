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

                            @if (session()->has('code_send'))
                                <script>
                                    toastr.error('{{ session('code_send') }}');
                                </script>
                                <form method="POST" class="form-class" action="{{ route('customer.login.access_code') }}">
                                    @csrf
                                    <input type="hidden" name="id_login" value="{{ session()->get('id_login') }}" required>
                                    <label>
                                        الكود المرسل
                                    </label>
                                    <input type="hidden" name="id_login" value="{{ session()->get('id_login') }}" required>

                                    <input id="code_send" minlength="5" maxlength="6" type="text" pattern="[0-9]+"
                                        class="input-text En" name="code_send" value="{{ old('code_send') }}" required
                                        autofocus>

                                    <button class="btn-one" type="submit">دخول<i
                                            class="fa-light fa-arrow-right-long"></i></button>

                                </form>
                            @else
                                <form method="POST" class="form-class" action="{{ route('customer.login') }}">
                                    @csrf
                                    <div class="col-12">
                                        <label for="phone">رقم الجوال</label>
                                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                            placeholder="5XXXXXXXX" autofocus>
                                    </div>
                                    <button class="btn-one" type="submit">إرسال الكود<i
                                            class="fa-light fa-arrow-right-long"></i></button>



                                </form>
                            @endif
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
