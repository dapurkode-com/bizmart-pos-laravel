<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Penjualan | SIPDS</title>
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
						<div class="has-text-weight-bold">{{ $sys_param->mrch_name }}</div>
						<div>{{ $sys_param->mrch_addr }}</div>
					</td>
					<td class="has-text-right">
						<div class="has-text-weight-bold">No Penjualan</div>
						<div>{{ $sell->uniq_id }}</div>
					</td>
				</tr>
			</table>

			<table class="table mt-1 is-borderless is-paddingless">
				<tr>
					<td>
						<div> Denpasar, {{ $sell->updated_at->format('j F Y') }}</div>
						<div class="has-text-weight-bold">{{ $sell->member->name }}</div>
						<div>{{ $sell->member->address ?? '-' }}</div>
						<div>Telp/HP: {{ $sell->suplier->phone ?? '-' }}</div>
					</td>
				</tr>
			</table>

			<table class="table is-borderless is-paddingless">
				<tr>
					<td class="has-text-centered">
						<div class="has-text-weight-bold is-title">Invoice</div>
						<div class="is-title">{{ $sell->sellCode() }}</div>
					</td>
				</tr>
				<tr>
					<td class="has-text-centered is-title"></td>
				</tr>
			</table>

			<table class="table mt-2 is-bordered is-content">
				<tr>
					<th class="has-text-left">#</th>
					<th class="has-text-left">Barcode</th>
					<th class="has-text-left">Nama</th>
					<th class="has-text-right">Qty</th>
					<th class="has-text-right">Harga</th>
					<th class="has-text-right">Harga Total</th>
				</tr>

				@foreach ($sell->sellDetails as $detail)
					<tr>
						<td class="has-text-left">{{ $loop->iteration }}</td>
						<td class="has-text-left">{{ $detail->item->barcode }}</td>
						<td class="has-text-left">{{ $detail->item->name }}</td>
						<td class="has-text-right">{{ $detail->qty }}</td>
						<td class="has-text-right">{{ number_format($detail->sell_price, 0, ".", ",") }}</td>
						<td class="has-text-right">{{ number_format(($detail->qty * $detail->sell_price), 0, ".", ",") }}</td>
					</tr>
				@endforeach

				<tr>
					<th colspan="5" class="has-text-right">Total</th>
					<th class="has-text-right">{{ number_format($sell->summary, 0, ".", ",") }}</th>
				</tr>
				<tr>
					<th colspan="5" class="has-text-right">Nominal Bayar</th>
					<th class="has-text-right">{{ number_format($sell->paid_amount, 0, ".", ",") }}</th>
				</tr>
			</table>

			<table class="table mt-3 is-borderless is-paddingless">
				<tr>
					<td width="50%">Note: {{ $sell->status_text }}</td>
					<td width="50%" class="has-text-right"></td>
				</tr>
			</table>
		</section>
	</body>
</html>
