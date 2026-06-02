@if (count($errors) > 0)
<br>
<div>
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif


<div class="container">

<div class="section-heading text-center mb-4 pb-4">
    <i class="la la-graduation-cap display-2 "></i>
    <h2 class="section__title">
        <small>
            الدخول إلى
        </small>
	        لوحة العميل
    </h2>
    <span class="section-divider"></span>

</div><!-- end section-heading -->

<div class="row">




    <div class="col-lg-4">

        <div class="loginForm">
            @if (session()->has('code_send'))
                <div class="error">
                    <ul>
                        <li>
                            {{ session()->get('code_send') }}
                        </li>
                    </ul>
                </div>
                <form method="POST" action="{{ route('trainee.login.access_code') }}">
                    @csrf
                    <p>
                        <b>
                            رمز الدخول
                        </b>
                        <br>
                        <small>
                            إن لم تصلك الرسالة على
                            "البريد الهام"
                            فضلاً
                            تأكد من التحقق في
                            قسم
                            "البريد الغير هام"
                            /
                            "Junk Mail"
                        </small>
                    </p>

                    <span class="space-xs"></span>
                    <input type="hidden" name="id_login" value="{{ session()->get('id_login') }}" required>
                    <label>
                        الكود المرسل
                    </label>
                    <input id="code_send" minlength="5" maxlength="6" type="text" pattern="[0-9]+"
                        class="input-text En" name="code_send" value="{{ old('code_send') }}" required
                        autofocus>
                    <label>
                        كلمة المرور الجديده
                    </label>
                    <input id="password" type="password"
                        class="input-text @error('password') is-invalid @enderror" name="password"
                        value="{{ old('password') }}" autocomplete="password" required>
                    <label>
                        تأكيد كلمة المرور
                    </label>
                    <input id="password_confirmation" type="password"
                        class="input-text @error('email') is-invalid @enderror" name="password_confirmation"
                        value="{{ old('password_confirmation') }}" autocomplete="password_confirmation"
                        required>

                    <br>
                    <button class="btn btn-xs" type="submit">
                        تأكيد
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('trainee.login') }}">
                    @csrf

                    <h3 class="h3-style">
                        تسجيل الدخول
                    </h3>
                    <hr>
                    <div class="row rtl">


                        <select name="select_input" class="input-select">
                            <option value="1" selected> البريد الإلكتروني </option>
                            <option value="2"> رقم الجوال </option>
                            <option value="3"> رقم الهوية </option>
                        </select>


                        <input id="input_send" type="text"
                            class="input-text En @error('input_send') is-invalid @enderror"
                            name="input_send" value="{{ old('input_send') }}" required
                            autocomplete="input_send" autofocus>
                        <label>كلمة المرور</label>
                        <input id="password" type="password"
                            class="input-text En @error('password') is-invalid @enderror"
                            placeholder="كلمة المرور" name="password" value="{{ old('password') }}"
                            required autocomplete="password">


                    </div>

                    <div class="form-checkbox">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label for="check">تذكرني </label>
                    </div>
                    <hr>
                    <button class="btn btn-xs customSwalBtn" type="submit">
                        دخول
                    </button>


                </form>
            @endif
        </div>

        <div class="forgetForm">



            <form method="POST" action="{{ route('trainee.forget.submit') }}">
                @csrf

                <h3 class="h3-style">
                    وسيلة إستعادة كلمة المرور
                </h3>
                <hr>
                <div class="row rtl">

                    <select name="select_input" class="input-select">
                        <option value="1" selected> البريد الإلكتروني </option>
                        <option value="2"> رقم الجوال </option>
                        <option value="3"> رقم الهوية </option>
                    </select>

                    <input id="input_send" type="text"
                        class="input-text En @error('input_send') is-invalid @enderror" name="input_send"
                        value="{{ old('input_send') }}" required autocomplete="input_send" autofocus>



                    <span class="space-xs"></span>
                    <div>
                        <h3 class="h3-style">
                            ارسال كلمة المرور عبر :
                        </h3>

                        <div class="form-checkbox">
                            <input type="radio" value="1" name="type_send">
                            <label>
                                الايميل
                            </label>
                        </div>

                        <div class="form-checkbox">
                            <input type="radio" value="2" name="type_send" checked>
                            <label>
                                الرسائل
                            </label>
                        </div>


                    </div>
                </div>

                <hr>
                <button class="btn btn-xs customSwalBtn" type="submit">
                    إرسال
                </button>
            </form>


        </div>


    </div><!-- end col-lg-7 -->

    <div class="col-lg-8">
        <div class="registrationForm">
            <h3 class="h-style">
                قم بإنشاء حساب و ابدأ التعلم!
            </h3>
            <hr>
            <form class="form-horizontal" method="POST" action="{{ route('trainee.register') }}">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <p>
