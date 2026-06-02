@extends('layouts.app')
@section('SCSS')
    <style>
        .section-divider {
            display: inline-block;
            position: relative;
            height: 5px;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
            background-color: #ec5252;
            width: 90px;
            margin-top: 25px;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .h3-style {
            text-align: center;
            color: #ffffff;
        }

        .h-style {
            text-align: center;
            color: #000000 !important;
        }

        .loginForm {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
            background-color: #ac9c74 !important;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(82, 85, 90, 0.1);
            padding: 20px;
            color: #ffffff;
            font-weight: bolder;
        }

        .registrationForm {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
            background-color: #EEEEEE !important;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(82, 85, 90, 0.1);
            padding: 20px;
            color: #ffffff;
            font-weight: bolder;
        }

        .forgetForm {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
            background-color: #000000 !important;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(82, 85, 90, 0.1);
            padding: 20px;
            color: #ffffff;
            font-weight: bolder;
        }

        .input-text {
            height: 50px;
            padding-left: 20px !important;
            font-size: 14px !important;
            color: #233d63 !important;
            border-color: rgba(127, 136, 151, 0.2) !important;
            font-weight: 400;

            box-shadow: none;
            border-radius: 5px !important;
            display: block;
            width: 100%;
            line-height: 1.5;
        }
    </style>
@endsection
@section('content')


    <main>

        <section class="section-block section-block-full ">
            <!--<div class="block-media">-->
            <!--    <div class="image" style='background-image:url("{{ asset('images/hd-1.jpg') }}")'></div>-->
            <!--</div>-->

       @include('auth.trainee.loginRegisterForget')
        </section>

    </main>


@endsection
