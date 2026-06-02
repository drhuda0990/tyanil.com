@extends('layouts.app')
@section('title', $service->meta_title ?: $service->title)
@section('meta_title', $service->meta_title ?: $service->title . ' | تيانيل')
@section('meta_description', $service->meta_description ?: \Illuminate\Support\Str::limit(trim(strip_tags($service->summry ?: $service->body)), 155, ''))
@section('canonical', route('service.show', ['id' => $service->seo_route_key]))
@section('og_type', 'product')
@section('og_image', \Illuminate\Support\Str::startsWith($service->image_url, ['http://', 'https://']) ? $service->image_url : url($service->image_url))
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
                    {{ $service->title }}
                </h1>
                <ul>
                    <li><a href="{{ route('index') }}">الصفحة الرئيسية</a></li>
                    <li><i class="fa-regular fa-angle-right"></i></li>
                    <li>
                        {{ $service->title }}
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Banner area end here -->

    <!-- Courses area start here -->
    <section class="courses-details-two-area store-product-detail-page pt-120 pb-120">
        <div class="container rtlDirection">
            <div class="courses-details-two__item store-product-detail-heading bor-bottom pb-30 mb-40">

                <div class="d-flex justify-content-between flex-wrap gap-4">
                    <div class="store-product-title-group">
                        <span class="store-product-kicker">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>منتج مختار | Selected product</span>
                        </span>
                        <h3 class="fs-30 mb-0">{{ $service->title }}</h3>
                        @if ($service->not_available != 1)
                            <p>جاهز للطلب الآن مع خيارات مرنة للإضافات والتسليم.</p>
                        @else
                            <p>هذا المنتج غير متاح حالياً، ويمكنك متابعة المنتجات الأخرى من المتجر.</p>
                        @endif
                    </div>
                    <div class="store-product-heading-price">
                        @if ($service->price_start_from)
                            <span>تبدأ من</span>
                        @else
                            <span>السعر</span>
                        @endif
                        <strong>{{ number_format($service->price_1) }} SAR</strong>
                    </div>

                </div>
            </div>

            <div class="row g-4 store-product-detail-layout">
                <div class="col-lg-8 order-2 order-lg-1">
                    <div class="courses-details-two__tab store-product-tabs mb-40">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">

                                <a class="nav-link active" href="#0" id="overview-content" data-bs-toggle="tab"
                                    data-bs-target="#overview">لمحة عامة
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="#0" data-bs-toggle="tab" id="curriculum-content"
                                    data-bs-target="#curriculum">التفاصيل</a>
                            </li>

                        </ul>
                    </div>
                    <div class="tab-content store-product-tab-content">
                        <div class="tab-pane fade show active" id="overview" aria-labelledby="overview-content">
                            <div class="courses-details__item-left">
                                <div class="row">
                                    <!-- Image Gallery -->
                                    <div class="col-md-6">

                                    </div>
                                </div>
                                <div class="content store-product-detail-copy mb-30">
                                    <div id="serviceCarousel" class="carousel slide store-product-gallery" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="{{ $service->image_url }}" class="d-block w-100 rounded"
                                                    alt="service Image">
                                            </div>
                                            @foreach ($service->getMedia('multi_service_images') as $key => $media)
                                                <div class="carousel-item">
                                                    <img src="{{ $media->getUrl() }}" class="d-block w-100 rounded"
                                                        alt="service Image">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#serviceCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#serviceCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>

                                    <!-- Thumbnail Preview -->
                                    <div class="mt-3 d-flex flex-wrap gap-2 store-product-thumbs">
                                        <img src="{{ $service->image_url }}" class="rounded" width="70" height="70"
                                            data-bs-target="#serviceCarousel" data-bs-slide-to="0"
                                            style="cursor: pointer;">
                                        @foreach ($service->getMedia('multi_service_images') as $key => $media)
                                            <img src="{{ $media->getUrl('thumb') }}" class="rounded" width="70"
                                                height="70" data-bs-target="#serviceCarousel"
                                                data-bs-slide-to="{{ $key + 1 }}" style="cursor: pointer;">
                                        @endforeach
                                    </div>
                                    <br>

                                    {{-- <img class="fullWidth" src="{{ $service->image_url }}" alt="image"> --}}
                                    <h3 class="fs-30 mb-20"> </h3>

                                    <p class="mb-20">
                                        {!! \App\Support\SafeHtml::clean($service->summry) !!}
                                    </p>

                                </div>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="curriculum" aria-labelledby="curriculum-content">
                            <div class="courses-details__item-left">
                                <div class="content store-product-detail-copy mb-30">
                                    <h3 class="fs-30 mb-20"> </h3>
                                    <p class="mb-20">
                                        {!! \App\Support\SafeHtml::clean($service->body) !!}
                                    </p>
                                    {{-- @foreach ($service->getMedia('multi_attachment_file') as $file)
                                        @include('homepage.showDocument')
                                    @endforeach --}}
                                    <p></p>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- <div style="position:relative;padding-top:max(60%,324px);width:100%;height:0;"><iframe
                            style="position:absolute;border:none;width:100%;height:100%;left:0;top:0;"
                            src="https://online.fliphtml5.com/khawala/ruzs/" title="بنك الاسئلة كامل "
                            seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true"
                            allowfullscreen="true"></iframe></div> --}}
                  @include('homepage.rating')
                </div>
                <div class="col-lg-4 order-1 order-lg-2">
                    <div class="courses-details__item-right">
                        <div class="item store-purchase-card">
                            @if ($service->not_available != 1)
                                <form name="form_code" class="" action="{{ route('customer.cart_add') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ encrypt($service->id) }}">
                                    @if (count($service->activateAdditionalFeatures) > 0)
                                        <h2 class="text-left">الإضافات</h2>
                                        <hr>
                                        @foreach ($service->activateAdditionalFeatures as $addFeature)
                                            <label class="custom-control overflow-checkbox">
                                                <input type="checkbox" class="overflow-control-input" name="features[]"
                                                    value="{{ $addFeature->id }}">
                                                <span class="overflow-control-indicator"></span>
                                                <span class="overflow-control-description">{{ $addFeature->title }}</span>
                                            </label>
                                            <p style="font-size: 13px">{{ $addFeature->details }}</p>
                                            <hr>
                                        @endforeach
                                    @endif

                                    <button class="btn-one" type="submit">
                                        إضافة للسلة
                                        <i class="fa-light fa-arrow-right-long"></i>
                                    </button>
                                </form>
                            @else
                                <br>
                                <span class="notAvailable">غير متاح حالياً</span>
                            @endif
                            <br>
                            <span class="price">
                                @if ($service->price_start_from)
                                    تبدأ من
                                @endif
                                {{ number_format($service->price_1) }} SAR
                            </span>
                            <br>
                            <button onclick="copyShareText()" type="button" class="btn-one btn-one2"><i
                                    class="fa-light fa-share-nodes"></i>مشاركة
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </section>

    <!-- Courses area end here -->


    <!--* ********************************* -->
