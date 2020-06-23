@extends('adminlte::page')

@section('title', 'Barang')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1 class="m-0 text-dark">Barang</h1>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">Barang</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Barang</h3>
                    <div class="card-tools">
                        <a href="{{route('item.create')}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Tambah Barang baru</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{{Session::get('message')}}</p>
                        </div>
                    @endif
                    <table class="table table-striped table-bordered" id="tbIndex">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Profit</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script>
    $(document).ready( function () {
        JsBarcode(".barcode").init();
        $('#tbIndex').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('item.datatables') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'barcode', name: 'items.barcode'},
                {data: 'name', name: 'items.name'},
                {data: 'categories', name: 'categories.name'},
                {data: 'buy_price', name: 'items.buy_price', render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp' )},
                {data: 'sell_price', name: 'items.sell_price', render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp' )},
                {data: 'profit', name: 'items.profit', render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp' )},
                {data: 'action', orderable: false, searchable: false, className: 'text-right'},
            ],
            order: [[1, 'asc']]
        });

        $('#tbIndex').on('click', 'button[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                data: {method: '_DELETE', submit: true, _token: '{{csrf_token()}}'},
                beforeSend: function () {
                    return confirm('Apakah anda yakin ?');
                }
            }).always(function (data) {
                $('#tbIndex').DataTable().draw(false);
            });
        });
    });
</script>
@stop