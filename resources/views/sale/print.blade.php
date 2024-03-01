<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota</title>

    <?php
    $style = '<style>p{display:block;margin:3px;font-size:10pt}p .address{font-size:5pt}table td{font-size:9pt}.text-center{text-align:center}.text-right{text-align:right}@media print{@page{margin:0;size:75mm}}';
    ?>
    <?php
    $style .= !empty($_COOKIE['innerHeight']) ? $_COOKIE['innerHeight'] . 'mm; }' : '}';
    ?>
    <?php
    $style .= 'body,html{width:70mm}.btn-print{display:none}</style>';
    ?>

    {!! $style !!}
</head>

<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;"
        onclick="window.print()">Print</button>
    <div class="text-center">
        <h2 style="margin-bottom: 5px;">Laravel</h2>
        <p class="address">
            Jl. Lorem ipsum dolor sit amet consectetur adipisicing elit.
        </p>
    </div>
    <br>
    <div>
        <p style="float: left;">{{ date('d-m-Y') }}</p>
        <p style="float: right">{{ strtoupper(auth()->user()->name) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>No: {{ add_zero_infront($sale->id, 10) }}</p>
    <p class="text-center">===================================</p>

    <br>
    <table width="100%" style="border: 0;">
        @foreach ($saleDetail as $item)
            <tr>
                <td colspan="3">{{ $item->products->name }}</td>
            </tr>
            <tr>
                <td>{{ $item->quantity }} x {{ indonesia_format($item->price) }}
                </td>
                <td></td>
                <td class="text-right">
                    {{ indonesia_format($item->quantity * $item->price) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Item:</td>
            <td class="text-right">{{ indonesia_format($sale->total_items) }}
            </td>
        </tr>
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">{{ indonesia_format($sale->total_price) }}
            </td>
        </tr>
        <tr>
            <td>Total Bayar:</td>
            <td class="text-right">{{ indonesia_format($sale->total_price) }}
            </td>
        </tr>
        <tr>
            <td>Diterima:</td>
            <td class="text-right">
                {{ indonesia_format(session()->get('last_sale.received')) }}
            </td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td class="text-right">
                {{ indonesia_format(session()->get('last_sale.received') - $sale->total_price) }}
            </td>
        </tr>
    </table>

    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );

        document.cookie =
            "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583);
    </script>
</body>

</html>
