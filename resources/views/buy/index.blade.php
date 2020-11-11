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
                    <div class="buyTableFilter">
                        <div class="form-group mb-0">
                            <input type="date" name="start_date" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            <input type="date" name="end_date" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="button" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                    </div>
                    
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
    <style>
        .buyTableFilter {
            display: grid;
            grid-template-columns: 0fr 0fr 0fr 1fr;
            gap: 1rem;
            align-items: center;
        }
        .buyTableFilter .filterButton {
            width: 80px;
            justify-self: end;
        }
        @media only screen and (max-width: 617px) {
            .buyTableFilter {
                grid-template-columns: 1fr;
                justify-items: center;
                gap: 0;
            }
            .buyTableFilter .filterButton {
                margin-top: 1rem;
                width: 185.19px;
                justify-self: center;
            }
        }
        .sisaHutangBtn {
            border-radius: 0 4px 4px 0 !important;
        }
    </style>
@stop

@section('js')
<script>
    $('#tbIndex').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:"{{ route('buy.datatables_report') }}",
            data: function (d){
                d.filter = {
                    'start_date': $('input[name="start_date"]').val(),
                    'end_date':   $('input[name="end_date"]').val()
                }
            }
        },
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

    $(document).ready( function () {

        $('.filterButton').click(function (e) {
            $('#tbIndex').DataTable().ajax.reload();
        })
        
    });

</script>
@stop
