<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ $invoice->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/Forms.css') }}" />
    <link rel="icon" href="{{ asset('images/logo1.png') }}">
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }

        body {
            height: 285mm;
            background-color: #FFFFFF;

            background-image: url("/frontend/images/invoiceBg.png");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            padding: 0px !important;
            margin: 0px !important;
            overflow: hidden;
            line-height: 1.7em;
            page-break-after: avoid;
            overflow-y: auto;
        }

        table th,
        table td {
            padding: 0px;
            text-align: center !important;
            vertical-align: middle !important;
        }

        table td h3 {

            font-size: 1em;

        }

        #logo {
            float: left;
            margin-left: 10px;
        }

        #logo img {
            position: relative;
            height: 80px;
        }

        .invoice_t {
            font-weight: bold;
            width: 100%;
            text-align: right;
            border-bottom: 0px;
            height: 80px;
            padding: 0px;
            font-size: 1.6em;
            padding-right: 20px;
            margin: 0px;
            margin-left: 20px;
        }

        .invoice_header {
            color: #FFFFFF;
            font-size: 1.6em;
            width: 100%;
            font-weight: bold;
            height: 200px;
            display: table;
            vertical-align: middle;
            background: #8FAF8B;

        }

        .invoice_title {
            font-size: 1.6em;
            width: 100%;
            height: 80px;
            display: table;
            vertical-align: middle;

        }

        .invoice_b {
            padding: 1pc;
            padding-right: 2pc;
        }

        .invoice_body {

            width: 100%;
            display: table;
            vertical-align: middle;
            /*margin-bottom:20px;*/
        }

        .header_image {


            /*width:30%;*/

        }

        .header_text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding-right: 5px;
            width: 60%;
        }

        .header_body_text {
            vertical-align: right;
            text-align: right;
            font-weight: bold;
            width: 100%;
        }

        .header_body_qr {
            vertical-align: middle;
            text-align: center;
        }

        .text_style1 {
            color: #8FAF8B;
        }

        .course_date {
            padding: 10px;
            margin-top: 10px;
            background: #8FAF8B;
            text-align: center;
            width: fit-content;
        }

        img {
            display: block;
            margin: auto;
        }

        table .th_no,
        table .th_desc,
        table .th_unit {
            color: #FFFFFF;
            font-size: 1em;
            background: #8FAF8B;
        }

        section {
            padding: 0px;
            margin: 0px;
            border: 0px;
            width: 100%;
            height: auto;
        }

        #client,
        #invoice {
            max-width: 50%;
        }

        .column {
            float: center;
            width: 25%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }


        footer {
            width: 100%;
            border-top: 0px;
            position: relative;
        }

        table td {
            background: #ffffff;

        }

        .tdStyle {
            font-weight: bold;
            background: #8FAF8B;
        }

        .tdStyle2 {
            font-weight: bold;
        }

        table {
            margin-bottom: 0px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black !important;
        }
    </style>
</head>

