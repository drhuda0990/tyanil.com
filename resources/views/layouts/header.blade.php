<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    @php
        $defaultDescription = trim(preg_replace('/\s+/u', ' ', strip_tags(($gSetting->about ?? '') . ' ' . ($gSetting->summary ?? ''))));
        $defaultDescription = $defaultDescription ?: 'تيانيل متجر نسائي فاخر يجمع الكروشيه، الأزياء، الشنط، الأحذية، الأكسسوارات، ومكياج الجمال.';
        $seoTitle = trim($__env->yieldContent('meta_title')) ?: trim($__env->yieldContent('title')) ?: $gSetting->name;
        $seoDescription = trim($__env->yieldContent('meta_description')) ?: \Illuminate\Support\Str::limit($defaultDescription, 155, '');
        $seoUrl = trim($__env->yieldContent('canonical')) ?: url()->current();
        $seoImage = trim($__env->yieldContent('og_image')) ?: asset('storage/' . ($gSetting->logo2 ?: $gSetting->logo));
        $seoType = trim($__env->yieldContent('og_type')) ?: 'website';
    @endphp
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoTitle }}</title>

    <meta name="description" content="{{ $seoDescription }}" />
    <meta name="keywords" content="تيانيل, Tyaniel, متجر نسائي, منتجات نسائية, كروشيه, أزياء, شنط, أحذية, أكسسوارات, مكياج, تجميل">
    <meta name="author" content="{{ $gSetting->name }}">
    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ $seoUrl }}">
    <meta property="og:locale" content="ar_SA">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:site_name" content="{{ $gSetting->name }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <!-- Favicon img -->
    <link rel="shortcut icon" href="{{ asset("storage/$gSetting->favicon") }}">
    <!-- Bootstarp min css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <!-- Mean menu css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/meanmenu.css') }}">
    <!-- All min css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <!-- Swiper bundle min css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}">
    <!-- Magnigic popup css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <!-- Nice select css -->
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}"> --}}
    <!-- Style css -->
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('homepage.style')

    @yield('SCSS')
    <style>
      
    </style>
</head>

