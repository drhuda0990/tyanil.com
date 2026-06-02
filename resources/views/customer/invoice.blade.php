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

            padding: 0px !important;
            margin: 0px !important;
            background-color: #FFF;
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
            height: 200px;
            display: table;
            vertical-align: middle;
            background: #4ea350;

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
            display: table-cell;
            vertical-align: right;
            text-align: right;
            width: 70%;
        }

        .header_body_qr {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .text_style1 {
            color: #4ea350;
        }

        .course_date {
            padding: 10px;
            margin-top: 10px;
            background: #05746d;
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
            background: #05746d;
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
            background: #4ea350;
        }

        .tdStyle3 {
            background: #05746d;
        }

        table {
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <section>

        <div class="invoice_title">
            <div class="header_text">

                {{ $gSetting->name }}
            </div>
            <div class="title_image">
                <img height="80" src="{{ asset("storage/$gSetting->logo") }}" alt="{{ $gSetting->name }}">
            </div>



        </div>

        <main class="invoice">
            <div class="invoice_header">
                {{-- <div class="header_text">{{ $invoice->id }}
                </div> --}}
            </div>
            <div class="invoice_b">
                <div class="invoice_body">
                    <div class="header_body_text">

                        <p class="text_style1">
                            بيانات البائع:
                        </p>
                        <div class="to">
                            الأسم

                            :
                            {{ $gSetting->name }}
                            {!! '&nbsp;' !!}{!! '&nbsp;' !!}
                            الرقم الضريبي: {{ $gSetting->commercial_register }}

                        </div>
                        <hr>
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
                            customer-{{ $customer->id }}

                        </div>
                        <div class="to">
                            الجوال
                            :
                            {{ $customer->phone }}

                            {!! '&nbsp;' !!} {!! '&nbsp;' !!}

                            البريد الإلكتروني
                            :
                            {{ $customer->email }}
                        </div>
                        <hr>
                        <p class="text_style1">
                            بيانات الشراء:
                        </p>
                        تاريخ الشراء: {{ $invoice->created_at }}
                        {!! '&nbsp;' !!} {!! '&nbsp;' !!}
                        رقم الفاتورة: {{date('Y', strtotime($invoice->created_at))}}-{{ $invoice->id }}
                        @if ($invoice->method_name)
                            {!! '&nbsp;' !!} {!! '&nbsp;' !!}
                            طريقة الدفع:
                            {{ $invoice->method_name->name }}

                            {!! '&nbsp;' !!} {!! '&nbsp;' !!}
                        @endif
                        <br>
                        <hr>
                        <table>
                            <tr style="color:white;">
                                <td align="center" class="tdStyle"> - </td>
                                <td align="center" class="tdStyle">السعر</td>

                            </tr>


                            @foreach ($invoice->serviceItems as $item)
                                <tr>
                                    <td align="center" class="tdStyle2"> {{ $item->title }}</td>
                                    <td align="center" class="tdStyle2"> {{ number_format($item->purchase_price, 2) }}
                                        SR</td>
                                </tr>
                            @endforeach

                            @if ($invoice->shipment_price != null)
                                <tr>
                                    <td align="center" class="tdStyle2">
                                        الشحن
                                    </td>
                                    <td align="center" class="tdStyle2">
                                        {{ number_format($invoice->shipment_price, 2) }}
                                        SR
                                    </td>
                                </tr>
                            @endif

                            <?php $discount = 0; ?>
                            @if ($invoice->discount != 0)
                                <tr>
                                    <td align="center" class="tdStyle2">
                                        الخصم
                                    </td>
                                    <td align="center" class="tdStyle2">
                                        {{ number_format($invoice->discount, 2) }}
                                        SR
                                    </td>

                                </tr>
                            @endif

                            @if ($invoice->paid_amount+$invoice->shipment_price != $total)
                                <tr>
                                    <td align="center" class="tdStyle2">
                                        المبلغ المدفوع
                                    </td>
                                    <td align="center" class="tdStyle2">
                                        {{ number_format($invoice->paid_amount, 2) }}
                                        SR
                                    </td>
                                </tr>
                            @endif

                            <tr style="color:white;">
                                <td align="center" class="tdStyle3">
                                    الإجمالي
                                </td>

                                <td align="center" class="tdStyle3"> {{ $total }}


                                    SR

                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="header_body_qr">
                        <img src="{{ $displayQRCodeAsBase64 }}" width="150" height="150" alt="QR Code" />
                        تطبيق الشروط والأحكام
                    </div>

                </div>


        </main>
        </div>
        {{-- <footer>
            <div style="width:100%;color:white;display:inline-block;">
                <div style="width:50%;background-color:#4ea350;display:inline-block;float:right;">{{ env('APP_URL') }}
                </div>
                <div style="width:50%;background-color:#05746d;display:inline-block;float:left;">
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
