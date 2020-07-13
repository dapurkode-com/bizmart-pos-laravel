@extends('adminlte::page')

@section('title', 'Suplier')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Suplier</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">Suplier</li>
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
                    <h3 class="card-title">Daftar Suplier</h3>
                    <div class="card-tools">
                        <a href="{{route('suplier.create')}}" class="btn btn-info btn-sm" title="Tambah Data"><i class="fas fa-plus" style="padding-right: 1rem;"></i>Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{{Session::get('message')}}</p>
                        </div>
                    @endif
                    <table class="table table-striped" id="tbIndex">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Suplier</th>
                                <th>Alamat</th>
                                <th>No Kontak</th>
                                <th>Keterangan</th>
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
<script>
    $(document).ready( function () {
        $('#tbIndex').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('suplier.datatables') }}",
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
                {data: 'name'},
                {data: 'address'},
                {data: 'phone'},
                {data: 'description'},
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
