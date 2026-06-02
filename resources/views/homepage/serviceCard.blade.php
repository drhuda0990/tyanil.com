<div class="swiper-slide store-product-slide">
    <div class="courses-two__item store-product-card">
        <div class="courses-two__image image store-product-card__media">
            @if ($service->advertizment_service != 1)
                <a href="{{ route('service.show', ['id' => $service->seo_route_key]) }}"> <img src="{{ $service->image_url }}"
                        alt="image">
                </a>
            @else
                <a href="{{ $service->redirect_url }}"> <img src="{{ $service->image_url }}" alt="image">
                </a>
            @endif
            {{-- <span class="time">
                <svg class="me-1" width="16" height="17" viewBox="0 0 16 17"
                    fill="none" xmlns="https://www.w3.org/2000/svg">
                    <path
                        d="M10.8505 9.91291L8.61967 8.23979V4.8316C8.61967 4.48891 8.34266 4.21191 7.99998 4.21191C7.65729 4.21191 7.38029 4.48891 7.38029 4.8316V8.54966C7.38029 8.74485 7.47201 8.92892 7.62817 9.04541L10.1069 10.9044C10.2138 10.985 10.3441 11.0285 10.478 11.0284C10.667 11.0284 10.8529 10.9435 10.9744 10.7799C11.1802 10.5066 11.1244 10.118 10.8505 9.91291Z"
                        fill="white" />
                    <path
                        d="M8 0.5C3.58853 0.5 0 4.08853 0 8.5C0 12.9115 3.58853 16.5 8 16.5C12.4115 16.5 16 12.9115 16 8.5C16 4.08853 12.4115 0.5 8 0.5ZM8 15.2607C4.27266 15.2607 1.23934 12.2273 1.23934 8.5C1.23934 4.77266 4.27266 1.73934 8 1.73934C11.728 1.73934 14.7607 4.77266 14.7607 8.5C14.7607 12.2273 11.7273 15.2607 8 15.2607Z"
                        fill="white" />
                </svg>
                8h 30m
            </span> --}}
        </div>
        <div class="courses__content store-product-card__body pt-4 p-0">
            <div class="courses-two__info store-product-card__meta pb-4">
                @if ($service->advertizment_service != 1 && $service->not_available != 1)
                    <form name="form_code" class="" action="{{ route('customer.cart_add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ encrypt($service->id) }}">
                        @if (count($service->activateAdditionalFeatures) > 0)
                            <a href="{{ route('service.show', ['id' => $service->seo_route_key]) }}" class="cartBut">
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                        @else
                            <button class="cartBut" type="submit">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        @endif
                    </form>
                @endif
                <h4 style="direction: rtl">
                    @if ($service->price_start_from)
                        تبدأ من
                    @endif
                    {{ number_format($service->price_1) }} SAR
                </h4>
            </div>
            <h3>

                @if ($service->advertizment_service != 1)
                    <a href="{{ route('service.show', ['id' => $service->seo_route_key]) }}"
                        class="primary-hover">{{ $service->title }}</a>
                @else
                    <a href="{{ $service->redirect_url }}">{{ $service->title }}
                    </a>
                @endif
            </h3>
            @php
                $plainSummary = trim(strip_tags($service->summry ?? ''));
            @endphp
            @if ($plainSummary)
                <p class="store-product-card__summary">
                    {{ \Illuminate\Support\Str::limit($plainSummary, 105) }}
                </p>
            @endif
            @if ($service->advertizment_service != 1)
                <a class="store-product-card__link" href="{{ route('service.show', ['id' => $service->seo_route_key]) }}">
                    التفاصيل
                    <i class="fa-regular fa-arrow-left-long"></i>
                </a>
            @else
                <a class="store-product-card__link" href="{{ $service->redirect_url }}">
                    التفاصيل
                    <i class="fa-regular fa-arrow-left-long"></i>
                </a>
            @endif


        </div>
    </div>
</div>
