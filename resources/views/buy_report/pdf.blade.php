<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
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
            .text-right {
                text-align: right !important;
            }
		</style>
</head>
<body>
    <section>
    <img src="images/logo1.png" style="height: 9.5mm; width: 9.5mm; position: absolute">

    <table class="table is-paddingless">
        <tr>
            <td style="width: 11mm;">
            </td>
            <td>
                <div class="has-text-weight-bold">{{ $mrch_name->param_value }}</div>
                <div>{{ $mrch_addr->param_value }}</div>
            </td>
        </tr>
    </table>
    <table class="table is-borderless is-paddingless">
        <tr>
            <td class="has-text-centered has-text-weight-bold is-title">Laporan Pembelian</td>
        </tr>
        <tr>
            <td class="has-text-centered">Tanggal {{ $start_date->format('d M Y') }} - {{ $end_date->format('d M Y') }}</td>
        </tr>
    </table>

    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th colspan="7">Daftar Transaksi</th>
        </tr>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Pegawai</th>
            <th>Suplier</th>
            <th>Status</th>
            <th>Total Pembelian</th>
            <th>Total Hutang</th>
        </tr>
        @foreach ($buys as $key => $buy)
            @php
                $key++;
            @endphp
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $buy->buy_status == 'PO' ? "PB-" . str_pad($buy->id, 5, '0', STR_PAD_LEFT) : "HT-" . str_pad($buy->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $buy->user != null ? $buy->user->name : '' }}</td>
                <td>{{ $buy->suplier != null ? $buy->suplier->name : '' }}</td>
                <td>{{ $buy->status }}</td>
                <td class="text-right">{{ number_format($buy->summary) }}</td>
                <td class="text-right">{{ number_format($buy->summary - $buy->payment) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="5">Total</th>
            <th class="text-right">{{ number_format($buys->sum('summary')) }}</th>
            <th class="text-right">{{ number_format($buys->sum('summary') - $buys->sum('payment')) }}</th>
        </tr>
    </table>
    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th colspan="4">Daftar barang yang dibeli</th>
        </tr>
        <tr>
            <th>Barang / Jasa</th>
            <th>Qty</th>
            <th>Biaya</th>
        </tr>
        @foreach ($stockLogs as $log)
            <tr>
                <td>{{ $log->item_name }}</td>
                <td>{{ $log->sum_qty }}</td>
                <td class="text-right">{{ number_format($log->expend) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2">Total</th>
            <th class="text-right">{{ number_format($stockLogs->sum('expend')) }}</th>
        </tr>
    </table>
    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th colspan="2">Daftar Suplier</th>
        </tr>
        <tr>
            <th>Suplier</th>
            <th>Jumlah Transaksi</th>
        </tr>
        @foreach ($supliers as $suplier)
            <tr>
                <td>{{ $suplier->suplier_name }}</td>
                <td>{{ $suplier->count_tx }}</td>
            </tr>
        @endforeach
    </table>
    <table class="table mt-3 is-borderless is-paddingless">
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td width="50%"></td>
            <td width="50%" class="has-text-centered">Denpasar, {{ \Carbon\Carbon::today()->format('j F Y')  }}</td>
        </tr>
        <tr>
            <td class="has-text-centered"></td>
            <td class="has-text-centered"></td>
        </tr>
        <tr>
            <td height="10mm"></td>
            <td height="10mm"></td>
        </tr>
        <tr>
            <td class="has-text-centered"></td>
            <td class="has-text-centered">(____________________________)</td>
        </tr>
    </table>
    </section>
</body>
</html>
