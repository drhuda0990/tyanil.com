@extends('layouts.app')

@section('content')
<div class="container" style="padding: 90px 16px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="border:1px solid #ead3dc;border-radius:18px;box-shadow:0 18px 45px rgba(75,33,63,.12);overflow:hidden;">
                <div class="card-header" style="background:#4b213f;color:#fff4ef;font-weight:700;font-size:22px;padding:22px;">
                    تفعيل البريد الإلكتروني
                </div>

                <div class="card-body" style="padding:28px;color:#5d4052;font-size:16px;line-height:2;">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            تم إرسال رابط تفعيل جديد إلى بريدك الإلكتروني.
                        </div>
                    @endif

                    <p>أرسلنا رابط تفعيل إلى بريدك الإلكتروني. افتحي الرسالة واضغطي زر التفعيل لإكمال إعداد حسابك في تيانيل.</p>
                    <p>إذا لم تصلك الرسالة، تحققي من البريد غير الهام أو اطلبي إرسال رابط جديد.</p>

                    <form class="d-inline" method="POST" action="{{ route('customer.verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-one">إرسال رابط تفعيل جديد</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
