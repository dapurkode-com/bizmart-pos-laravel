<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Arus Kas |  </title>
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
            <td class="has-text-centered has-text-weight-bold is-title">Laporan Arus Kas</td>
        </tr>
    </table>

    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th>#</th>
            <th>Ref ID</th>
            <th>Tanggal</th>
            <th>Oleh</th>
            <th>Keterangan</th>
            <th>Arus</th>
            <th class="text-right">Sejumlah</th>
        </tr>
        @php
            $total = 0;
        @endphp
        @forelse ($cashflows as $key => $flow)
            @php
                $key++;
                $total += $flow->amount;
            @endphp
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $flow->ref_uniq_id }}</td>
                <td>{{ $flow->trx_date->format('d M Y') }}</td>
                <td>{{ $flow->user->name }}</td>
                <td>{!! $flow->cashCauseText() !!}</td>
                <td>{!! $flow->ioCashText() !!}</td>
                <td class="text-right">
                    {{ number_format($flow->amount) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
        <tr>
            <td colspan="6" class="text-right"><strong>Total</strong></td>
            <td class="text-right">{{ number_format($total) }}</td>
        </tr>
    </table>

    <table class="table mt-3 is-borderless is-paddingless">
        <tr>
            <td width="50%"></td>
            <td width="50%" class="has-text-centered">Denpasar, {{ \Carbon\Carbon::today()->format('j F Y')  }}</td>
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
</body>
</html>
