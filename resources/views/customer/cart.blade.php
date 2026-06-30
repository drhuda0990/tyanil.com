@extends('layouts.app')
@section('title', 'لوحة التحكم')
<!--* ********************************* -->
@section('SCSS')
    <style>
        .ty-checkout-card {
            margin: 28px 0;
            padding: 24px;
            border: 1px solid rgba(217, 137, 163, .28);
            border-radius: 18px;
            background: linear-gradient(145deg, rgba(255, 255, 255, .94), rgba(255, 244, 239, .82));
            box-shadow: 0 18px 42px rgba(75, 33, 63, .10);
        }

        .ty-checkout-card__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .ty-checkout-card__head h5 {
            margin: 0;
            color: #4B213F;
            font-weight: 900;
        }

        .ty-checkout-card__head span {
            color: #7b6574;
            font-size: 14px;
        }

        .ty-checkout-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .ty-checkout-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .ty-checkout-field--wide {
            grid-column: 1 / -1;
        }

        .ty-checkout-field label {
            color: #4B213F;
            font-weight: 800;
        }

        .ty-checkout-field input,
        .ty-checkout-field select {
            width: 100%;
            min-height: 54px;
            border: 1px solid rgba(75, 33, 63, .14);
            border-radius: 14px;
            background: rgba(255, 255, 255, .86);
            color: #4B213F;
            padding: 0 16px;
        }

        .ty-checkout-note {
            margin: 14px 0 0;
            color: #7b6574;
            font-size: 14px;
            line-height: 1.8;
        }

        .ty-checkout-login {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        @media (max-width: 767px) {
            .ty-checkout-card {
                padding: 18px;
            }

            .ty-checkout-grid {
                grid-template-columns: 1fr;
            }

            .ty-checkout-card__head {
                align-items: flex-start;
                flex-direction: column;
            }
        }
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
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> مجموع المنتجات:
                    <span>
                        {{ number_format($itemsTotal, 2) }}
                        SR
                    </span>
                </h5>
                @if ($existShipment)
                    <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> تكلفة الشحن:
                        <span>
                            {{ number_format($shipmentPrice, 2) }}
                            SR
                        </span>
                    </h5>
                @endif
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> المجموع النهائي:
                    <span id="cartTotal">
                        {{ number_format($totalPrice, 2) }}
                        SR
                    </span>
                </h5>
                <form id="form_submit_cart" name="form_submit_cart" class="form-box" action="{{ route('cart.submit') }}"
                    method="POST">
                    @csrf
                    <div id="discount_id_input"></div>

                    @if ($existShipment)
                        @if (\Auth::guard('customer')->check())
                            @php($customer = \Auth::guard('customer')->user())
                            <section class="ty-checkout-card" id="checkout-address">
                                <div class="ty-checkout-card__head">
                                    <div>
                                        <h5>عنوان الشحن والدفع</h5>
                                        <span>يتم حفظه مع الطلب مباشرة دون الانتقال لصفحة أخرى.</span>
                                    </div>
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <input type="hidden" name="checkout_address_id" value="{{ old('checkout_address_id', optional($checkoutAddress)->id) }}">
                                <div class="ty-checkout-grid">
                                    <div class="ty-checkout-field">
                                        <label for="checkout_name">اسم المستلم</label>
                                        <input id="checkout_name" name="checkout_name" type="text"
                                            value="{{ old('checkout_name', optional($checkoutAddress)->name ?: $customer->name) }}" required>
                                    </div>
                                    <div class="ty-checkout-field">
                                        <label for="checkout_phone">رقم الجوال</label>
                                        <input id="checkout_phone" name="checkout_phone" type="tel"
                                            value="{{ old('checkout_phone', optional($checkoutAddress)->phone ?: $customer->phone) }}" required>
                                    </div>
                                    <div class="ty-checkout-field">
                                        <label for="checkout_email">البريد الإلكتروني</label>
                                        <input id="checkout_email" name="checkout_email" type="email"
                                            value="{{ old('checkout_email', optional($checkoutAddress)->email ?: $customer->email) }}" required>
                                    </div>
                                    <div class="ty-checkout-field">
                                        <label for="checkout_country">الدولة</label>
                                        <input id="checkout_country" name="checkout_country" type="text"
                                            value="المملكة العربية السعوديه" readonly required>
                                    </div>
                                    <div class="ty-checkout-field">
                                        <label for="checkout_city">المدينة</label>
                                        <select id="checkout_city" name="checkout_city" required>
                                            <option value="">اختاري المدينة</option>
                                            @foreach ($cities as $city)
                                                @php($selectedCity = old('checkout_city', optional($checkoutAddress)->city_id))
                                                <option value="{{ $city->city_arName }}" @if ($selectedCity == $city->city_arName) selected @endif>
                                                    {{ $city->city_arName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ty-checkout-field">
                                        <label for="checkout_street">الحي</label>
                                        <input id="checkout_street" name="checkout_street" type="text"
                                            value="{{ old('checkout_street', optional($checkoutAddress)->street) }}" required>
                                    </div>
                                    <div class="ty-checkout-field ty-checkout-field--wide">
                                        <label for="checkout_address">العنوان الوطني</label>
                                        <input id="checkout_address" name="checkout_address" type="text"
                                            value="{{ old('checkout_address', optional($checkoutAddress)->address) }}"
                                            placeholder="مثال: رقم المبنى، الشارع، الرمز البريدي، الرقم الإضافي" required>
                                    </div>
                                </div>
                                <p class="ty-checkout-note">العنوان إلزامي لإتمام الشحن، ويمكن تعديله هنا قبل كل طلب.</p>
                            </section>
                            <button class="btn-one1 fLeft" type="submit">
                                <i class="fa-light fa-arrow-right-long"></i>
                                إكمال الدفع
                            </button>
                        @else
                            <section class="ty-checkout-card ty-checkout-login">
                                <div>
                                    <h5>تسجيل الدخول مطلوب لإتمام الدفع</h5>
                                    <p class="ty-checkout-note">بعد تسجيل الدخول سيبقى المنتج في السلة ويمكنك إدخال عنوان الشحن هنا مباشرة.</p>
                                </div>
                                <a class="btn-one" href="{{ route('customer.login') }}">تسجيل الدخول</a>
                            </section>
                        @endif
                    @else
                        <button class="btn-one1 fLeft" type="submit">
                            <i class="fa-light fa-arrow-right-long"></i>
                            إكمال الدفع
                        </button>
                    @endif
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
