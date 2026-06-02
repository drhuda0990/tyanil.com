@extends('layouts.app')
@section('title', 'السيرة الذاتية')
<!--* ********************************* -->
@section('SCSS')
@endsection
<!--* ********************************* -->
@section('content')
    <section class="contact-area pt-120 pb-120">
        <div class="container">
            <div class="section-header mb-40">
                <h5 class="wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms"> السيرة الذاتية
                </h5>
                <a class="fLeft" href="{{ route('cv.create') }}">
                    <button class="btn-one" type="submit">
                        إضافة سيرة ذاتية
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
                            @foreach (\Auth::guard('customer')->user()->cvs as $key => $cv)
                                @include('cv.cvSection')
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
