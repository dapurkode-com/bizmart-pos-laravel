@extends('adminlte::page')

@section('title', 'Transaksi Pembelian Barang')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Transaksi Pembelian</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('buy.index') }}">Pembelian</a>
            </li>
			<li class="breadcrumb-item active">Buat Baru</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
    <div class="row row-flex">
        <div class="col-md-6">
             <div class="card">
                 <div class="card-body">
                    <h3 class="card-title mb-3"><i class="fa fa-search"></i> Pencari Barang</h3>
                    <div class="input-group">
                    <input type="text" class="form-control" placeholder="Tulis barcode disini." aria-label="Tulis barcode" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#itemList"><i class="fa fa-list"></i> List Barang</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <p>Total Pembelian</p>
                    <h3>1000</h3>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pembelian</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 border p-3">
                            <b>Barang yang dibeli</b>
                            <table class="table table-bordered table-sm mt-2" >
                                <thead>
                                    <tr>
                                        <th style="width: 40%">Nama</th>
                                        <th style="width: 20%">Qty</th>
                                        <th style="width: 30%">Harga Beli</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Bengbeng</td>
                                        <td><input type="number" class="form-control" value="1"></td>
                                        <td><input type="number" class="form-control" value="1000"></td>
                                        <td><button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                        <div class="col-sm-6 border p-3">
                            <div class="form-group">
                                <label for="suplier_id"> Cari Suplier</label>
                                <select name="suplier_id" id="suplier_id" class="form-control">
                                    <option value="">--Pilih Suplier--</option>
                                    <option value="1">Agus</option>
                                </select>
                            </div>
                            <table class="table table-bordered table-sm table-striped">
                                <tr>
                                    <th>Nama Suplier</th>
                                    <td>UD Sumber Hasil</td>
                                </tr>
                                <tr>
                                    <th>No Kontak</th>
                                    <td>0362 22149</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>Jalan Kampung Tinggi</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-lg btn-block btn-danger"><i class="fa fa-times"></i> Batalkan</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-lg btn-block btn-success"><i class="fa fa-check"></i> Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="itemList" tabindex="-1" role="dialog" aria-labelledby="itemListLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="itemListLabel">Daftar barang pada persediaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bengbeng 200 g</td>
                                <td>snack, roti</td>
                                <td>Lorem insum.....</td>
                                <td><button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button></td>
                            </tr>
                            <tr>
                                <td>Bengbeng 150 g</td>
                                <td>snack, roti</td>
                                <td>Lorem insum.....</td>
                                <td><button class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('select#suplier_id').select2();
    })
</script>
@endsection

@section('footer')

@endsection
