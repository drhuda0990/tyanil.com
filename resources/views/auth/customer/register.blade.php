@extends('layouts.app')

@section('content')
<main>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="title">
                        <h2>
                            <small>
                                أنا
                            </small>
                            عميل
                            <small>
                                في
                                {{env("APP_NAME")}} 
                            </small>
                        </h2>
                        <p>
                            تسجيل جديد
                        </p>
                    </div>
                    <hr />

                    @if (count($errors) > 0)
                        <div class="error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <div class="">
                      <form class="form-horizontal" method="POST" action="{{ route('trainee.register') }}">
                        @csrf

                            <div class="row">
                                <div class="col-lg-6">
                                    <p>
                                        الاسم بالكامل
                                    </p>
                                    <input id="name" type="text" class="input-text @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                                <div class="col-lg-6">
                                    <p>
                                        الاسم بالإنجليزي
                                    </p>
                                    <input id="name_en" type="text" class="input-text @error('name') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en" >
                                </div>
                            </div>
                            <p class="color-red">
                                ملاحظة: الاسم العربي والإنجليزي سيتم اعتمادهما في بيانات الطلبات، ففضلاً تأكد من صحتهما.
                            </p>
<?php $countries=App\Countries::all(); ?>
                            <div class="row">
                                <div class="col-lg-4">
                                    <p>
                                        الدولة التي تعيش بها
                                    </p>
                                    
                                    <select id="country_live" name="country_live" class="input-select form-control select">
                                        @foreach($countries as $country)
                                        <option value="{{$country->country_code}}">{{$country->country_arName}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                  <p>
                                    المدينة
                                  </p>
                                  <select id="city" name="city" class="input-select form-control select" required>
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
                                    <select id="nationality" name="nationality" class="input-select form-control select">
                                       @foreach($countries as $country)
                                        <option value="{{$country->country_code}}">{{$country->country_arNationality}} </option>
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
                                    <input id="identity" type="text" class="input-text" name="identity" value="{{ old('identity') }}"  pattern="[0-9]+" minlength="8" maxlength="14" required>

                                </div>

                            </div>

                            <hr class="space-sm" />
                            <div class="row">
                                <div class="col-lg-6">
                                    <p>البريد الإلكتروني</p>
                                    <input id="email" type="email" class="input-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" required>
                                </div>
                                <div class="col-lg-6">
                                    <p>
                                        رقم الجوال
                                    </p>
                                    <input id="phone" type="tel" class="input-text" name="phone" value="{{ old('phone') }}"   required>

                                </div>
 <div class="col-lg-6">
                                    <p>كلمة المرور </p>
                                    <input id="password" type="password" class="input-text @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  autocomplete="password" required>
                                </div>
                                 <div class="col-lg-6">
                                    <p>تأكيد كلمة المرور </p>
                                    <input id="password_confirmation" type="password" class="input-text @error('email') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}"  autocomplete="password_confirmation" required>
                                </div>
                            </div>


                            <hr class="space-sm" />
                            <div class="form-checkbox">
                                <input type="checkbox" id="check" name="check" value="check" required />
                                <label for="check">
                                    اوافق على
                                    <a href="{{route('pages',5)}}"  target="_blank">
                                        الشروط والأحكام
                                    </a>
                                    ل   
                                    {{env("APP_NAME")}} 
                                </label>
                            </div>


                            <p  class="color-red">

                              قبل التسجيل تأكد من البريد الإلكتروني ورقم الهاتف
                              ،
                              سيتم إرسال كود للتأكد من صحتهم
                            </p>

                             <button type="submit" class="btn btn-xs customSwalBtn" >
                                حفظ وأرسال
                            </button>
                            <a href="{{ route('trainee.login') }}" class="btn btn-border btn-xs">
                                لدي حساب تسجيل الدخول
                            </a>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <hr class="space-sm" />
                    <h3>
                        لماذا تسجل معنا :
                    </h3>

                    <hr class="space-sm" />
                    <div class="grid-list" data-columns="1" data-columns-lg="2" data-columns-sm="2" data-columns-xs="1">
                        <div class="grid-box">
                            <div class="grid-item">
                                <div class="icon-box icon-box-left">
                                    <i class="im-pen"></i>
                                    <div class="caption">
                                        <h3>موثوقة</h3>
                                        <!--<p>مثال نص يكتب هنا</p>-->
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="icon-box icon-box-left">
                                    <i class="im-security-camera"></i>
                                    <div class="caption">
                                        <h3>معتمدة</h3>
                                        <!--<p>مثال نص يكتب هنا</p>-->
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="icon-box icon-box-left">
                                    <i class="im-gears"></i>
                                    <div class="caption">
                                        <h3>آمنة</h3>
                                        <!--<p>مثال نص يكتب هنا</p>-->
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="icon-box icon-box-left">
                                    <i class="im-data-refresh"></i>
                                    <div class="caption">
                                        <h3>سريعة</h3>
                                        <!--<p>مثال نص يكتب هنا</p>-->
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="icon-box icon-box-left">
                                    <i class="im-support"></i>
                                    <div class="caption">
                                        <h3>دعم</h3>
                                        <!--<p>مثال نص يكتب هنا</p>-->
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item">
                                <div class="icon-box icon-box-left">
                                    <i class="im-coins"></i>
                                    <div class="caption">
                                        <h3>تواصل</h3>
                                        <!--<p>مثال نص يكتب هنا</p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>




@endsection
