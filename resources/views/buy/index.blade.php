@extends('adminlte::page')

@section('title', 'Daftar Pembelian')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Daftar Pembelian</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">Daftar Pembelian</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-inline">
                        <div class="col-sm-5 form-group" style="white-space:nowrap">
                            <label for="start_date">Tanggal Awal</label>
                            <input type="date" class="form-control" name="start_date">

                        </div>
                        <div class="col-sm-5 form-group" style="white-space:nowrap">
                            <label for="finish_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="finish_date">

                        </div>
                            <button type="button" class="btn btn-primary float-right">Cari</button>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar List Pembelian</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tbIndex" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Kode Pembelian</th>
                                <th>Suplier</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
                    </table>
               </div>
           </div>
       </div>
   </div>
@stop

@section('css')

@stop

@section('js')
<script>
    $(document).ready( function () {
        $('#tbIndex').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('buy.datatables_report') }}",
            language: {
                decimal:        "",
                emptyTable:     "Tidak ada data di dalam tabel",
                info:           "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                infoEmpty:      "Data kosong",
                infoFiltered:   "(Difilter dari _MAX_ total data)",
                infoPostFix:    "",
                thousands:      ".",
                lengthMenu:     "Tampilkan _MENU_ data",
                loadingRecords: "Memuat...",
                processing:     "Memproses...",
                search:         "",
                zeroRecords:    "Tidak ada data yang cocok",
                paginate: {
                    previous: '<i class="fas fa-chevron-left"></i>',
					next: '<i class="fas fa-chevron-right"></i>'
                },
                aria: {
                    sortAscending:  ": mengurutkan kolom yang naik",
                    sortDescending: ": mengurutkan kolom yang turun"
                },
                searchPlaceholder: 'Cari data',
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'created_at'},
                {data: 'uniq_id'},
                {data: 'suplier.name'},
                {data: 'summary'},
                {data: 'buy_status'},
                {data: 'action', orderable: false, searchable: false, className: 'text-right'},
            ],
            order: [[1, 'asc']]
        });

        
    });
</script>
@stop
