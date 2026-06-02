@extends('layouts.app')
@section('title', 'العناوين')
<!--* ********************************* -->
@section('SCSS')
    <style>
    </style>
@endsection
<!--* ********************************* -->
@section('content')
    <section class="contact-area pt-120 pb-120">
        <div class="container">
            <div class="section-header mb-40">
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> عنوان العميل
                </h5>
            </div>
            <hr>
            <div class="contact__info pb-120">

                <div class="row g-5">

                    <div class="col-lg-12 order-1 order-lg-2 ">

                        <!-- Option 1: Automatically Detect Location -->
                        <button class="btn-one" id="detectLocation">إستخدم موقعي الحالي
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                        </button>
                        </br>
                        </br>

                        <!-- Form inputs for city, state, and street address -->
                        <form id="locationForm"
                            action="{{ isset($address) ? route('customer.address.update') : route('customer.newAddress.post') }}"
                            method="post" class="form-box rtlDirection form-class form-bground">
                            {{ csrf_field() }}
                            @if (isset($address))
                                <input id="id" name="id" type="hidden" value="{{ encrypt($address->id) }}">
                            @endif
                            <div class="col-12">
                                <label for="phone">الاسم </label>
                                <input id="name" name="name" type="text"
                                    value="{{ isset($address) ? $address->name : Auth::guard('customer')->user()->name }}"
                                    placeholder="الاسم رباعي" autofocus>
                            </div>
                            <div class="col-12">
                                <label for="phone"> الجوال </label>
                                <input id="phone" name="phone" type="text"
                                    value="{{ isset($address) ? $address->phone : Auth::guard('customer')->user()->phone }}"
                                    placeholder="">
                            </div>
                            <div class="col-12">
                                <label for="email">البريد الإلكتروني </label>
                                <input id="email" name="email" type="text"
                                    value="{{ isset($address) ? $address->email : Auth::guard('customer')->user()->email }}"
                                    placeholder="">
                            </div>
                            <label for="country">الدولة</label>

                            <input type="text" id="countryInput" value="المملكة العربية السعوديه" name="country"
                                placeholder="الدولة" readonly><br><br>

                            <!--<label for="state">المنطقة</label>-->
                            <!--<input type="text" id="stateInput" name="state" placeholder="المنطقة"><br><br>-->

                            <label for="city">المدينه</label>
                            <select id="cityInput" class="select2" name="city" style="width: 100%">

                                @foreach ($cities as $city)
                                    <option value="{{ $city->city_arName }}"
                                        @if (isset($address)) @if ($address->city_id == $city->city_arName) selected @endif
                                        @endif>{{ $city->city_arName }}</option>
                                @endforeach
                            </select>

                            <br><br>

                            <label for="street">الحي</label>
                            <input type="text" id="street" value="{{ isset($address) ? $address->street : null }}"
                                name="street" placeholder="الحي"><br><br>

                            <label for="address"> العنوان الوطني ( إلزامي امتثالًا لمتطلبات هيئة النقل، ولضمان إتمام عملية
                                التوصيل، يرجى إدخال العنوان الوطني.)</label>
                            <input type="text" id="address" name="address"
                                value="{{ isset($address) ? $address->address : null }}" placeholder="العنوان الوطني"
                                required><br><br>



                            <!--<select id="countrySelect" class="dBlock" >-->
                            <!--    <option value="">Select Country</option>-->
                            <!--</select>-->

                            <!--<select id="stateSelect" class="dBlock" >-->
                            <!--    <option value="">Select State</option>-->
                            <!--</select>-->

                            <!--<select id="citySelect" class="dBlock">-->
                            <!--    <option value="">Select City</option>-->
                            <!--</select>-->

                            <button class="btn-one" type="submit">
                                حفظ</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<!--* ********************************* -->
@section('JScript')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDigbEd9Zdk1fON_DsfKGNJyVgpGyVzqjQ" async defer></script>

    <script type="module">
        $(document).ready(function() {

            $('.select2').select2({
                allowClear: true
            });

            // Option 1: Automatically Detect Location using Geolocation and Google Maps API
            document.getElementById('detectLocation').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else {
                    alert("خدمة تحديد الموقع غير متاحة في هذا المتصفح.");
                }
            });

            function showPosition(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                var geocoder = new google.maps.Geocoder();
                var latlng = new google.maps.LatLng(lat, lng);

                geocoder.geocode({
                    'location': latlng,
                    'language': 'ar' // Request Arabic results
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            const address = results[0].formatted_address; // Full address in Arabic
                            var addressComponents = results[0].address_components;
                            var city = '';
                            var state = '';
                            var street = '';
                            var country = '';




                            // Extract city, state, and street from the address components
                            addressComponents.forEach(function(component) {
                                if (component.types.includes('locality')) {
                                    city = component.long_name; // City
                                }
                                if (component.types.includes('administrative_area_level_1')) {
                                    state = component.long_name; // State
                                }
                                if (component.types.includes('route')) {
                                    street = component.long_name; // Street Name
                                }
                                if (component.types.includes('country')) {
                                    country = component.long_name; // Country
                                }
                                if (component.types.includes('street_number')) {
                                    street = component.long_name + ' ' +
                                        street; // Street Number + Street Name
                                }
                            });

                            if (country !== 'السعودية') {
                                alert("هذا التطبيق يعمل فقط داخل المملكة العربية السعودية.");
                                return; // Stop further execution if not in Saudi Arabia
                            }


                            // Set the values of form inputs
                            // document.getElementById('cityInput').value = city;
                            $('#cityInput').val(city).trigger('change');

                            // document.getElementById('stateInput').value = state;
                            document.getElementById('street').value = street;
                            document.getElementById('address').value = address; // Display full address
                            // document.getElementById('countryInput').value = country;

                        } else {
                            alert("لا يوجد نتائج متاحة لموقعك");
                        }
                    } else {
                        alert("فشل تحديد الموقع بسبب: " + status);
                    }
                });
            }

            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert("رفض العميل إذن الوصول للموقع.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("معلومات الموقع غير متاحة.");
                        break;
                    case error.TIMEOUT:
                        alert("الوقت المحدد لتحديد الموقع انتهى.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("حصل خطأ غير معروف.");
                        break;
                }
            }

        });
    </script>
@endsection
