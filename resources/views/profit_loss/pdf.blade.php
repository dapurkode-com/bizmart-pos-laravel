<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laba Rugi</title>
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
            table.is-borderdown td, table.is-borderdown th {
				border-bottom: 1px solid rgb(226, 226, 226);
			}
			table.is-content td, table.is-content th {
				padding-top: .5mm;
				padding-bottom: .5mm;
			}
			.is-title {
				font-size: 12px;
			}
            th{
                text-align: left;
            }
		</style>
</head>
<body>
    <section>
    <img src="images/logo.png" style="height: 9.5mm; width: 9.5mm; position: absolute">

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
            <td class="has-text-centered has-text-weight-bold is-title">Laporan Laba Rugi</td>
        </tr>
        <tr>
            <td class="has-text-centered">Bulan {{$months[$month]}} {{ $year }}</td>
        </tr>
    </table>

    <table class="table mt-2 is-borderdown is-content">
       <tr>
            <th colspan="4">PENDAPATAN</th>
        </tr>
        <tr>
            <td colspan="2">Penjualan</td>
            <td class="has-text-right">{{ number_format($sellSummary) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">Potongan Penjualan</td>
            <td class="has-text-right" style="border-bottom: 2px solid black;">0</td>
            <td></td>
        </tr>
        <tr>
            <th colspan="2">JUMLAH PENDAPATAN BERSIH</th>
            <td></td>
            <td class="has-text-right">{{ number_format($sellSummary) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <th colspan="4">HARGA POKOK PENJUALAN (HPP)</th>
        </tr>
        <tr>
            <td colspan="1">Persediaan Barang Awal</td>
            <td class="has-text-right">{{ number_format($stockValueOld) }}</td>
            <td></td><td></td>
        </tr>
        <tr>
            <td colspan="1">Pembelian</td>
            <td class="has-text-right" style="border-bottom: 2px solid black;">{{ number_format($buySummary) }}</td>
            <td></td><td></td>
        </tr>
        <tr>
            <td colspan="2">Barang Tersedia Dijual</td>
            <td class="has-text-right">{{ number_format($buySummary + $stockValueOld) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">Persedian Barang Akhir</td>
            <td class="has-text-right" style="border-bottom: 2px solid black;">{{ number_format($stockValueNew) }}</td>
            <td></td>
        </tr>
        <tr>
            <th colspan="3">HPP</th>
            <td class="has-text-right" style="border-bottom: 2px solid black;">{{ number_format($buySummary + $stockValueOld - $stockValueNew) }}</td>
        </tr>
        <tr>
            <th colspan="3">LABA KOTOR</th>
            <td class="has-text-right">{{ number_format($sellSummary - ($buySummary + $stockValueOld - $stockValueNew)) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <th colspan="4">BEBAN USAHA</th>
        </tr>
        @foreach ($otherExpenseSummary as $oe)
        <tr>
            <td colspan="2">{{ $oe->note?? '-' }}</td>
            <td class="has-text-right">{{ number_format($oe->summary) }}</td>
            <td></td>
        </tr>
        @endforeach
        <tr>
            <th colspan="2">JUMLAH BEBAN USAHA</th>
            <td style="border-top: 2px solid black;"></td>
            <td class="has-text-right" style="border-bottom: 2px solid black;">{{ number_format($otherExpenseSummary->sum('summary')) }}</td>
        </tr>
        <tr>
            <th colspan="3">LABA/RUGI BERSIH</th>
            <td class="has-text-right">{{ number_format($sellSummary - ($buySummary + $stockValueOld - $stockValueNew) - $otherExpenseSummary->sum('summary')) }}</td>
        </tr>

    </table>

    <table class="table mt-3 is-borderless is-paddingless">
        <tr>
            <td width="50%"></td>
            <td width="50%" class="has-text-centered">Denpasar, {{ \Carbon\Carbon::today()->translatedFormat('j F Y')  }}</td>
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
