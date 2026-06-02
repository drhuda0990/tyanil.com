@extends('layouts.app')
@section('title', $gSetting->name . ' | ' . $gSetting->name_en)

@section('SCSS')
    <style>
        .ty-home {
            --ty-plum: #4B213F;
            --ty-rose: #D989A3;
            --ty-ivory: #FFF4EF;
            --ty-gold: #B88A5A;
            --ty-ink: #2C1830;
            --ty-muted: #735C68;
            --ty-border: rgba(75, 33, 63, .12);
            background:
                linear-gradient(120deg, rgba(217, 137, 163, .12), transparent 38%),
                linear-gradient(270deg, rgba(184, 138, 90, .10), transparent 42%),
                var(--ty-ivory);
            color: var(--ty-muted);
            overflow: hidden;
        }

        .ty-home *,
        .ty-home *::before,
        .ty-home *::after {
            letter-spacing: 0;
        }

        .ty-hero {
            position: relative;
            min-height: min(760px, calc(100vh - 86px));
            padding: 44px 0 62px;
            background:
                linear-gradient(90deg, rgba(75, 33, 63, .045) 1px, transparent 1px),
                linear-gradient(180deg, rgba(75, 33, 63, .04) 1px, transparent 1px);
            background-size: 46px 46px;
        }

        .ty-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, rgba(255, 255, 255, .62), transparent 44%, rgba(255, 255, 255, .34));
            pointer-events: none;
        }

        .ty-hero > .container,
        .ty-section > .container {
            position: relative;
            z-index: 1;
        }

        .ty-hero__grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, .9fr);
            gap: 34px;
            align-items: center;
        }

        .ty-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 42px;
            padding: 8px 14px;
            border: 1px solid rgba(255, 255, 255, .76);
            border-radius: 999px;
            color: var(--ty-plum);
            background: rgba(255, 255, 255, .54);
            box-shadow: 0 18px 48px rgba(75, 33, 63, .08);
            backdrop-filter: blur(18px);
            font-size: 14px;
            font-weight: 900;
        }

        .ty-eyebrow i {
            color: var(--ty-gold);
        }

        .ty-hero h1 {
            max-width: 720px;
            margin-top: 18px;
            color: var(--ty-plum);
            font-size: 62px;
            line-height: 1.05;
            font-weight: 900;
        }

        .ty-hero h1 .ty-h1-accent {
            color: var(--ty-rose);
        }

        .ty-hero__lead {
            max-width: 680px;
            margin-top: 16px;
            color: var(--ty-muted);
            font-size: 19px;
            line-height: 1.9;
            font-weight: 600;
        }

        .ty-hero__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 26px;
        }

        .ty-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 52px;
            padding: 0 22px;
            border-radius: 8px;
            border: 1px solid transparent;
            color: var(--ty-ivory);
            background: var(--ty-plum);
            box-shadow: 0 20px 42px rgba(75, 33, 63, .20);
            font-weight: 900;
            white-space: nowrap;
        }

        .ty-btn:hover {
            color: var(--ty-ivory);
            transform: translateY(-2px);
            background: #35162E;
        }

        .ty-btn span,
        .ty-btn i,
        .ty-buy-btn span,
        .ty-buy-btn i {
            color: inherit !important;
            opacity: 1 !important;
        }

        .ty-btn--glass {
            color: var(--ty-plum);
            background: rgba(255, 255, 255, .56);
            border-color: rgba(255, 255, 255, .72);
            box-shadow: 0 18px 38px rgba(75, 33, 63, .10);
            backdrop-filter: blur(16px);
        }

        .ty-btn--glass:hover {
            color: var(--ty-plum);
            background: rgba(255, 255, 255, .78);
        }

        .ty-hero__metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            max-width: 640px;
            margin-top: 26px;
        }

        .ty-metric {
            min-height: 94px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, .72);
            border-radius: 8px;
            background: rgba(255, 255, 255, .48);
            box-shadow: 0 18px 44px rgba(75, 33, 63, .08);
            backdrop-filter: blur(16px);
        }

        .ty-metric strong {
            display: block;
            color: var(--ty-plum);
            font-size: 26px;
            line-height: 1.2;
            font-weight: 900;
        }

        .ty-metric span {
            margin-top: 4px;
            color: var(--ty-muted);
            font-size: 13px;
            font-weight: 800;
        }

        .ty-hero__visual {
            position: relative;
            min-height: 488px;
            perspective: 1200px;
        }

        #tyanielHeroCanvas {
            position: absolute;
            inset: -36px -24px 78px -24px;
            width: calc(100% + 48px);
            height: 440px;
            cursor: grab;
        }

        #tyanielHeroCanvas:active {
            cursor: grabbing;
        }

        .ty-hero__halo {
            position: absolute;
            right: 5%;
            bottom: 112px;
            left: 8%;
            height: 92px;
            border-radius: 50%;
            background: rgba(75, 33, 63, .10);
            filter: blur(18px);
            pointer-events: none;
        }

        .ty-mini-strip {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .ty-mini-product {
            display: grid;
            grid-template-columns: 72px minmax(0, 1fr);
            gap: 12px;
            align-items: center;
            min-height: 100px;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, .76);
            border-radius: 8px;
            background: rgba(255, 255, 255, .58);
            box-shadow: 0 22px 54px rgba(75, 33, 63, .13);
            backdrop-filter: blur(18px);
        }

        .ty-mini-product:hover {
            transform: translateY(-3px);
        }

        .ty-mini-product img {
            width: 72px;
            height: 72px;
            border-radius: 8px;
            object-fit: cover;
            background: var(--ty-ivory);
        }

        .ty-mini-product strong {
            display: block;
            color: var(--ty-plum);
            font-size: 14px;
            line-height: 1.45;
            font-weight: 900;
        }

        .ty-mini-product span {
            color: var(--ty-gold);
            font-size: 13px;
            font-weight: 900;
        }

        .ty-section {
            position: relative;
            scroll-margin-top: 104px;
            padding: 86px 0;
            background: rgba(255, 255, 255, .52);
        }

        .ty-section--soft {
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .55), rgba(255, 244, 239, .92)),
                var(--ty-ivory);
        }

        .ty-section__head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 34px;
        }

        .ty-kicker {
            color: var(--ty-gold);
            font-size: 14px;
            font-weight: 900;
        }

        .ty-section h2 {
            max-width: 720px;
            margin-top: 8px;
            color: var(--ty-plum);
            font-size: 40px;
            line-height: 1.22;
            font-weight: 900;
        }

        .ty-section__copy {
            max-width: 470px;
            color: var(--ty-muted);
            font-size: 17px;
            line-height: 1.8;
            font-weight: 600;
        }

        .ty-products-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .ty-product-card {
            border: 1px solid rgba(75, 33, 63, .10);
            border-radius: 8px;
            background: rgba(255, 255, 255, .62);
            box-shadow: 0 24px 58px rgba(75, 33, 63, .10);
            overflow: hidden;
            transform-style: preserve-3d;
            backdrop-filter: blur(14px);
        }

        .ty-product-card:hover {
            transform: translateY(-6px) rotateX(1deg) rotateY(-1deg);
            box-shadow: 0 32px 74px rgba(75, 33, 63, .16);
        }

        .ty-product-card__media {
            position: relative;
            display: block;
            aspect-ratio: 1.24 / 1;
            overflow: hidden;
            background: var(--ty-ivory);
        }

        .ty-product-card__media::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, rgba(255, 255, 255, .42), transparent 34%, rgba(255, 255, 255, .30));
            opacity: .68;
            pointer-events: none;
        }

        .ty-product-card__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ty-product-card__badge {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 1;
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--ty-plum);
            background: rgba(255, 255, 255, .72);
            border: 1px solid rgba(255, 255, 255, .82);
            font-size: 12px;
            font-weight: 900;
            backdrop-filter: blur(12px);
        }

        .ty-product-card__body {
            padding: 20px;
        }

        .ty-product-card h3 {
            color: var(--ty-plum);
            font-size: 21px;
            line-height: 1.35;
            font-weight: 900;
        }

        .ty-product-card p {
            min-height: 78px;
            margin-top: 10px;
            color: var(--ty-muted);
            font-size: 15px;
            line-height: 1.7;
        }

        .ty-product-card__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 16px;
        }

        .ty-price {
            color: var(--ty-plum);
            font-size: 20px;
            font-weight: 900;
            white-space: nowrap;
        }

        .ty-card-actions {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .ty-icon-btn,
        .ty-buy-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            border-radius: 8px;
            font-weight: 900;
        }

        .ty-icon-btn {
            width: 42px;
            color: var(--ty-plum);
            border: 1px solid var(--ty-border);
            background: rgba(255, 255, 255, .64);
        }

        .ty-icon-btn:hover {
            color: var(--ty-ivory);
            background: var(--ty-plum);
        }

        .ty-buy-btn {
            min-width: 94px;
            padding: 0 14px;
            color: var(--ty-ivory);
            background: var(--ty-rose);
        }

        .ty-buy-btn:hover {
            color: var(--ty-ivory);
            background: var(--ty-plum);
        }

        .ty-benefits {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .ty-benefit {
            min-height: 182px;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, .76);
            border-radius: 8px;
            background: rgba(255, 255, 255, .56);
            box-shadow: 0 20px 48px rgba(75, 33, 63, .08);
            backdrop-filter: blur(16px);
        }

        .ty-benefit i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            margin-bottom: 18px;
            border-radius: 8px;
            color: var(--ty-ivory);
            background: var(--ty-plum);
        }

        .ty-benefit h3 {
            color: var(--ty-plum);
            font-size: 18px;
            font-weight: 900;
        }

        .ty-benefit p {
            margin-top: 8px;
            color: var(--ty-muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .ty-categories {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .ty-category {
            position: relative;
            min-height: 270px;
            padding: 24px;
            border-radius: 8px;
            overflow: hidden;
            background: var(--ty-plum);
            color: var(--ty-ivory);
            box-shadow: 0 26px 58px rgba(75, 33, 63, .16);
        }

        .ty-category img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .38;
            transform: scale(1.02);
        }

        .ty-category::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(75, 33, 63, .10), rgba(75, 33, 63, .82));
        }

        .ty-category:hover img {
            transform: scale(1.07);
            opacity: .52;
        }

        .ty-category__content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 222px;
        }

        .ty-category h3,
        .ty-category p,
        .ty-category span,
        .ty-category i {
            color: var(--ty-ivory) !important;
        }

        .ty-category h3 {
            font-size: 27px;
            line-height: 1.3;
            font-weight: 900;
        }

        .ty-category p {
            margin-top: 10px;
            color: rgba(255, 244, 239, .86) !important;
            line-height: 1.7;
        }

        .ty-category span {
            margin-top: 18px;
            font-weight: 900;
        }

        .ty-cta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 42px;
            border: 1px solid rgba(255, 255, 255, .72);
            border-radius: 8px;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .18), transparent 46%),
                var(--ty-plum);
            color: var(--ty-ivory);
            box-shadow: 0 28px 70px rgba(75, 33, 63, .18);
        }

        .ty-cta h2,
        .ty-cta p,
        .ty-cta h2 span,
        .ty-cta p span {
            color: var(--ty-ivory) !important;
        }

        .ty-cta h2 {
            font-size: 34px;
            font-weight: 900;
        }

        .ty-cta p {
            max-width: 680px;
            margin-top: 10px;
            color: rgba(255, 244, 239, .82) !important;
        }

        .ty-cta .ty-btn {
            color: var(--ty-plum);
            background: var(--ty-ivory);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .12);
        }

        .ty-cta .ty-btn:hover {
            color: var(--ty-plum);
            background: #FFFFFF;
        }

        body.lang-en .ty-product-card__badge {
            right: 14px;
            left: auto;
        }

        @media (max-width: 1199px) {
            .ty-hero__grid,
            .ty-products-grid,
            .ty-benefits,
            .ty-categories {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ty-hero__visual {
                grid-column: 1 / -1;
                min-height: 500px;
            }
        }

        @media (max-width: 767px) {
            .ty-home {
                display: flex;
                flex-direction: column;
            }

            .ty-hero {
                order: 1;
                min-height: auto;
                padding: 28px 0 38px;
            }

            .ty-hero__grid,
            .ty-products-grid,
            .ty-benefits {
                grid-template-columns: 1fr;
            }

            .ty-categories {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .ty-category {
                min-height: 150px;
                padding: 14px;
            }

            .ty-category__content {
                min-height: 122px;
            }

            .ty-category h3 {
                font-size: 18px;
                line-height: 1.35;
            }

            .ty-category p {
                display: none;
            }

            .ty-category span {
                margin-top: 8px;
                font-size: 12px;
            }

            .ty-hero h1 {
                font-size: 36px;
                line-height: 1.2;
            }

            .ty-hero__lead {
                margin-top: 12px;
            }

            .ty-hero__lead,
            .ty-section__copy {
                font-size: 16px;
            }

            .ty-hero__actions {
                gap: 10px;
                margin-top: 20px;
            }

            .ty-hero__actions .ty-btn {
                flex: 1 1 100%;
            }

            .ty-hero__metrics {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
                margin-top: 18px;
            }

            .ty-metric {
                display: grid;
                place-items: center;
                min-height: 72px;
                padding: 10px 8px;
                text-align: center;
            }

            .ty-metric strong {
                font-size: 15px;
                line-height: 1.35;
            }

            .ty-hero__content {
                order: 1;
            }

            .ty-hero__visual {
                order: 2;
                min-height: 352px;
                margin-top: 18px;
                margin-bottom: 0;
            }

            #tyanielHeroCanvas {
                inset: 0 0 auto;
                width: 100%;
                height: 338px;
            }

            .ty-hero__halo {
                right: 12%;
                bottom: 18px;
                left: 12%;
                height: 66px;
            }

            .ty-mini-strip {
                display: none;
            }

            .ty-section--categories {
                order: 2;
            }

            .ty-section--products {
                order: 3;
            }

            .ty-section--benefits {
                order: 4;
            }

            .ty-section--cta {
                order: 5;
            }

            .ty-section {
                padding: 52px 0;
            }

            .ty-section__head,
            .ty-cta {
                display: block;
            }

            .ty-section h2,
            .ty-cta h2 {
                font-size: 30px;
                line-height: 1.34;
            }

            .ty-cta {
                padding: 28px;
            }

            .ty-cta .ty-btn {
                margin-top: 22px;
            }

            .ty-products-grid {
                gap: 14px;
            }

            .ty-product-card {
                display: grid;
                grid-template-columns: 132px minmax(0, 1fr);
                min-height: 188px;
            }

            .ty-product-card:hover {
                transform: none;
            }

            .ty-product-card__media {
                height: 100%;
                min-height: 188px;
                aspect-ratio: auto;
            }

            .ty-product-card__badge {
                top: 10px;
                left: 10px;
                padding: 6px 9px;
                font-size: 11px;
            }

            .ty-product-card__body {
                display: flex;
                flex-direction: column;
                min-width: 0;
                padding: 14px;
            }

            .ty-product-card h3 {
                font-size: 17px;
                line-height: 1.35;
            }

            .ty-product-card p {
                display: -webkit-box;
                min-height: 0;
                margin-top: 7px;
                overflow: hidden;
                color: #735C68;
                font-size: 13px;
                line-height: 1.55;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
            }

            .ty-product-card__footer {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
                margin-top: auto;
            }

            .ty-price {
                font-size: 16px;
            }

            .ty-card-actions {
                width: 100%;
            }

            .ty-icon-btn {
                flex: 0 0 40px;
                width: 40px;
                height: 40px;
            }

            .ty-buy-btn {
                flex: 1 1 auto;
                min-width: 0;
                height: 40px;
                padding: 0 10px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $featuredServices = $services->take(9)->values();
        $featuredCategories = $mainCategories->sortBy('order_num')->take(6)->values();
        $badges = [
            1 => 'حرفة يدوية',
            2 => 'إطلالة فاخرة',
            3 => 'قطعة يومية',
            4 => 'للمناسبات',
            5 => 'تغليف هدية',
            6 => 'توهج ناعم',
        ];
    @endphp

    <div class="ty-home">
        <section class="ty-hero">
            <div class="container">
                <div class="ty-hero__grid">
                    <div class="ty-hero__content">
                        <div class="ty-eyebrow">
                            <i class="fa-solid fa-sparkles"></i>
                            <span class="tr-ar">اختيارات نسائية فاخرة</span>
                            <span class="tr-en">Luxury feminine picks</span>
                        </div>
                        <h1>
                            <span class="tr-ar">تيانيل، لمسة أنثوية <span class="ty-h1-accent">تليق بك</span></span>
                            <span class="tr-en">Tyaniel, feminine pieces <span class="ty-h1-accent">made for you</span></span>
                        </h1>
                        <p class="ty-hero__lead">
                            <span class="tr-ar">
                                متجر نسائي يجمع أعمال الكروشيه، الأزياء، الشنط، الأحذية، الأكسسوارات، ومكياج الجمال.
                            </span>
                            <span class="tr-en">
                                A polished boutique for crochet, fashion, bags, shoes, accessories, and beauty essentials.
                            </span>
                        </p>
                        <div class="ty-hero__actions">
                            <a class="ty-btn" href="#featured-products">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span class="tr-ar">تسوقي الآن</span>
                                <span class="tr-en">Shop now</span>
                            </a>
                            <a class="ty-btn ty-btn--glass" href="{{ route('customer.login') }}">
                                <i class="fa-solid fa-user-plus"></i>
                                <span class="tr-ar">انضمي إلينا</span>
                                <span class="tr-en">Join us</span>
                            </a>
                        </div>
                        <div class="ty-hero__metrics">
                            <div class="ty-metric">
                                <strong class="ty-metric__label tr-ar">جودة عالية</strong>
                                <strong class="ty-metric__label tr-en">High quality</strong>
                            </div>
                            <div class="ty-metric">
                                <strong class="ty-metric__label tr-ar">تسوق مرن</strong>
                                <strong class="ty-metric__label tr-en">Flexible shopping</strong>
                            </div>
                            <div class="ty-metric">
                                <strong class="ty-metric__label tr-ar">شحن سريع</strong>
                                <strong class="ty-metric__label tr-en">Fast shipping</strong>
                            </div>
                        </div>
                    </div>

                    <div class="ty-hero__visual" aria-label="Interactive Tyaniel 3D boutique scene">
                        <canvas id="tyanielHeroCanvas"></canvas>
                        <div class="ty-hero__halo" aria-hidden="true"></div>
                        <div class="ty-mini-strip">
                            @foreach ($featuredServices->take(3) as $service)
                                <a class="ty-mini-product" href="{{ route('service.show', ['id' => $service->seo_route_key]) }}">
                                    <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
                                    <span>
                                        <strong>{{ $service->title }}</strong>
                                        {{ number_format($service->price_1) }} SAR
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="featured-products" class="ty-section ty-section--products">
            <div class="container">
                <div class="ty-section__head">
                    <div>
                        <div class="ty-kicker">
                            <span class="tr-ar">منتجات تيانيل</span>
                            <span class="tr-en">Tyaniel products</span>
                        </div>
                        <h2>
                            <span class="tr-ar">احتياجاتك على ذوقك</span>
                            <span class="tr-en">Your essentials, your style</span>
                        </h2>
                    </div>
                    <p class="ty-section__copy">
                        <span class="tr-ar">مواصفات المنتجات</span>
                        <span class="tr-en">Product specifications</span>
                    </p>
                </div>

                <div class="ty-products-grid">
                    @foreach ($featuredServices as $service)
                        @php($summary = trim(strip_tags($service->summry ?? '')))
                        <article class="ty-product-card">
                            <a class="ty-product-card__media" href="{{ route('service.show', ['id' => $service->seo_route_key]) }}">
                                <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
                                <span class="ty-product-card__badge">{{ $badges[$service->id] ?? 'متوفر' }}</span>
                            </a>
                            <div class="ty-product-card__body">
                                <h3>{{ $service->title }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit($summary, 116) }}</p>
                                <div class="ty-product-card__footer">
                                    <span class="ty-price">{{ number_format($service->price_1) }} SAR</span>
                                    <div class="ty-card-actions">
                                        <a class="ty-icon-btn" href="{{ route('service.show', ['id' => $service->seo_route_key]) }}" aria-label="عرض المنتج">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form action="{{ route('customer.cart_add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ encrypt($service->id) }}">
                                            <button class="ty-buy-btn" type="submit">
                                                <i class="fa-solid fa-cart-plus"></i>
                                                <span class="tr-ar">أضف</span>
                                                <span class="tr-en">Add</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="ty-section ty-section--soft ty-section--benefits">
            <div class="container">
                <div class="ty-section__head">
                    <div>
                        <div class="ty-kicker">
                            <span class="tr-ar">ماذا يميزنا</span>
                            <span class="tr-en">Why choose us</span>
                        </div>
                        <h2>
                            <span class="tr-ar">مميزات المنتجات والتسوق في المتجر</span>
                            <span class="tr-en">Product and shopping advantages</span>
                        </h2>
                    </div>
                </div>
                <div class="ty-benefits">
                    <div class="ty-benefit">
                        <i class="fa-solid fa-gem"></i>
                        <h3><span class="tr-ar">منتجات مختارة</span><span class="tr-en">Curated products</span></h3>
                        <p><span class="tr-ar">قطع نسائية منتقاة بعناية لتناسب الإطلالات اليومية والمناسبات.</span><span class="tr-en">Carefully selected feminine pieces for daily looks and occasions.</span></p>
                    </div>
                    <div class="ty-benefit">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <h3><span class="tr-ar">تسوق سلس</span><span class="tr-en">Smooth shopping</span></h3>
                        <p><span class="tr-ar">تصفح واضح للأقسام وإضافة المنتجات للسلة بخطوات سهلة وسريعة.</span><span class="tr-en">Clear category browsing and easy add-to-cart flow.</span></p>
                    </div>
                    <div class="ty-benefit">
                        <i class="fa-solid fa-circle-info"></i>
                        <h3><span class="tr-ar">تفاصيل واضحة</span><span class="tr-en">Clear details</span></h3>
                        <p><span class="tr-ar">صور ووصف وسعر لكل منتج لتختاري بثقة قبل إتمام الطلب.</span><span class="tr-en">Images, descriptions, and prices help customers choose confidently.</span></p>
                    </div>
                    <div class="ty-benefit">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                        <h3><span class="tr-ar">تنوع لكل إطلالة</span><span class="tr-en">Variety for every look</span></h3>
                        <p><span class="tr-ar">من الكروشيه والأزياء إلى الشنط والمكياج، كل قسم يكمل ذوقك.</span><span class="tr-en">From crochet and fashion to bags and beauty, each section completes a look.</span></p>
                    </div>
                </div>
            </div>
        </section>

        @if (count($featuredCategories) > 0)
            <section class="ty-section ty-section--categories">
                <div class="container">
                    <div class="ty-section__head">
                        <div>
                            <div class="ty-kicker"><span class="tr-ar">التصنيفات</span><span class="tr-en">Categories</span></div>
                            <h2><span class="tr-ar">الأقسام الأساسية لمتجر تيانيل</span><span class="tr-en">Tyaniel core departments</span></h2>
                        </div>
                    </div>
                    <div class="ty-categories">
                        @foreach ($featuredCategories as $mainCategory)
                            @php($categoryImage = $mainCategory->image ? asset("storage/$mainCategory->image") : asset('storage/tyaniel/default-product.png'))
                            <a class="ty-category" href="{{ route('category.show', ['id' => $mainCategory->id, 'slug' => $mainCategory->slug]) }}">
                                <img src="{{ $categoryImage }}" alt="{{ $mainCategory->title }}">
                                <div class="ty-category__content">
                                    <h3>{{ $mainCategory->title }}</h3>
                                    <p>{{ $mainCategory->details }}</p>
                                    <span><span class="tr-ar">استعرضي القسم</span><span class="tr-en">Explore</span> <i class="fa-solid fa-arrow-left-long"></i></span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="ty-section ty-section--soft ty-section--cta">
            <div class="container">
                <div class="ty-cta">
                    <div>
                        <h2><span class="tr-ar">اكتشفي أناقة تيانيل في كل تفصيلة</span><span class="tr-en">Discover Tyaniel elegance in every detail</span></h2>
                        <p><span class="tr-ar">تسوقي منتجات نسائية مختارة بعناية تجمع النعومة والفخامة، من الإطلالات اليومية إلى لمسات المناسبات.</span><span class="tr-en">Shop carefully curated feminine pieces for daily looks, refined occasions, and polished finishing touches.</span></p>
                    </div>
                    <a class="ty-btn" href="{{ route('category.services', ['id' => 'all']) }}">
                        <i class="fa-solid fa-store"></i>
                        <span class="tr-ar">كل المنتجات</span>
                        <span class="tr-en">All products</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('JScript')
    <script type="module">
        const canvas = document.getElementById('tyanielHeroCanvas');
        if (canvas) {
            import('https://unpkg.com/three@0.160.0/build/three.module.js').then((THREE) => {
                const scene = new THREE.Scene();
                const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
                camera.position.set(0, 1.15, 7.2);

                const renderer = new THREE.WebGLRenderer({
                    canvas,
                    antialias: true,
                    alpha: true
                });
                renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                renderer.outputColorSpace = THREE.SRGBColorSpace;

                const group = new THREE.Group();
                scene.add(group);

                const ambient = new THREE.HemisphereLight(0xfff4ef, 0x4b213f, 1.7);
                scene.add(ambient);
                const key = new THREE.DirectionalLight(0xffffff, 2.3);
                key.position.set(3.5, 5.2, 4);
                scene.add(key);
                const rim = new THREE.DirectionalLight(0xf2b6c6, 1.4);
                rim.position.set(-4, 2.2, 2.5);
                scene.add(rim);

                const matPlum = new THREE.MeshPhysicalMaterial({ color: 0x4B213F, roughness: .32, metalness: .12, clearcoat: .55, clearcoatRoughness: .18 });
                const matRose = new THREE.MeshPhysicalMaterial({ color: 0xD989A3, roughness: .28, metalness: .08, clearcoat: .8, clearcoatRoughness: .14 });
                const matGold = new THREE.MeshPhysicalMaterial({ color: 0xB88A5A, roughness: .2, metalness: .48, clearcoat: .62, clearcoatRoughness: .18 });
                const matIvory = new THREE.MeshPhysicalMaterial({ color: 0xFFF4EF, roughness: .36, metalness: .02, transmission: .12, transparent: true, opacity: .9, clearcoat: .9 });

                const bag = new THREE.Mesh(new THREE.BoxGeometry(2.25, 1.85, .92), matRose);
                bag.position.set(0, -.24, 0);
                group.add(bag);

                const flap = new THREE.Mesh(new THREE.ConeGeometry(1.18, .62, 4), matIvory);
                flap.rotation.z = Math.PI / 4;
                flap.position.set(0, .18, .52);
                flap.scale.set(1.08, .58, .08);
                group.add(flap);

                const clasp = new THREE.Mesh(new THREE.SphereGeometry(.18, 32, 16), matGold);
                clasp.position.set(0, -.18, .98);
                group.add(clasp);

                const handle = new THREE.Mesh(new THREE.TorusGeometry(.95, .055, 18, 96, Math.PI), matPlum);
                handle.rotation.z = Math.PI;
                handle.position.set(0, 1.05, -.02);
                group.add(handle);

                const heel = new THREE.Mesh(new THREE.ConeGeometry(.34, 1.35, 4), matGold);
                heel.position.set(1.78, -.38, -.12);
                heel.rotation.z = -.35;
                heel.rotation.y = .25;
                group.add(heel);

                const shoeBase = new THREE.Mesh(new THREE.BoxGeometry(1.45, .28, .62), matRose);
                shoeBase.position.set(1.7, -1.05, .16);
                shoeBase.rotation.z = .06;
                group.add(shoeBase);

                const lipstick = new THREE.Mesh(new THREE.CylinderGeometry(.28, .28, 1.35, 36), matPlum);
                lipstick.position.set(-1.78, -.62, .08);
                lipstick.rotation.z = -.12;
                group.add(lipstick);

                const lipstickTip = new THREE.Mesh(new THREE.ConeGeometry(.24, .62, 36), matRose);
                lipstickTip.position.set(-1.88, .22, .08);
                lipstickTip.rotation.z = -.12;
                group.add(lipstickTip);

                const pearlGroup = new THREE.Group();
                for (let i = 0; i < 9; i++) {
                    const bead = new THREE.Mesh(new THREE.SphereGeometry(.105, 24, 12), matIvory);
                    const angle = Math.PI * (.15 + i * .087);
                    bead.position.set(Math.cos(angle) * .88 - 1.0, Math.sin(angle) * .5 + .88, .2);
                    pearlGroup.add(bead);
                }
                group.add(pearlGroup);

                const platform = new THREE.Mesh(new THREE.CylinderGeometry(2.72, 3.15, .16, 96), new THREE.MeshPhysicalMaterial({
                    color: 0xf5dbe3,
                    roughness: .54,
                    metalness: .02,
                    transparent: true,
                    opacity: .72
                }));
                platform.position.set(0, -1.65, -.14);
                group.add(platform);

                let targetX = 0;
                let targetY = 0;
                let frame = 0;

                const resize = () => {
                    const rect = canvas.getBoundingClientRect();
                    renderer.setSize(rect.width, rect.height, false);
                    camera.aspect = rect.width / Math.max(rect.height, 1);
                    camera.updateProjectionMatrix();
                };

                window.addEventListener('resize', resize);
                resize();

                canvas.addEventListener('pointermove', (event) => {
                    const rect = canvas.getBoundingClientRect();
                    targetX = ((event.clientX - rect.left) / rect.width - .5) * .7;
                    targetY = ((event.clientY - rect.top) / rect.height - .5) * .42;
                });

                const animate = () => {
                    frame += .01;
                    group.rotation.y += (targetX + Math.sin(frame) * .08 - group.rotation.y) * .05;
                    group.rotation.x += (-targetY + Math.cos(frame * .8) * .035 - group.rotation.x) * .05;
                    group.position.y = Math.sin(frame * 1.35) * .07;
                    renderer.render(scene, camera);
                    window.__tyaniel3DReady = true;
                    requestAnimationFrame(animate);
                };

                animate();
            }).catch(() => {
                canvas.style.display = 'none';
            });
        }
    </script>
@endsection
