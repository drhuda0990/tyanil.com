@extends('layouts.app')
@section('title', 'لوحة التحكم')
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
                                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> معلوماتي
                                </h5>
                            </div>
                            <form method="POST" class="form-class rtlDirection" action="{{ route('customer.info.post') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="phone">الاسم </label>
                                    <input id="name" name="name" type="text"
                                        value="{{ Auth::guard('customer')->user()->name }}" placeholder="الاسم " autofocus>
                                </div>
                                <div class="col-12">
                                    <label for="phone">البريد الإلكتروني </label>
                                    <input id="email" name="email" type="text"
                                        value="{{ Auth::guard('customer')->user()->email }}" placeholder="">
                                </div>
                                <button class="btn-one" type="submit"> حفظ<i
                                        class="fa-light fa-arrow-right-long"></i></button>
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
    @if (Auth::guard('customer')->user()->email == null || Auth::guard('customer')->user()->name == null)
        {{-- <script>
 Swal.fire({
            title: "",
            icon: "info",
            html: "<br>" +
                'نرجوا منك إكمال بياناتك وإضافة عنوان للشحن في حال حاجتك لخدمة تتطلب شحن' + '<br>' +
                '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                'حسناً' + '</button>',
            showCancelButton: false,
            showConfirmButton: false

        });
        </script> --}}
    @endif
@endsection
