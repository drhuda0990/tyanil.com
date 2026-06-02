@extends('layouts.app')
@section('title', $Post_id->title )
<!--* ********************************* -->
@section('SCSS')

@endsection
<!--* ********************************* -->
@section('content')
    <!--* ********************************* -->
    <section class="banner-inner-area store-page-hero sub-bg bg-image" data-background="{{ asset('frontend/images/bg/banner-inner-bg.png') }}">
        <div class="banner-inner__shape1">
            <img class="animation__sunMove" src="{{ asset('frontend/images/shape/banner-inner-shape1.png') }}" alt="image">
        </div>
        <div class="banner-inner__shape2">
            <img src="{{ asset('frontend/images/shape/banner-inner-shape2.png') }}" alt="image">
        </div>
        <div class="banner-inner__shape3">
            <img class="animation__arryLeftRight" src="{{ asset('frontend/images/shape/banner-inner-shape3.png') }}" alt="image">
        </div>
        <div class="banner-inner__shape4">
            <img class="animation__arryUpDown" src="{{ asset('frontend/images/shape/banner-inner-shape4.png') }}" alt="image">
        </div>
        <div class="banner-inner__shape5">
            <img src="{{ asset('frontend/images/shape/banner-inner-shape5.png') }}" alt="image">
        </div>
        <div class="banner-inner__circle">
            <img class="slide-effect1" src="{{ asset('frontend/images/shape/banner-inner-circle.png') }}" alt="image">
        </div>
        <div class="banner-inner__circle2">
            <img class="slide-effect2" src="{{ asset('frontend/images/shape/banner-inner-circle2.png') }}" alt="image">
        </div>
        <div class="banner-inner__dots">
            <img class="pxl-image-zoom" src="{{ asset('frontend/images/shape/banner-inner-dots.png') }}" alt="image">
        </div>
        <div class="container">
            <div class="banner-inner__content">
                <h1>
                    {{ $Post_id->title }}
                </h1>
                <ul>
                    <li><a href="{{ route('index') }}">الصفحة الرئيسية</a></li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li> {{ $Post_id->title }}</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Banner area end here -->
    <?php
    $img_post =null;
    $exists = Storage::disk('local')->exists('public/'.$Post_id->images);
    if ( ($exists == 1) and (!(empty($Post_id->images))) ){
      $img_post = (url('/storage').'/'.$Post_id->images);
    }?>
    <section class="store-policy-page pt-120 pb-120">
        <div class="container">
            <div class="store-policy-layout {{ $img_post ? 'has-image' : 'no-image' }}">
                @if($img_post)
                    <div class="store-policy-media wow fadeInRight" data-wow-delay="100ms" data-wow-duration="1200ms">
                        <img src="{{ $img_post }}" alt="{{ $Post_id->title }}">
                    </div>
                @endif
                <article class="store-policy-card wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1200ms">
                    <div class="store-policy-kicker">
                        <i class="fa-solid fa-shield-check"></i>
                        <span class="tr-ar">سياسات المتجر</span>
                        <span class="tr-en">Store policies</span>
                    </div>
                    <h2>{{ $Post_id->title }}</h2>
                    <div class="store-policy-content">
                        {!! \App\Support\SafeHtml::clean($Post_id->body) !!}
                    </div>
                </article>
            </div>
        </div>
    </section>
   

    <!--* ********************************* -->
@endsection
<!--* ********************************* -->
@section('JScript')

@endsection
