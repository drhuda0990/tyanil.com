@extends('layouts.app')

@section('content')
    <main>

        <section class="section-block section-block-full " style="text-align: center;background:#f8f8f8;">
    
                {{-- <div class="block-media">
                    <div class="image" style='background-image:url("https://img.freepik.com/free-photo/copy-space-kids-with-books_23-2148480229.jpg?t=st=1714438416~exp=1714442016~hmac=4ac71caf68a9b0defd71e20681bb51729cd66eaed9b32a9096487d00428367b7&w=740")'></div>
                </div> --}}
      
            <div class="container" style="width: 100%">
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
                                    <input id="code_send" minlength="5" maxlength="6" type="text" pattern="[0-9]+"
                                        class="input-text En" name="code_send" value="{{ old('code_send') }}" required
                                        autofocus>
                                    <br>
                                    <button class="btn btn-xs" type="submit">
                                        تأكيد
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('trainee.login') }}">
                                    @csrf
                                    <br>
                                    <h2>
                                        تسجيل الدخول
                                    </h2>
                                    <hr>
                                    <span class="space-xs"></span>
                                    <span class="space-xs"></span>

                                    <div class="row rtl">
                                        <input name="select_input" value="1" type="hidden">

                                        {{-- <div class="col-lg-5">
                                    <select name="select_input" class="input-select">
                                          <option value="1" selected> البريد الإلكتروني </option>
                                          <option value="2"> رقم الجوال </option>
                                          <option value="3"> رقم الهوية </option>
                                    </select>
                                  </div>
                                  <div class="col-lg-7"> --}}
                                        <input id="input_send" type="text"
                                            class="input-text  @error('input_send') is-invalid @enderror" name="input_send"
                                            placeholder="الإيميل \ الهوية \ رقم الجوال" value="{{ old('input_send') }}"
                                            required autocomplete="input_send" autofocus>
                                        {{-- </div>
                                   <div class="col-12"> --}}
                                        <input id="password" type="password"
                                            class="input-text  @error('password') is-invalid @enderror"
                                            placeholder="كلمة المرور" name="password" value="{{ old('password') }}" required
                                            autocomplete="password">
                                        {{-- </div> --}}


                                    </div>
                                    <br>
                                    <a href="{{ route('trainee.forget') }}" style="float:left">
                                        نسيت كلمة المرور
                                    </a>
                                    <span class="space-xs"></span>

                                    <br>
                                    <button class="btn-xs btncustomSwalBtn big_button but_trans" type="submit">
                                        دخول
                                    </button>
                                    <br>
                                    <hr>
                                    <a href="{{ route('trainee.register') }}"
                                        class="btn btn-border btn-xs big_button but_color">
                                        إنضم إلينا
                                    </a>
                                    <br>


                                </form>
                            @endif

                        </div>


                    </div>
                    <div class="col">

                        {{-- <img src="{{ asset('images/medium-shot.jpg') }}"
                    /> --}}
                        <img style="    max-width: 110%;
                    height: 100%;
                    margin-right: 100px;
                    vertical-align: middle;"
                            src="https://img.freepik.com/free-photo/copy-space-kids-with-books_23-2148480229.jpg?t=st=1714438416~exp=1714442016~hmac=4ac71caf68a9b0defd71e20681bb51729cd66eaed9b32a9096487d00428367b7&w=740" />
                    </div>
                </div>
            </div>
        </section>

    </main>


@endsection
