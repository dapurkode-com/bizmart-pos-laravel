<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Barang |  </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.0/css/bulma.min.css">
		<style>
			body {
				font-family: Consolas, monaco, monospace;
				font-size: 10px;
			}
			section {
				margin: 5mm 10mm;
			}
			table {
				width: 100%;
			}
			table.is-borderless td, table.is-borderless th {
				border: 0;
			}
			table.is-paddingless td, table.is-paddingless th {
				padding-left: 0;
				padding-right: 0;
			}
			table.is-content td, table.is-content th {
				padding-top: .5mm;
				padding-bottom: .5mm;
			}
			.is-title {
				font-size: 12px;
			}
		</style>
</head>
<body>
    <section>
    <img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}" style="height: 9.5mm; width: 9.5mm; position: absolute">

    <table class="table is-paddingless">
        <tr>
            <td style="width: 11mm;">
            </td>
            <td>
                <div class="has-text-weight-bold">{{ $mrch_name->param_value }}</div>
                <div>{{ $mrch_addr->param_value }}</div>
            </td>
            <td class="has-text-right">
                <div class="has-text-weight-bold">No Invoice</div>
                <div>{{ $buys->uniq_id }}</div>
            </td>
        </tr>
    </table>

    <table class="table mt-1 is-borderless is-paddingless">
        <tr>
            <td>
                <div>Kepada:</div>
                <div class="has-text-weight-bold">{{ $buys->suplier->name }}</div>
                <div>{{ $buys->suplier->address  ?? '-' }}</div>
                <div>Telp/HP: {{ $buys->suplier->phone ?? '-' }}</div>
            </td>
        </tr>
    </table>

    <table class="table is-borderless is-paddingless">
        <tr>
            <td class="has-text-centered has-text-weight-bold is-title">Invoice Barang</td>
        </tr>
    </table>

    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Barcode</th>
            <th>Qty</th>
            <th>Harga Barang</th>
            <th>Subtotal</th>
        </tr>

        @foreach ($details as $i => $detail)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $detail->item->name }}</td>
                <td>{{ $detail->item->barcode }}</td>
                <td>{{ $detail->qty}}</td>
                <td>{{ number_format($detail->buy_price, 2, ".", ",") }}</td>
                <td>{{ number_format($detail->qty * $detail->buy_price, 2, ".", ",") }}</td>

            </tr>
        @endforeach

        <tr>
            <th colspan="5" class="has-text-right">Total</th>
            <th class="has-text-right">{{ number_format($buys->summary, 2, ".", ",") }}</th>
        </tr>
    </table>

    <table class="table mt-3 is-borderless is-paddingless">
        <tr>
            <td width="50%"></td>
            <td width="50%" class="has-text-right">Singaraja, {{ $buys->updated_at->format('j F Y')  }}</td>
        </tr>
        <tr>
            <td class="has-text-centered">Penerima,</td>
            <td class="has-text-centered">Pemohon,</td>
        </tr>
        <tr>
            <td height="10mm"></td>
            <td height="10mm"></td>
        </tr>
        <tr>
            <td class="has-text-centered">(____________________________)</td>
            <td class="has-text-centered">(____________________________)</td>
        </tr>
    </table>
    </section>
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>
</html>
