@extends('layouts.app')
@section('title', 'لوحة التحكم')
<!--* ********************************* -->
@section('SCSS')
    <style>
    </style>
@endsection
<!--* ********************************* -->
@section('content')
    <section class="contact-area pt-120 pb-120 rtlDirection">
        <div class="container">
            <div class="section-header mb-40">
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> السلة
                </h5>
                @if (count($carts) > 0)
                    <h5 class="wow fLeft"> <a class="cRed" href="{{ route('cart.remove', ['service' => encrypt(0)]) }}">
                            <i class="fa-solid fa-trash-can-arrow-up"></i>
                            حذف
                            الكل</a> </h5>
                @endif
            </div>
            @if ($existShipment && \Auth::guard('customer')->user())
                <hr>
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> عنوان الشحن
                </h5>
                <a class="fLeft" href="{{ route('customer.newAddress') }}">
                    <button class="btn-one" type="submit">
                        إضافة عنوان جديد
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </a>
                <div class="row w-100">
                    <br>
                    <div class="col-lg-12 order-1 order-lg-2 ">
                        <div class="accordion rtlDirection" id="accordionExample">
                            @foreach (\Auth::guard('customer')->user()->allAddress as $key => $address)
                                <label class="custom-radio w-100">
                                    <input type="radio" form="form_submit_cart" name="address" value="{{ $address->id }}"
                                        @if ($key == 0) required checked @endif>
                                    <span class="radio-circle"></span>
                                    @include('customer.addressSection')
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr>
            @endif

            @foreach ($carts as $cart)
                <div class="team-details__item mt-10 p0">
                    <div class="row g-4 align-items-center w100">
                        <div class="col-lg-4">
                            <div class="image">
                                <img  src="{{ $cart->service->image_url }}" alt="image">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="team-details__content section-header">
                                <a href="{{ route('service.show', ['id' => $cart->service->id]) }}">
                                    <h5 class="wow fadeInUp">{{ $cart->service->title }}</h5>
                                </a>
                                <?php
                                // $additional_features=App\General::extractFromArray($cart->additional_features);
                                ?>

                                @if (count($cart->service->activateAdditionalFeatures) > 0)
                                    <h2 class="text-left">الإضافات</h2>
                                    <hr>
                                    <form class="" action="{{ route('customer.cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="cart_id" value="{{ encrypt($cart->id) }}">
                                        @foreach ($cart->service->activateAdditionalFeatures as $addFeature)
                                            <label class="custom-control overflow-checkbox">
                                                <input type="checkbox" class="overflow-control-input"
                                                    @if ($cart->additional_features != '' && $cart->additional_features != null) @if (in_array($addFeature->id, json_decode($cart->additional_features, true) ?? [])) checked="" @endif
                                                    @endif name="features[]"
                                                value="{{ $addFeature->id }}" >
                                                <span class="overflow-control-indicator"></span>
                                                <span class="overflow-control-description">{{ $addFeature->title }}</span>
                                            </label>
                                            <p style="font-size: 13px">{{ $addFeature->details }}</p>
                                            <hr>
                                        @endforeach
                                        <button class="btn-one" type="submit">
                                            تحديث الاضافات
                                            <i class="fa-light fa-arrow-right-long"></i>
                                        </button>
                                    </form>
                                @endif
                                <br>
                                <hr>
                                <div class="team-details__social">
                                    <?php $amount = App\Http\Controllers\CustomerController::cartItemPrice([$cart]);
                                    ?>
                                    {{ number_format($amount['total_price'], 2) }} SR

                                    <div class=" cRed fLeft">
                                        <a href="{{ route('cart.remove', ['service' => encrypt($cart->service->id)]) }}"
                                            class=""> <i class="fa-solid fa-trash "></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if (count($carts) > 0)
                <hr>
                <form id="form_code" name="form_code" class="form-box form-class form-bground"
                    action="{{ route('code_id') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <span class="cRed tLeft w100">
                            لديك كوبون خصم؟
                        </span>
                        <div class="col-8 p0">
                            <input name="code_text" type="text" placeholder="ادخل رمز الكود" form="form_code" required>
                        </div>
                        <div class="col-4 p0">
                            <input id="form_code_submit" type="submit" value="إضافة" class="bcBlack  cWhite fLeft">
                        </div>
                    </div>
                </form>
                <hr>
                @if ($existShipment)
                    <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> تكلفة الشحن:
                        <span>
                            {{ number_format($gSetting->shipment_price, 2) }}
                            SR
                        </span>
                    </h5>
                @endif
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> المجموع:
                    <span id="cartTotal">
                        {{ number_format($totalPrice, 2) }}
                        SR
                    </span>
                </h5>
                <form id="form_submit_cart" name="form_submit_cart" class="form-box" action="{{ route('cart.submit') }}"
                    method="POST">
                    @csrf
                    <div id="discount_id_input"></div>

                    <button class="btn-one1 fLeft" type="submit">
                        <i class="fa-light fa-arrow-right-long"></i>
                        إكمال الدفع</button>
                </form>
            @endif
        </div>
    </section>
@endsection
<!--* ********************************* -->
@section('JScript')


    <script>
        $('#form_code').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('code_id') }}",
                data: $("#form_code").serialize(),
                dataType: "json",
                success: function(data) {
                    toastr.info(data.message);
                    $('#discount_id_input').html(data.discount_input);

                    if (data.discount_amount != null) {
                        $('#cartTotal').html(data.discount_amount.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + " SR");
                    }
                },
                error: function(xhr, resp, text) {}
            });

        });
    </script>
@endsection
