@extends('layouts.app')

@section('content')


    <main>

      <section class="section-block section-block-full " style="text-align: center;background:#f8f8f8;">
   
     
          <div class="container">
              <div class="row">
                  <div class="col">
                      <div class="">

                        @if (count($errors) > 0)
                            <div class="error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session()->has('code_send'))

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
                                      <label >
                                             الكود المرسل
                                            </label>
                                <input id="code_send" minlength="5" maxlength="6" type="text" pattern="[0-9]+" class="input-text En" name="code_send" value="{{ old('code_send') }}" required autofocus>
                                      <label >
                                              كلمة المرور الجديده
                                            </label>
                                 <input id="password" type="password" class="input-text @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  autocomplete="password" required>
                                     <label >
                                              تأكيد كلمة المرور
                                            </label>
                                <input id="password_confirmation" type="password" class="input-text @error('email') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}"  autocomplete="password_confirmation" required>
                              
                                <br>
                                <button  class="btn btn-xs" type="submit">
                                  تأكيد
                                </button>
                          </form>
                        @else
                        <form method="POST" action="{{ route('trainee.forget.submit') }}">
                            @csrf

                              <p>
                                وسيلة إستعادة كلمة المرور
                              </p>
                              <div class="row">

                                  <div class="col-lg-5">
                                    <select name="select_input" class="input-select">
                                          <option value="1" selected> البريد الإلكتروني </option>
                                          <option value="2"> رقم الجوال </option>
                                          <option value="3"> رقم الهوية </option>
                                    </select>
                                  </div>
                                  <div class="col-lg-7">
                                    <input id="input_send" type="text" class="input-text En @error('input_send') is-invalid @enderror" name="input_send" value="{{ old('input_send') }}" required autocomplete="input_send" autofocus>
                                  </div>

                              </div>
                              <span class="space-xs"></span>
                              <div>
                                  <p>
                                    ارسال كلمة المرور عبر   :
                                  </p>
                                  <div class="row">
                                      <div class="col-lg-4">
                                        <div class="form-checkbox">
                                            <input type="radio" value="1" name="type_send">
                                            <label >
                                              Email
                                            </label>
                                        </div>
                                      </div>
                                      <div class="col-lg-4">
                                        <div class="form-checkbox">
                                            <input type="radio" value="2" name="type_send" checked>
                                            <label >
                                              SMS
                                            </label>
                                        </div>
                                      </div>
                                      <!--<div class="col-lg-4">-->
                                      <!--  <div class="form-checkbox" >-->
                                      <!--      <input type="radio" value="3" name="type_send" disabled>-->
                                      <!--      <label >-->
                                      <!--        whatsapp-->
                                      <!--      </label>-->
                                      <!--  </div>-->
                                      <!--</div>-->
                                  </div>
                              </div>
                        

                              <button  class="btn btn-xs big_button but_trans" type="submit">
                                إرسال
                              </button>
                          </form>
                          @endif

                      </div>


                  </div>
                  <div class="col">
                    <div class="title">
                        <h1>
                          <small>
                            أنا
                          </small>
	                          عميل
                          <small>
                            في  
                            {{env("APP_NAME")}} 
                          </small>
                        </h1>
                        <p>
                         تسجيل الدخول
                        </p>
                    </div>

                  </div>
              </div>
          </div>
      </section>

    </main>


@endsection