@endsection
<!--* ********************************* -->
@section('JScript')
    @php
        $schemaImage = \Illuminate\Support\Str::startsWith($service->image_url, ['http://', 'https://']) ? $service->image_url : url($service->image_url);
        $schemaDescription = $service->meta_description ?: \Illuminate\Support\Str::limit(trim(strip_tags($service->summry ?: $service->body)), 155, '');
        $schemaPrice = (float) preg_replace('/[^\d.]/', '', (string) $service->price_1);
        $productSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $service->title,
            'image' => [$schemaImage],
            'description' => $schemaDescription,
            'sku' => 'TY-' . $service->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'تيانيل',
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => route('service.show', ['id' => $service->seo_route_key]),
                'priceCurrency' => 'SAR',
                'price' => number_format($schemaPrice, 2, '.', ''),
                'availability' => $service->not_available == 1 ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
            ],
        ];

        if ($total > 0) {
            $productSchema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $avg,
                'reviewCount' => $total,
            ];
        }
    @endphp
    <script type="application/ld+json">{!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script>
        function copyShareText() {
            var title = 'مرحباً بك معنا في \n' + @json($gSetting->name) + '\n'; // This safely escapes quotes  
            title += @json($service->title); // This safely escapes quotes
            const url = window.location.href;
            const fullText = `${title}\n${url}`;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(fullText).then(() => {
                    Swal.fire({
                        title: "",
                        icon: "info",
                        html: "<br>" +
                            'تم نسخ رابط المشاركة بنجاح' + '<br>' +
                            '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                            'حسناً' + '</button>',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                }).catch(() => {
                    Swal.fire({
                        title: "",
                        icon: "error",
                        html: "<br>" +
                            'حدث خطأ أثناء النسخ' + '<br>' +
                            '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                            'حسناً' + '</button>',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                });
            } else {
                // Fallback for older browsers
                const textarea = document.createElement("textarea");
                textarea.value = fullText;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand("copy");
                    Swal.fire({
                        title: "",
                        icon: "info",
                        html: "<br>" +
                            'تم نسخ رابط المشاركة بنجاح' + '<br>' +
                            '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                            'حسناً' + '</button>',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                } catch (err) {
                    Swal.fire({
                        title: "",
                        icon: "error",
                        html: "<br>" +
                            'حدث خطأ أثناء النسخ' + '<br>' +
                            '<br><button type="button" role="button" tabindex="0" class="btn-one SwalBtn1">' +
                            'حسناً' + '</button>',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                }
                document.body.removeChild(textarea);
            }
        }
        // document.addEventListener('contextmenu', e => e.preventDefault());
        // document.addEventListener('keydown', e => {
        //     if (e.ctrlKey && ['p', 's', 'c', 'u'].includes(e.key.toLowerCase())) {
        //         e.preventDefault();
        //     }
        // });
    </script>

@endsection