<body>

    <?php
    $mCategories = App\ServiceCategory::where([['activate', 1], ['main_category', 1]])->get(); ?>
    <!-- Preloader area start -->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="loading-icon store-page-loader text-center d-flex flex-column align-items-center justify-content-center" aria-live="polite">
                    <div class="store-page-loader__icon" aria-hidden="true">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="store-page-loader__brand">
                        <span class="tr-ar">تيانيل</span>
                        <span class="tr-en">Tyaniel</span>
                    </div>
                    <div class="store-page-loader__bar" aria-hidden="true">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader area end -->

    <!-- Header area start here -->
    <header class="header-area rtlDirection">
        <div class="header__container">
            <div class="header__main">
                <a href="{{ route('index') }}" class="logo logo--header-primary">
                    <img src="{{ asset('storage/' . ($gSetting->logo2 ?: $gSetting->logo)) }}" alt="{{ $gSetting->name }}">
                </a>
                <div class="main-menu">
                    <nav>
                        <ul>
                            <li>
                                <a href="{{ route('index') }}"><span class="tr-ar">الرئيسية</span><span class="tr-en">Home</span>
                                    {{-- <i class="fa-solid fa-angle-down"></i> --}}
                                </a>
                                {{-- <ul class="sub-menu">
                                    <li>
                                        <a href="index.html">Online Academy 1</a>
                                    </li>
                                   
                                </ul> --}}
                            </li>

                            <li>
                                <a href="#0"><span class="tr-ar">المنتجات</span><span class="tr-en">Products</span> <i class="fa-solid fa-angle-down"></i></a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="{{ route('category.services', ['id' => 'all']) }}"><span class="tr-ar">جميع المنتجات</span><span class="tr-en">All products</span></a>
                                    </li>
                                    @foreach ($mCategories as $category)
                                        <li>
                                            <a href="{{ route('category.show', ['id' => $category->id, 'slug' => $category->slug]) }}">{{ $category->title }}</a>
                                        </li>
                                    @endforeach
                                    {{-- <li>
                                        <a href="#0">Courses Details <i class="fa-solid fa-angle-down"></i></a>
                                        <ul class="sub-sub-menu">
                                            <li>
                                                <a href="course-details.html">Courses Details 1</a>
                                            </li>
                                            <li>
                                                <a href="course-details-2.html">Courses Details 2</a>
                                            </li>
                                        </ul>
                                    </li> --}}
                                </ul>
                            </li>
                            @if (Auth::guard('customer')->user())
                                <li>
                                    <a href="#0"> <i class="fa-solid fa-user"></i>
                                        {{ Auth::guard('customer')->user()->name ? Auth::guard('customer')->user()->name : 'لوحة التحكم' }}
                                        <i class="fa-solid fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('customer.info') }}"><span class="tr-ar">معلوماتي</span><span class="tr-en">Profile</span></a>
                                        </li>
                                        {{-- <li>
                                            <a href="{{ route('cv.index') }}">السيرة الذاتية</a>
                                        </li> --}}
                                        <li>
                                            <a href="{{ route('customer.allAddress') }}"><span class="tr-ar">العناوين</span><span class="tr-en">Addresses</span></a>
                                        </li>
                                        <li>
                                            <a href="{{ route('customer.services') }}"><span class="tr-ar">طلباتي</span><span class="tr-en">Orders</span></a>
                                        </li>
                                        <li>

                                            <form method="POST" action="{{ route('customer.logout') }}">
                                                @csrf
                                                <a> <button type="submit" style="white">

                                                        <span class="tr-ar">تسجيل خروج</span><span class="tr-en">Logout</span>
                                                    </button>
                                                </a>
                                            </form>

                                        </li>

                                    </ul>
                                </li>
                            @endif
                            <li><a href="{{ route('contact') }}"><span class="tr-ar">اتصل بنا</span><span class="tr-en">Contact us</span></a></li>
                        </ul>
                    </nav>
                </div>
                <div class="header-actions d-flex align-items-center gap-4 gap-xl-5">
                    <div class="language-switch" aria-label="Language switcher">
                        <button type="button" class="language-switch__btn active" data-lang-switch="ar">AR</button>
                        <button type="button" class="language-switch__btn" data-lang-switch="en">EN</button>
                    </div>
                    <div class="menu-search">
                        <form role="search" method="get" action="{{ url('search') }}" id="searchform">
                            <input type="text" class="mb-0" name="search_input" placeholder="إبحث هنا"
                                data-placeholder-ar="إبحث هنا" data-placeholder-en="Search products">
                            <button><i class="fa-regular fa-magnifying-glass"></i></button>
                        </form>

                    </div>
                    <?php
                    $total_item = Auth::guard('customer')->user() ? count(Auth::guard('customer')->user()->carts) : count(App\Cart::where([['user_ip', $_SERVER['REMOTE_ADDR']], ['customer_id', null]])->get());
                    $customerUnreadNotifications = 0;
                    if (Auth::guard('customer')->user() && \Illuminate\Support\Facades\Schema::hasTable('store_notifications')) {
                        $customerUnreadNotifications = App\StoreNotification::where('audience', 'customer')
                            ->where('customer_id', Auth::guard('customer')->id())
                            ->whereNull('read_at')
                            ->count();
                    }
                    ?>
                    @if (Auth::guard('customer')->user())
                        <a href="{{ route('customer.notifications') }}" class="notificationBut" aria-label="Notifications">
                            <span class="notificationNum" data-count="{{ $customerUnreadNotifications }}">
                                {{ $customerUnreadNotifications }}
                                <i class="fa-solid fa-bell"></i>
                            </span>
                        </a>
                    @endif
                    <button type="button" class="ty-header-action ty-search-action d-lg-none"
                        data-bs-toggle="offcanvas" data-bs-target="#menubar" data-mobile-search-trigger="true"
                        aria-label="فتح البحث">
                        <i class="fa-regular fa-magnifying-glass"></i>
                    </button>
                    <a href="{{ route('customer.cart') }}" class="cartBut ty-header-action ty-cart-action"
                        aria-label="سلة التسوق">
                        <span class="ty-cart-action__icon" aria-hidden="true">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </span>
                        <span class="cartNum ty-cart-action__count" data-count="{{ $total_item }}">
                            {{ $total_item }}
                        </span>
                    </a>

                    <div class="menu-btns d-none d-lg-flex">

                        @if (!Auth::guard('customer')->user())
                            <a class="active" href="{{ route('customer.login') }}"><span class="tr-ar">تسجيل الدخول</span><span class="tr-en">Login</span></a>
                        @endif

                    </div>
                </div>
                <button class="menubars d-block d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#menubar">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>
    <!-- Header area end here -->

    <!-- Sidebar area start here -->
    <div class="sidebar-area offcanvas offcanvas-end rtlDirection" id="menubar">
        <div class="offcanvas-header">
            <a href="{{ route('index') }}" class="logo logo--sidebar ty-sidebar-brand">
                <img src="{{ asset("storage/$gSetting->logo") }}" alt="{{ $gSetting->name }}">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"><i
                    class="fa-regular fa-xmark"></i></button>
        </div>
        <div class="offcanvas-body sidebar__body">

            <div class="mobile-menu overflow-hidden"></div>
            <nav class="ty-mobile-nav" aria-label="Mobile navigation">
                <a href="{{ route('index') }}">
                    <i class="fa-solid fa-house"></i>
                    <span class="tr-ar">الرئيسية</span>
                    <span class="tr-en">Home</span>
                </a>
                <a href="{{ route('category.services', ['id' => 'all']) }}">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="tr-ar">جميع المنتجات</span>
                    <span class="tr-en">All products</span>
                </a>
                @foreach ($mCategories as $category)
                    <a href="{{ route('category.show', ['id' => $category->id, 'slug' => $category->slug]) }}">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>{{ $category->title }}</span>
                    </a>
                @endforeach
                <a href="{{ route('contact') }}">
                    <i class="fa-solid fa-envelope"></i>
                    <span class="tr-ar">اتصل بنا</span>
                    <span class="tr-en">Contact us</span>
                </a>
                @if (Auth::guard('customer')->user())
                    <a href="{{ route('customer.services') }}">
                        <i class="fa-solid fa-receipt"></i>
                        <span class="tr-ar">طلباتي</span>
                        <span class="tr-en">Orders</span>
                    </a>
                    <a href="{{ route('customer.info') }}">
                        <i class="fa-solid fa-user"></i>
                        <span class="tr-ar">معلوماتي</span>
                        <span class="tr-en">Profile</span>
                    </a>
                @endif
            </nav>
            <div class="sidebar__search d-block d-lg-none">
                <form role="search" method="get" action="{{ url('search') }}" id="searchform">
                    <input type="text" class="js-mobile-search-input" name="search_input" placeholder="إبحث هنا"
                        data-placeholder-ar="إبحث هنا" data-placeholder-en="Search products">
                    <button><i class="fa-regular fa-magnifying-glass"></i></button>
                </form>

            </div>
            <div class="language-switch sidebar-language" aria-label="Language switcher">
                <button type="button" class="language-switch__btn active" data-lang-switch="ar">AR</button>
                <button type="button" class="language-switch__btn" data-lang-switch="en">EN</button>
            </div>
            <div class="sidebar__btns my-4">
                @if (!Auth::guard('customer')->user())
                    <a class="sign-in" href="{{ route('customer.login') }}"><span class="tr-ar">تسجيل الدخول</span><span class="tr-en">Login</span></a>
                @else
                    <a class="sign-in" href="{{ route('customer.notifications') }}"><span class="tr-ar">الإشعارات</span><span class="tr-en">Notifications</span></a>
                    <form method="POST" action="{{ route('customer.logout') }}" class="ty-mobile-logout">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span class="tr-ar">تسجيل خروج</span>
                            <span class="tr-en">Logout</span>
                        </button>
                    </form>
                @endif

            </div>

        </div>
    </div>
    <!-- Sidebar area end here -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-mobile-search-trigger]').forEach((trigger) => {
                trigger.addEventListener('click', () => {
                    const sidebar = document.getElementById('menubar');
                    if (!sidebar) {
                        return;
                    }

                    sidebar.addEventListener('shown.bs.offcanvas', () => {
                        sidebar.querySelector('.js-mobile-search-input')?.focus();
                    }, { once: true });
                });
            });
        });
    </script>
