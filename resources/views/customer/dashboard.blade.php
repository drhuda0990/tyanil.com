@extends('layouts.app')
@section('title', 'لوحة التحكم')
<!--* ********************************* -->
@section('SCSS')
    <style>
        .fileBox {
            background-color: rgb(46 185 126);
            color: white;
            padding: 2px;
            display: inline;
            font-size: 14px;
        }

        .accordion-button {
            display: inline;
        }

        .accordion-button {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
}

/* Lock the title to the right in RTL */
.accordion-button .acc-title {
    margin-right: 0;
    flex-grow: 1;
    text-align: right;
}

/* Prevent Bootstrap arrow from pushing text */
.accordion-button::after {
    margin-left: 10px !important;
    margin-right: 0 !important;
}
    </style>
@endsection
<!--* ********************************* -->
@section('content')
    <section class="contact-area pt-120 pb-120">
        <div class="container">
            <div class="section-header mb-40">
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> الخدمات المطلوبة
                </h5>
            </div>
            <div class="contact__info pb-120">

                <div class="row g-5">

                    <div class="col-lg-12 order-1 order-lg-2 ">
                        <div class="accordion rtlDirection" id="accordionExample">
                            @foreach ($customerServices as $key => $cService)
                                @if ($cService->service)
                                    <div class="accordion-item shadow border-none wow fadeInDown" data-wow-delay="00ms"
                                        data-wow-duration="1500ms">
                                        <h2 class="accordion-header" id="heading{{ $cService->id }}">
                                            <div class="d-flex align-items-center justify-content-between w-100">

                                                <button class="accordion-button collapsed flex-grow-1" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#s{{ $cService->id }}"
                                                    aria-expanded="false" aria-controls="s{{ $cService->id }}">

                                                    {{ $key + 1 }} - {{ $cService->title }}
                                                </button>

                                            </div>
                                        </h2>

                                        <div id="s{{ $cService->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $cService->id }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @php
                                                    $serviceFiles = $cService->service->getMedia('multi_attachment_file');
                                                    $largeFiles = $cService->service->getMedia('largeFileUploads');
                                                @endphp

                                                @if ($serviceFiles->count() > 0 || $largeFiles->count() > 0)
                                                    <h5>ملفات الطلب</h5>
                                                    @foreach ($serviceFiles as $file)
                                                        <a href="{{ route('media.download', encrypt($file->id)) }}"
                                                            class="btn btn-primary">
                                                            تحميل {{ $file->name }}
                                                        </a>
                                                    @endforeach
                                                    @foreach ($largeFiles as $file)
                                                        <a href="{{ route('media.download', encrypt($file->id)) }}"
                                                            class="btn btn-primary">
                                                            تحميل {{ $file->name }}
                                                        </a>
                                                    @endforeach

                                                    <hr>
                                                @endif
                                                @if (count($cService->serInvoiceItemsFeatures) > 0)
                                                    <h5 class=" ">
                                                        الميزات الإضافية
                                                    </h5>
                                                    @foreach ($cService->serInvoiceItemsFeatures as $key => $feature)
                                                        <p>{{ $key + 1 }} - {{ $feature->title }}</p>
                                                    @endforeach
                                                    <hr>
                                                @endif
                                                @if ($cService->serviceInvoice)
                                                    @if ($cService->serviceInvoice->shipment_price != null && $cService->service->required_shipment)
                                                        <h5 class="wow fadeInUp" data-wow-delay="00ms"
                                                            data-wow-duration="1500ms">
                                                            بيانات عنوان الشحن
                                                        </h5>
                                                        <p>
                                                            الاسم:
                                                            {{ $cService->serviceInvoice->name }}</p>
                                                        <p>
                                                            الهاتف:
                                                            {{ $cService->serviceInvoice->phone }}</p>
                                                        <p>
                                                            الايميل:
                                                            {{ $cService->serviceInvoice->email }}</p>
                                                        <p>
                                                            المدينة:
                                                            {{ $cService->serviceInvoice->city }}</p>
                                                        <p>
                                                            الشارع:
                                                            {{ $cService->serviceInvoice->street }}</p>
                                                        <p>
                                                            العنوان:
                                                            {{ $cService->serviceInvoice->address }}</p>
                                                        <hr>
                                                    @endif
                                                @endif


                                                @if ($cService->details != null)
                                                    <h5 class="wow fadeInUp" data-wow-delay="00ms"
                                                        data-wow-duration="1500ms">
                                                        تفاصيل الخدمة
                                                    </h5>
                                                    <p>{{ $cService->details }} </p>
                                                    <hr>
                                                @else
                                                    <div class="contact__item">

                                                        <form
                                                            action="{{ route('customer.itemDetails', ['id' => encrypt($cService->id)]) }}"
                                                            class="form-box rtlDirection" method="post">
                                                            {{ csrf_field() }}
                                                            <label for="details">تفاصيل الخدمة المطلوبة*</label>
                                                            <textarea name="details" id="details" value="">{{ old('details') }}</textarea>
                                                            <button class="btn-one" type="submit">حفظ وإرسال<i
                                                                    class="fa-light fa-arrow-right-long"></i></button>
                                                        </form>
                                                    </div>
                                                    <hr>
                                                @endif
                                                @if ($cService->time != null)
                                                    <h5 class="wow fadeInUp" data-wow-delay="00ms"
                                                        data-wow-duration="1500ms">
                                                        الوقت </h5>
                                                    <p>{{ $cService->time }}</p>
                                                    <hr>
                                                @endif
                                                @if ($cService->meeting_data != null)
                                                    <h5 class="wow fadeInUp" data-wow-delay="00ms"
                                                        data-wow-duration="1500ms">
                                                        بيانات الإجتماع
                                                    </h5>
                                                    <p>{!! \App\Support\SafeHtml::clean($cService->meeting_data) !!} </p>
                                                    <hr>
                                                @endif
                                                @if ($cService->admin_attachments != null)
                                                    <h5 class="wow fadeInUp" data-wow-delay="00ms"
                                                        data-wow-duration="1500ms">
                                                        المرفقات من المشرف
                                                    </h5>
                                                    <p>{!! \App\Support\SafeHtml::clean($cService->admin_attachments) !!} </p>
                                                    <hr>
                                                @endif
                                                @if ($cService->admin_response != null)
                                                    <h5 class="wow fadeInUp" data-wow-delay="00ms"
                                                        data-wow-duration="1500ms">
                                                        رد المشرف
                                                    </h5>
                                                    <p>{!! \App\Support\SafeHtml::clean($cService->admin_response) !!} </p>
                                                    <hr>
                                                @endif

                                                {{-- <a
                                                href="{{ route('customer.invoice', ['id' => encrypt($cService->serviceInvoice->id)]) }}">
                                                <button class="btn-one" type="submit">
                                                    الفاتورة
                                                </button>
                                            </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<!--* ********************************* -->
@section('JScript')


    <script></script>
@endsection
