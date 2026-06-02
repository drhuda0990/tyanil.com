@extends('layouts.app')
@section('title', $mainCategory->title)

@section('SCSS')
@endsection

@section('content')
    <section class="banner-inner-area store-page-hero sub-bg bg-image"
        data-background="{{ asset('frontend/images/bg/banner-inner-bg.png') }}">
        <div class="banner-inner__shape1">
            <img class="animation__sunMove" src="{{ asset('frontend/images/shape/banner-inner-shape1.png') }}" alt="image">
        </div>
        <div class="banner-inner__shape2">
            <img src="{{ asset('frontend/images/shape/banner-inner-shape2.png') }}" alt="image">
        </div>
        <div class="banner-inner__shape3">
            <img class="animation__arryLeftRight" src="{{ asset('frontend/images/shape/banner-inner-shape3.png') }}"
                alt="image">
        </div>
        <div class="banner-inner__shape4">
            <img class="animation__arryUpDown" src="{{ asset('frontend/images/shape/banner-inner-shape4.png') }}"
                alt="image">
        </div>
        <div class="container">
            <div class="banner-inner__content">
                <h1>{{ $mainCategory->title }}</h1>
                <ul>
                    <li><a href="{{ route('index') }}">الرئيسية</a></li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li>{{ $mainCategory->title }}</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="topic-area store-category-page store-products-page pt-120 pb-120">
        <div class="container">
            <div class="store-products-toolbar">
                <div>
                    <span class="store-product-kicker">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>قسم تيانيل</span>
                    </span>
                    <h2>{{ $mainCategory->title }}</h2>
                    <p>{!! \App\Support\SafeHtml::clean($mainCategory->details) !!}</p>
                </div>
                <a class="store-products-count" href="{{ route('category.services', ['id' => $mainCategory->id, 'sub' => 'all']) }}">
                    {{ $services->count() }} منتج
                </a>
            </div>

            @if ($services->count() > 0)
                <div class="row g-4 rtlDirection">
                    @foreach ($services as $service)
                        <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                            @include('homepage.serviceCard')
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($mainCategory->serviceActivateSubCategories->count() > 0)
                <div class="section-header mt-80 mb-40 text-center">
                    <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">أقسام فرعية</h5>
                </div>
                <div class="row g-4 rtlDirection">
                    @foreach ($mainCategory->serviceActivateSubCategories as $sCategory)
                        <div class="col-xl-4 col-md-6 wow fadeInLeft rtlDirection" data-wow-delay="00ms"
                            data-wow-duration="1500ms">
                            <a class="topic__item store-category-card item-one bGwhite active"
                                href="{{ route('category.services', ['id' => $sCategory->id, 'sub' => 1]) }}">
                                <div class="topic__icon">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <div class="topic__content">
                                    <h4>{{ $sCategory->title }}</h4>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

@section('JScript')
@endsection
