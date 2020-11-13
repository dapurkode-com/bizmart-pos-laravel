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
            <td class="has-text-centered has-text-weight-bold is-title">Laporan Stok Barang</td>
        </tr>
    </table>

    <table class="table mt-2 is-bordered is-content">
        <tr>
            <th>#</th>
            <th>Barcode</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Kuantitas</th>
            <th>Satuan</th>
        </tr>

        @forelse ($items as $key => $item)
            @php
                $key ++;
            @endphp
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $item->barcode }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->categories
                    ->map(function ($item) {
                        return join('', [ucfirst($item->name)]);
                    })
                    ->implode(', ') }}
                </td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->unit ? $item->unit->name : '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data.</td>
            </tr>
        @endforelse
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