<body>
    <section style="background: transparent;">
        <br>
        <span style="float: left;color:#000000;">
            تاريخ الشراء: {{ $invoice->created_at }}
            {!! '&nbsp;' !!} {!! '&nbsp;' !!}
        </span>
        <br>
        <br>
        <div class="header_body_text" style="text-align: right;padding-right:30px;font-weight: bold;">
            {{-- <img height="80" style="margin:0%;" src="{{ asset("storage/$gSetting->logo") }}"
                alt="{{ $gSetting->name }}"> --}}
            {{-- <br>
            {{ $gSetting->name }} --}}
            <br>
            رقم التعريف الضريبي: {{ $gSetting->commercial_register }}
            {{-- <br>
            الطائف
            <br>
            البريد الإلكتروني:

            {{ $gSetting->email_2 }}
            <br>
            الجوال:

            {{ $gSetting->phone }}
            <br> --}}


        </div>
        <br>
        <strong style="width: 100%;
    display: block;
    text-align: center;">
            رقم الفاتورة

            {!! '&nbsp;' !!} {!! '&nbsp;' !!}
            {{ date('Y', strtotime($invoice->created_at)) }}{{ $invoice->id }}

        </strong>
        <hr>
        <main class="invoice">
            <div class="invoice_b">
                <div class="invoice_body">
                    <div class="header_body_text">
                        <p class="text_style1">
                            بيانات العميل:
                        </p>
                        <div class="to">
                            الأسم
                            :
                            {{ $customer->name }}

                            {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                            معرف العميل
                            :
                            cus-{{ $customer->id }}
                            الجوال
                            :
                            {{ $customer->phone }}
                            {!! '&nbsp;' !!} {!! '&nbsp;' !!}
                            البريد الإلكتروني
                            :
                            {{ $customer->email }}
                            @if ($invoice->method_name)
                                <br>
                                طريقة الدفع:
                                {{ $invoice->method_name->name }}
                                {!! '&nbsp;' !!} {!! '&nbsp;' !!}
                            @endif
                        </div>

                        <br>
                        <table>
                            <tbody>
                                <tr style="">
                                    <td align="center" class="tdStyle"> المنتج</td>
                                    <td align="center" class="tdStyle"> الكمية</td>
                                    <td align="center" class="tdStyle">السعر</td>
                                    <td align="center" class="tdStyle">معدل ضريبة القيمة</td>
                                    <td align="center" class="tdStyle">مبلغ ضريبة القيمة</td>
                                    <td align="center" class="tdStyle">الإجمالي</td>

                                </tr>
                                @foreach ($invoice->serviceItems as $item)
                                    <tr>
                                        <?php $tax2 = '1.' . $gSetting->tax;
                                        $taxamount = $item->purchase_price - $item->purchase_price / $tax2;
                                        $taxamount = round($taxamount, 2); ?>
                                        <td align="center" class="tdStyle2"> {{ $item->title }}</td>
                                        <td align="center" class="tdStyle2">1</td>
                                        <td align="center" class="tdStyle2">
                                            {{ number_format($item->purchase_price - $taxamount, 2) }}
                                            SR</td>
                                        <td align="center" class="tdStyle2">{{ $gSetting->tax }}%</td>

                                        <td align="center" class="tdStyle2">{{ $taxamount }} SAR</td>
                                        <td align="center" class="tdStyle2">
                                            {{ number_format($item->purchase_price, 2) }}
                                            SR</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="width: 100%">
                            <div style="width: fit-content;
    text-align: right;
    float: left;">
                                @if ($invoice->shipment_price != null)
                                    <strong>
                                        الشحن
                                        :
                                        {!! '&nbsp;' !!} {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                                        {!! '&nbsp;' !!}
                                        <span style="float: left;">
                                            {{ number_format($invoice->shipment_price, 2) }}
                                            SR
                                        </span>
                                    </strong>
                                    <br>
                                @endif

                                <?php $discount = 0; ?>
                                @if ($invoice->discount != 0)
                                    <strong>
                                        الخصم:
                                        {!! '&nbsp;' !!} {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                                        {!! '&nbsp;' !!}
                                        <span style="float: left;">

                                            {{ number_format($invoice->discount, 2) }}
                                            SR
                                        </span>
                                    </strong>
                                    <br>
                                @endif

                                @if ($invoice->paid_amount + $invoice->shipment_price != $total)
                                    <strong>
                                        المبلغ المدفوع
                                        :
                                        {!! '&nbsp;' !!} {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                                        {!! '&nbsp;' !!}
                                        <span style="float: left;">

                                            {{ number_format($invoice->paid_amount, 2) }}
                                            SR
                                        </span>
                                    </strong>
                                    <br>
                                @endif
                                <strong>
                                    المجموع الجزئي
                                    :
                                    {!! '&nbsp;' !!} {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                                    {!! '&nbsp;' !!}
                                    <span style="float: left;">

                                        {{ number_format($total - $tax, 2) }}
                                        SR
                                    </span>
                                </strong>
                                <br>
                                <strong>
                                    الضريبة
                                    :
                                    {!! '&nbsp;' !!} {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                                    {!! '&nbsp;' !!}
                                    <span style="float: left;">
                                        {{ number_format($tax, 2) }}
                                        SR
                                    </span>
                                </strong>
                                <hr>
                                <strong>
                                    الإجمالي
                                    :
                                    {!! '&nbsp;' !!} {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                                    {!! '&nbsp;' !!}
                                    <span style="float: left;">

                                        {{ number_format($total, 2) }}
                                        SR
                                    </span>
                                </strong>
                                <div class="header_body_qr" style="font-size: 8px;">
                                    <img src="{{ $displayQRCodeAsBase64 }}" width="120" height="120"
                                        alt="QR Code" />
                                    تطبق الشروط والأحكام
                                </div>
                            </div>


                        </div>
                    </div>


                </div>

                <hr>

                <span style="font-size: 10px;">
                    📄 الشروط والأحكام:
                    <br>
                    1-
                    يُمنع استرجاع أو استبدال المنتجات بعد استلامها، إلا في حال وجود عيب مصنعي أو تلف واضح لم يتم بسبب
                    العميل.
                    <br>
                    2-
                    يُرجى التأكد من صحة البيانات (الاسم، العنوان، رقم الجوال) قبل تأكيد الطلب، حيث لا يتحمل المتجر
                    مسؤولية أي خطأ ناتج عن معلومات غير دقيقة.
                    <br>
                    3-
                    مدة تجهيز الطلب: من 1 إلى 3 أيام عمل، ولا تشمل مدة الشحن.
                    <br>
                    4-
                    مدة الشحن والتوصيل: تعتمد على شركة الشحن والمنطقة، وغالباً ما تتراوح بين 2 إلى 5 أيام عمل داخل
                    المملكة.
                    <br>
                    5-
                    يتم التواصل مع العميل عبر الرقم المسجل فقط، وفي حال عدم الرد خلال 3 أيام، يتم إلغاء الطلب تلقائيًا.
                    <br>
                    6-
                    في حال الدفع المسبق، لا يمكن استرجاع المبلغ بعد تجهيز الطلب.
                    <br>
                    7-
                    الأسعار شاملة الضريبة ما لم يُذكر خلاف ذلك.
                    <br>
                    8-
                    عند استلام الطلب، يُرجى فحص الطرد جيدًا أمام مندوب التوصيل والإبلاغ فورًا في حال وجود أي نقص أو تلف.
                    <br>
                    9-
                    يحتفظ المتجر بحق تعديل الأسعار أو الشروط دون إشعار مسبق.
                </span>


        </main>
        </div>
        {{-- <footer>
            <div style="width:100%;color:white;display:inline-block;">
                <div style="width:50%;background-color:#4ea350;display:inline-block;float:right;">{{ env('APP_URL') }}
                </div>
                <div style="width:50%;background-color:#8FAF8B;display:inline-block;float:left;">
                    {{ $gSetting->email_2 }}</div>
            </div>
            <table>

                <tr>
                    @if ($gSetting->first_invoice_column)
                        <td align="center" style=" border-left: 1px solid;"> {!! $gSetting->first_invoice_column !!}</td>
                    @endif
                    @if ($gSetting->second_invoice_column)
                        <td align="center" style=" border-left: 1px solid;"> {!! $gSetting->second_invoice_column !!}</td>
                    @endif
                    @if ($gSetting->third_invoice_column)
                        <td align="center" style=" border-left: 1px solid;"> {!! $gSetting->third_invoice_column !!}</td>
                    @endif
                    @if ($gSetting->forth_invoice_column)
                        <td align="center"> {!! $gSetting->forth_invoice_column !!}</td>
                    @endif
                </tr>
            </table>


        </footer> --}}

    </section>
    <script>
        window.print()
    </script>
</body>

</html>
