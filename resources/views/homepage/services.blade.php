@extends('layouts.app')
@section('title', isset($category) ? $category->title : 'منتجات تيانيل | Tyaniel Products')
<!--* ********************************* -->
@section('SCSS')

@endsection
<!--* ********************************* -->
@section('content')
    <!--* ********************************* -->
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
                    @if (isset($category))
                        {{ $category->title }}
                    @else
                        المنتجات | Products
                    @endif
                </h1>
                <ul>
                    <li><a href="{{ route('index') }}">الصفحة الرئيسية</a></li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li>
                        @if (isset($category))
                            {{ $category->title }}
                        @else
                            المنتجات | Products
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="blog-area store-products-page pt-120 pb-120">
        <div class="container">
            <div class="store-products-toolbar">
                <div>
                    <span class="store-product-kicker">
                        <i class="fa-solid fa-store"></i>
                        <span>منتجات تيانيل | Tyaniel products</span>
                    </span>
                    <h2>
                        @if (isset($category))
                            {{ $category->title }}
                        @else
                            منتجات نسائية مختارة جاهزة للطلب
                        @endif
                    </h2>
                    <p>تصفحي قطع تيانيل بتفاصيل واضحة وصور ناعمة وأسعار جاهزة للطلب.</p>
                </div>
                <span class="store-products-count">
                    {{ $services->count() }} منتج
                </span>
            </div>
            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                        @include('homepage.serviceCard')
                    </div>
                @endforeach
                {{-- <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <div class="blog__item p-4">
                        <a href="blog-details.html" class="blog__image d-block image">
                            <img src="assets/images/blog/blog-image1.jpg" alt="image">
                        </a>
                        <div class="blog__content">
                            <div class="blog-tag">
                                <h3 class="text-white">15</h3>
                                <span class="text-white">Dec</span>
                            </div>
                            <ul class="blog-info mb-20 mt-40">
                                <li>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="https://www.w3.org/2000/svg">
                                        <path
                                            d="M14.5436 5.19275C14.5436 7.69093 12.499 9.7355 10.0008 9.7355C7.50268 9.7355 5.45811 7.69093 5.45811 5.19275C5.45811 2.69457 7.50264 0.65 10.0008 0.65C12.499 0.65 14.5436 2.69458 14.5436 5.19275Z"
                                            stroke="#8FAF8B" stroke-width="1.3" />
                                        <path
                                            d="M18.2644 14.6706C18.1052 14.9458 17.9241 15.2073 17.7169 15.4766L17.7168 15.4765L17.7089 15.4873C17.4204 15.8788 17.0845 16.2373 16.7295 16.5924C16.4326 16.8892 16.0933 17.186 15.7568 17.4385C14.0794 18.6911 12.0622 19.3499 9.97818 19.3499C7.8984 19.3499 5.8851 18.6938 4.2098 17.4461C3.84591 17.1504 3.51371 16.8792 3.2269 16.5924L3.21993 16.5854L3.21276 16.5787C2.85667 16.2436 2.54242 15.8877 2.24749 15.4874L2.24751 15.4873L2.24417 15.4829C2.06196 15.24 1.87324 14.9756 1.71923 14.7169C1.83622 14.4559 1.98458 14.1847 2.14525 13.9526L2.14536 13.9527L2.15288 13.9413C3.06988 12.5556 4.53709 11.6388 6.16646 11.4148L6.18604 11.4121L6.20542 11.4082C6.2309 11.4031 6.29498 11.4117 6.34551 11.4496L6.3455 11.4496L6.34951 11.4525C7.41654 12.2401 8.68633 12.6453 10.0008 12.6453C11.3153 12.6453 12.5851 12.2401 13.6522 11.4525L13.6522 11.4525L13.6562 11.4496C13.6716 11.438 13.7404 11.408 13.8492 11.4167C15.4689 11.6435 16.9121 12.5568 17.8525 13.9468L17.8524 13.9469L17.8564 13.9526C18.0166 14.1839 18.1557 14.4231 18.2644 14.6706Z"
                                            stroke="#8FAF8B" stroke-width="1.3" />
                                    </svg>
                                    <a href="#0">By Admin</a>
                                </li>
                                <li>
                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                        xmlns="https://www.w3.org/2000/svg">
                                        <path
                                            d="M8.05666 18.75H8.05504C7.46832 18.7495 6.91657 18.5207 6.50187 18.1052L0.660341 12.2553C-0.194072 11.3994 -0.194072 10.0065 0.660341 9.15058L8.53478 1.26102C9.3463 0.44792 10.426 0 11.575 0H16.5709C17.7824 0 18.7682 0.985546 18.7682 2.19726V7.17785C18.7682 8.32602 18.3208 9.40532 17.5084 10.2167L9.60951 18.1074C9.19455 18.5218 8.64306 18.75 8.05666 18.75ZM11.575 1.46484C10.8179 1.46484 10.1064 1.75998 9.57163 2.29579L1.69707 10.1853C1.41222 10.4708 1.41222 10.9349 1.69707 11.2203L7.53857 17.0702C7.6767 17.2086 7.86051 17.285 8.05619 17.2851H8.05677C8.1529 17.2854 8.24812 17.2666 8.33694 17.2299C8.42577 17.1931 8.50643 17.1391 8.57427 17.071L16.4732 9.18046C17.0086 8.6458 17.3034 7.93447 17.3034 7.17788V2.19726C17.3034 1.79341 16.9748 1.46484 16.5709 1.46484H11.575ZM13.458 7.43408C12.2465 7.43408 11.2608 6.44853 11.2608 5.23681C11.2608 4.0251 12.2465 3.03955 13.458 3.03955C14.6696 3.03955 15.6553 4.0251 15.6553 5.23681C15.6553 6.44853 14.6696 7.43408 13.458 7.43408ZM13.458 4.50439C13.0542 4.50439 12.7256 4.83296 12.7256 5.23681C12.7256 5.64067 13.0542 5.96924 13.458 5.96924C13.862 5.96924 14.1905 5.64067 14.1905 5.23681C14.1905 4.83296 13.862 4.50439 13.458 4.50439Z"
                                            fill="#8FAF8B" />
                                    </svg>

                                    <a href="#0">Technology</a>
                                </li>
                            </ul>
                            <h3><a href="blog-details.html" class="primary-hover">Fixing Tailbone Back <br> Problems
                                    Possible</a></h3>
                            <a class="mt-15 read-more-btn" href="blog-details.html">Read More <i
                                    class="fa-regular fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>



    <!--* ********************************* -->
@endsection
<!--* ********************************* -->
@section('JScript')

@endsection
