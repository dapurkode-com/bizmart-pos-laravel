@extends('adminlte::page')

@section('title', 'Transaksi Pembelian Barang')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Transaksi Penjualan</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Penjualan</li>
			<li class="breadcrumb-item">
                <a href="{{ route('sell.list') }}">List Penjualan</a>
            </li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
    <div class="row row-flex">
        <div class="col-md-9">
            <div class="card">
                 <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="card-title mb-3"><i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Barang</h3>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Tulis barcode disini." aria-label="Tulis barcode" aria-describedby="basic-addon2">
                        </div>
                        <div class="col-md-6">
                            <select name="barang_id" id="barang_id" class="form-control">
                                <option value="">--Pilih Barang--</option>
                                <option value="1">Bengbeng</option>
                                <option value="2">Top</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <a href="{{ route('sell.list') }}">
                <div class="small-box bg-info">
                    <div class="inner">
                        <p>Total Penjualan</p>
                        <h3>1000</h3>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <form>
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="card-title mb-2"><i class="fas fa-list"></i>&nbsp;&nbsp;Data Keranjang</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm mt-2" >
                                        <thead>
                                            <tr>
                                                <th style="width: 35%">Nama</th>
                                                <th style="width: 10%">Qty</th>
                                                <th style="width: 25%">Harga Jual</th>
                                                <th style="width: 25%">Harga Total</th>
                                                <th style="width: 5%" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Bengbeng</td>
                                                <td><input type="number" class="form-control form-control-sm" value="2"></td>
                                                <td><input type="text" class="form-control form-control-sm" value="2,000.00"></td>
                                                <td><input type="text" class="form-control form-control-sm" value="4,000.00" readonly></td>
                                                <td class="text-center"><a href="#" class="btn btn-sm"><i class="fa fa-trash" style="color:red"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td>Top</td>
                                                <td><input type="number" class="form-control form-control-sm" value="1"></td>
                                                <td><input type="text" class="form-control form-control-sm" value="1,000.00"></td>
                                                <td><input type="text" class="form-control form-control-sm" value="1,000.00" readonly></td>
                                                <td class="text-center"><a href="#" class="btn btn-sm"><i class="fa fa-trash" style="color:red"></i></a></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-right">Total</th>
                                                <th><input type="text" class="form-control form-control-sm" value="5,000.00" readonly></td></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="card-title mb-2"><i class="fas fa-user-check"></i>&nbsp;&nbsp;Penjualan Kepada</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="form-group">
                                    <label>Nama</label>
                                    <select name="konsumen_id" id="konsumen_id" class="form-control">
                                        <option value="">--Pilih Konsumen--</option>
                                        <option value="1">Satya - 081271719209</option>
                                        <option value="2">Pande - 089202928189</option>
                                        <option value="3">Gus ari - 081289389019</option>
                                        <option value="4">Lanang - 082901928190</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Pembayaran</label>
                                    <select name="pembayaran_id" id="pembayaran_id" class="form-control">
                                        <option value="">--Pilih Jenis Pembayaran--</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Debet</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Total Transaksi</label>
                                    <input type="text" class="form-control" value="0.00" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Bayar</label>
                                    <input type="text" class="form-control" value="0.00" placeholder="Masukkan Jumlah Bayar">
                                </div>
                                <div class="form-group">
                                    <label>Kembalian</label>
                                    <input type="text" class="form-control" value="0.00" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea type="text" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-success btn-block float-right">Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
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
        $('select#barang_id').select2();
        $('select#konsumen_id').select2();
        $('select#pembayaran_id').select2();
    })
</script>
@endsection

@section('footer')

@endsection