الأسم رباعي بالعربي                        </p>
                        <input id="name" type="text"
                            class="input-text @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            الاسم رباعي بالإنجليزي
                        </p>
                        <input id="name_en" type="text"
                            class="input-text @error('name') is-invalid @enderror" name="name_en"
                            value="{{ old('name_en') }}" required autocomplete="name_en">
                    </div>
                </div>
                <p class="color-red">
                    ملاحظة : تأكدي من كتابة الاسم والبيانات بشكل صحيح لاستخدامها في الطلبات والشحن.
                </p>
                <?php $countries = App\Countries::all(); ?>
                <div class="row">
                    <div class="col-lg-4">
                        <p>
                            الدولة التي تعيش بها
                        </p>

                        <select id="country_live" name="country_live"
                            class="input-select form-control select">
                            @foreach ($countries as $country)
                                <option value="{{ $country->country_code }}">
                                    {{ $country->country_arName }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <p>
                            المدينة
                        </p>
                        <select id="city" name="city" class="input-select form-control select"
                            required>
                            <option value="" selected>اختر</option>
                            <option value="الاحساء">الاحساء</option>
                            <option value="الافلاج">الافلاج</option>
                            <option value="الأسياح">الأسياح</option>
                            <option value="الباحة">الباحة</option>
                            <option value="البدائع">البدائع</option>
                            <option value="البكيريه">البكيريه</option>
                            <option value="الجبيل">الجبيل</option>
                            <option value="الجموم">الجموم</option>
                            <option value="الحائط">الحائط</option>
                            <option value="الحناكية">الحناكية</option>
                            <option value="الخبر">الخبر</option>
                            <option value="الخرج">الخرج</option>
                            <option value="الخرمة">الخرمة</option>
                            <option value="الخفجي">الخفجي</option>
                            <option value="الدائر">الدائر</option>
                            <option value="الدرب">الدرب</option>
                            <option value="الدرعية">الدرعية</option>
                            <option value="الدمام">الدمام</option>
                            <option value="الدوادمي">الدوادمي</option>
                            <option value="الرس">الرس</option>
                            <option value="الرياض">الرياض</option>
                            <option value="الزلفي">الزلفي</option>
                            <option value="السليل">السليل</option>
                            <option value="الطائف">الطائف</option>
                            <option value="الطوال">الطوال</option>
                            <option value="العارضة">العارضة</option>
                            <option value="العرضيات">العرضيات</option>
                            <option value="العلا">العلا</option>
                            <option value="القريات">القريات</option>
                            <option value="القطيف">القطيف</option>
                            <option value="القنفذة">القنفذة</option>
                            <option value="القويعية">القويعية</option>
                            <option value="الليث">الليث</option>
                            <option value="المجاردة">المجاردة</option>
                            <option value="المجمعة">المجمعة</option>
                            <option value="المخواة">المخواة</option>
                            <option value="المدينة_المنورة">المدينة المنورة</option>
                            <option value="المذنب">المذنب</option>
                            <option value="المزاحمية">المزاحمية</option>
                            <option value="المهد">المهد</option>
                            <option value="المويه">المويه</option>
                            <option value="النبهانية">النبهانية</option>
                            <option value="النعيرية">النعيرية</option>
                            <option value="النماص">النماص</option>
                            <option value="الوجه">الوجه</option>
                            <option value="املج">املج</option>
                            <option value="أبها">أبها</option>
                            <option value="أبو عريش">أبو عريش</option>
                            <option value="أحد رفيدة">أحد رفيدة</option>
                            <option value="أضم">أضم</option>
                            <option value="بارق">بارق</option>
                            <option value="بالقرن">بالقرن</option>
                            <option value="بحرة">بحرة</option>
                            <option value="بدر">بدر</option>
                            <option value="بريدة">بريدة</option>
                            <option value="بقعاء">بقعاء</option>
                            <option value="بقيق">بقيق</option>
                            <option value="بلجرشي">بلجرشي</option>
                            <option value="بيش">بيش</option>
                            <option value="بيشة">بيشة</option>
                            <option value="تبوك">تبوك</option>
                            <option value="تثليث">تثليث</option>
                            <option value="تربه">تربه</option>
                            <option value="تيماء">تيماء</option>
                            <option value="جازان">جازان</option>
                            <option value="جدة">جدة</option>
                            <option value="حائل">حائل</option>
                            <option value="حفر الباطن">حفر الباطن</option>
                            <option value="حوطة بني">حوطة بني تميم</option>
                            <option value="خليص">خليص</option>
                            <option value="خميس مشيط">خميس مشيط</option>
                            <option value="خيبر">خيبر</option>
                            <option value="دومة الجندل">دومة الجندل</option>
                            <option value="رابغ">رابغ</option>
                            <option value="رأس تنوره">رأس تنوره</option>
                            <option value="رجال المع">رجال المع</option>
                            <option value="رفحاء">رفحاء</option>
                            <option value="رنيه">رنيه</option>
                            <option value="سراة عبيدة">سراة عبيدة</option>
                            <option value="سكاكا">سكاكا</option>
                            <option value="شرورة">شرورة</option>
                            <option value="شقراء">شقراء</option>
                            <option value="صامطة">صامطة</option>
                            <option value="صبيا">صبيا</option>
                            <option value="ضباء">ضباء</option>
                            <option value="ضمد">ضمد</option>
                            <option value="طبرجل">طبرجل</option>
                            <option value="طريف">طريف</option>
                            <option value="ظهران الجنوب">ظهران الجنوب</option>
                            <option value="عرعر">عرعر</option>
                            <option value="عفيف">عفيف</option>
                            <option value="عنيزة">عنيزة</option>
                            <option value="قلوه">قلوه</option>
                            <option value="محايل">محايل</option>
                            <option value="مكة المكرمة">مكة المكرمة</option>
                            <option value="ميسان">ميسان</option>
                            <option value="نجران">نجران</option>
                            <option value="وادي الدواسر">وادي الدواسر</option>
                            <option value="ينبع">ينبع</option>
                            <option value="غير">غير ذلك</option>

                        </select>
                    </div>
                    <div class="col-lg-4">
                        <p>
                            الجنسية
                        </p>
                        <select id="nationality" name="nationality"
                            class="input-select form-control select">
                            @foreach ($countries as $country)
                                <option value="{{ $country->country_code }}">
                                    {{ $country->country_arNationality }} </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <hr class="space-sm" />
                <div class="row">
                    <div class="col-lg-6">
                        <p>أنا</p>
                        <select id="gender" name="gender" class="input-select">
                            <option value="1" selected>ذكر </option>
                            <option value="2">أنثى </option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            رقم الهوية/الاقامة/الجواز
                        </p>
                        <input id="identity" type="text" class="input-text" name="identity"
                            value="{{ old('identity') }}" pattern="[0-9]+" minlength="8"
                            maxlength="14" required>

                    </div>

                </div>

                <hr class="space-sm" />
                <div class="row">
                    <div class="col-lg-6">
                        <p>البريد الإلكتروني</p>
                        <input id="email" type="email"
                            class="input-text @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" autocomplete="email" required>
                    </div>
                    <div class="col-lg-6">
                        <p>
                            رقم الجوال
                        </p>
                        <input id="phone" type="tel" class="input-text" name="phone"
                            value="{{ old('phone') }}" required>

                    </div>
                    <div class="col-lg-6">
                        <p>كلمة المرور </p>
                        <input id="password" type="password"
                            class="input-text @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password') }}" autocomplete="password" required>
                    </div>
                    <div class="col-lg-6">
                        <p>تأكيد كلمة المرور </p>
                        <input id="password_confirmation" type="password"
                            class="input-text @error('email') is-invalid @enderror"
                            name="password_confirmation" value="{{ old('password_confirmation') }}"
                            autocomplete="password_confirmation" required>
                    </div>
                </div>


                <hr class="space-sm" />
                <div class="form-checkbox">
                    <input type="checkbox" id="check" name="check" value="check" required />
                    <label for="check " class="h-style">
                        اوافق على
                        <a href="{{ route('pages', 5) }}" target="_blank">
                            الشروط والأحكام
                        </a>
                        ل
                        {{ env('APP_NAME') }}
                    </label>
                </div>



                <hr>
                <button type="submit" class="btn btn-xs customSwalBtn">
                    حفظ وأرسال
                </button>

            </form>
        </div>
    </div><!-- end col-lg-7 -->

</div><!-- end row -->
</div>
