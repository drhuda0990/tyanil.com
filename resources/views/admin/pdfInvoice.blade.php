<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <title>تقرير الشؤون المالية</title>
    <link rel="icon" href="{{ asset('storage/' . $gSetting->icon) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://use.fontawesome.com/a31ecc9ccb.js"></script>

    <style>
        body {
            margin: 0;
            background: #fff;
        }

        table {
            direction: rtl;
            text-align: right;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #04AA6D;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .wrapper {
            width: 1140px;
            margin: auto;
        }

        .pagebreak {
            page-break-after: always;
        }

        footer {
            margin-top: 20px;
            font-size: 13px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="wrapper">

        @php
            $perPage = 11;
            $page = 1;
            $totalPages = ceil($invoices->count() / $perPage);

            $totalAmount = 0;

            $payments_arr = [];
            $payments = App\Definition::where('type_id', 4)->get();
            foreach ($payments as $p) {
                $payments_arr[$p->id] = 0;
            }
        @endphp

        @foreach ($invoices->chunk($perPage) as $chunk)
            {{-- ===== Header ===== --}}
            <table style="border:none">
                <tr style="border:none">
                    <td style="border:none;text-align:right">
                        <h2>{{ $gSetting->name }}</h2>
                        <small>
                            هاتف: {{ $gSetting->phone }} |
                            <br>
                            ايميل: {{ $gSetting->email_2 }}
                        </small>
                        @if ($from_date || $to_date)
                            <p>من {{ $from_date }}
                                <br>
                                إلى {{ $to_date }}
                            </p>
                        @endif
                    </td>
                    <td style="border:none">
                        صفحة {{ $page }} / {{ $totalPages }}
                    </td>
                    <td style="border:none">
                        <img src="{{ asset('storage/' . $gSetting->logo) }}" height="60">
                    </td>
                </tr>
            </table>

            {{-- ===== Table ===== --}}
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الخدمة</th>
                        <th>اسم العميل</th>
                        <th>المبلغ</th>
                        <th>طريقة الدفع</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($chunk as $index => $invoice)
                        @php
                            $amount = $invoice->purchase_price ?? 0;
                            $totalAmount += $amount;
                            if (!empty($invoice->serviceInvoice) && $invoice->serviceInvoice->method_name) {
                                $payments_arr[$invoice->serviceInvoice?->method_name?->id] += $amount;
                            }
                            $customer = $invoice->customer->name ?? '-';
                            $service = $invoice->service->title ?? '-';
                            $method = $invoice->serviceInvoice?->method_name?->name ?? '-';
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $service }}</td>
                            <td>{{ $customer }}</td>
                            <td>{{ number_format($amount, 2) }}</td>
                            <td>{{ $method }}</td>
                            <td>{{ optional($invoice->created_at)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @php $page++; @endphp
            @if (!$loop->last)
                <div class="pagebreak"></div>
            @endif
        @endforeach
        {{-- ===== Totals ===== --}}
        <table style="margin-top:20px">
            <tr>
                <td colspan="3"><strong>المجموع:</strong> {{ number_format($totalAmount, 2) }} SAR</td>
                <td colspan="3">
                    @foreach ($payments_arr as $id => $value)
                        @if ($value > 0)
                            @php $p = App\Definition::find($id); @endphp
                            {{ $p->icon ?? $p->name }} :
                            {{ number_format($value, 2) }} SAR<br>
                        @endif
                    @endforeach
                </td>
            </tr>
        </table>
        {{-- ===== Footer ===== --}}
        <footer dir="rtl">
            {{ $gSetting->address }} |
            {{ $gSetting->phone }} |
            {{ $gSetting->email_2 }}
        </footer>
    </div>
</body>

</html>
