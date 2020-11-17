<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
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
            <td class="has-text-centered has-text-weight-bold is-title">Laporan Penjualan</td>
        </tr>
        <tr>
            <td class="has-text-centered">Tanggal {{ $date_start->format('d M Y') }} - {{ $date_end->format('d M Y') }}</td>
        </tr>
    </table>

    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th colspan="7">Daftar Transaksi</th>
        </tr>
        <tr>
            <th class="has-text-left">#</th>
            <th class="has-text-left">ID</th>
            <th class="has-text-left">Pegawai</th>
            <th class="has-text-left">Member</th>
            <th class="has-text-left">Status</th>
            <th class="has-text-right">Total Pembelian</th>
            <th class="has-text-right">Total Hutang</th>
        </tr>
        @foreach ($sells as $key => $sell)
            @php
                $key++;
            @endphp
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $sell->sell_status == 'PO' ? "PJ-" . str_pad($sell->id, 5, '0', STR_PAD_LEFT) : "PI-" . str_pad($sell->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $sell->user != null ? $sell->user->name : '' }}</td>
                <td>{{ $sell->member != null ? $sell->member->name : '' }}</td>
                <td>{{ $sell->status }}</td>
                <td class="text-right">{{ number_format($sell->summary) }}</td>
                <td class="text-right">{{ number_format($sell->summary - $sell->payment) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="5" class="has-text-right">Total</th>
            <th class="text-right">{{ number_format($sells->sum('summary')) }}</th>
            <th class="text-right">{{ number_format($sells->sum('summary') - $sells->sum('payment')) }}</th>
        </tr>
    </table>
    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th colspan="4">Daftar barang yang dibeli</th>
        </tr>
        <tr>
            <th class="has-text-left">Barang / Jasa</th>
            <th class="has-text-right">Qty</th>
            <th class="has-text-right">Laba Kotor</th>
            <th class="has-text-right">Laba Bersih</th>
        </tr>
        @foreach ($stockLogs as $log)
            <tr>
                <td>{{ $log->item_name }}</td>
                <td class="has-text-right">{{ $log->sum_qty }}</td>
                <td class="text-right">{{ number_format($log->gross_income) }}</td>
                <td class="text-right">{{ number_format($log->net_income) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="2" class="has-text-right">Total</th>
            <th class="text-right">{{ number_format($stockLogs->sum('gross_income')) }}</th>
            <th class="text-right">{{ number_format($stockLogs->sum('net_income')) }}</th>
        </tr>
    </table>
    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th colspan="2">Daftar member yang membeli</th>
        </tr>
        <tr>
            <th class="has-text-left">Member</th>
            <th class="has-text-right">Jumlah Transaksi</th>
        </tr>
        @foreach ($members as $member)
            <tr>
                <td>{{ $member->member_name }}</td>
                <td class="has-text-right">{{ $member->count_tx }}</td>
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
