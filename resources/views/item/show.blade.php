@extends('adminlte::page')

@section('title', 'Data Barang ['.$item->name.']')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">{{ $item->name }}</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('item.index') }}">Barang</a>
            </li>
			<li class="breadcrumb-item active">Data {{ $item->name }}</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Barang</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Barcode</th>
                            <td>
                                <svg class="barcode" jsbarcode-width="1"
                                jsbarcode-format="auto"
                                jsbarcode-value="{{ $item->barcode }}"
                                jsbarcode-textmargin="0"
                                jsbarcode-fontoptions="bold">
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $item->name }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                @foreach ($item->categories as $category)
                                    <span class="badge badge-info "> {{ $category->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $item->description }}</td>
                        </tr>
                        <tr>
                            <th>Stok Aktif</th>
                            <td>{{ $item->stockActiveText() }}</td>
                        </tr>
                        <tr>
                            <th>Stok Minimal</th>
                            <td>{{ $item->min_stock }}</td>
                        </tr>
                        <tr>
                            <th>Satuan Stok</th>
                            <td>{{ $item->unit->name }}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>{{ $item->buy_price }}</td>
                        </tr>
                        <tr>
                            <th>Penentu Harga Jual</th>
                            <td>{{ $item->sellPriceDeterminantText() }}</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>{{ $item->sell_price }}</td>
                        </tr>
                        <tr>
                            <th>Profit</th>
                            <td>{{ $item->profit }}</td>
                        </tr>
                        <tr>
                            <th>Margin</th>
                            <td>{{ $item->margin }}</td>
                        </tr>
                        <tr>
                            <th>Markup</th>
                            <td>{{ $item->markup }}</td>
                        </tr>
                        <tr>
                            <th>Pembelian Terakhir</th>
                            <td>{{ $item->last_buy_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Penjualan Terakhir</th>
                            <td>{{ $item->last_sell_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Stock Opname Terakhir</th>
                            <td>{{ $item->last_opname_at ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Dibuat pada {{ $item->created_at->diffForHumans(['options' => 0]) }} oleh {{ $item->created_by }}. Diubah pada {{ $item->updated_at->diffForHumans(['options' => 0]) }} oleh {{ $item->updated_by }}.</small>
                    <a href="{{ route('item.edit', $item->slug) }}" class="btn btn-warning float-right"><i class="fa fa-edit"></i> Ubah</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script>
    $(document).ready(function () {
        JsBarcode(".barcode").init();
    })
</script>
@endsection
