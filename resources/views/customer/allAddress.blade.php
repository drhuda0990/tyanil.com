@extends('layouts.app')
@section('title', 'العناوين')
<!--* ********************************* -->
@section('SCSS')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtlf0-QCKbvARdCDQAqq4bJggfCKkU6Ns"></script>
    <style>
    </style>
@endsection
<!--* ********************************* -->
@section('content')
    <section class="contact-area pt-120 pb-120">
        <div class="container">
            <div class="section-header mb-40">
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> العناوين
                </h5>
                <a class="fLeft" href="{{ route('customer.newAddress') }}">
                    <button class="btn-one" type="submit">
                        إضافة عنوان جديد
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </a>
            </div>

            <br>
            <div class="contact__info ">

                <div class="row w-100">
                    <br>
                    <div class="col-lg-12 order-1 order-lg-2 ">
                        <div class="accordion rtlDirection" id="accordionExample">
                            @foreach ($allAddress as $key => $address)
                                @include('customer.addressSection')
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

@endsection
