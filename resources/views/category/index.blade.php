@extends('adminlte::page')

@section('title', 'Kategori Barang')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Kategori Barang</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">Kategori Barang</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kategori Barang</h3>
                    <div class="card-tools">
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#addCategory" title="Tambah Data"><i class="fas fa-plus" style="padding-right: 1rem;"></i>Tambah</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tbIndex">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kategori Barang</th>
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
    <!-- Modal -->
    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(array('url'=> route('category.store'), 'id' => 'addCategoryForm')) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Nama') !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Tulis nama satuan.','required' => true]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(array('url'=> '', 'id' => 'editCategoryForm', 'method' => 'POST')) !!}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Nama') !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Tulis nama satuan.','required' => true, 'id'=> 'newName']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                {!! Form::close() !!}
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
            ajax: "{{ route('category.datatables') }}",
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
                {data: 'action', orderable: false, searchable: false, className: 'text-right'},
            ],
            order: [[1, 'asc']]
        });

        $('#tbIndex').on('click', 'button.delete[data-remote]', function (e) {
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

        $('#tbIndex').on('click', 'button.edit[data-remote]', function (e) {
            e.preventDefault();
            var url = $(this).data('remote');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.table(response);
                    $('#newName').val(response.name);
                    $('#newDescription').val(response.description);
                    $('#editCategoryForm').attr('action', url);
                }
            });
        });
    });
</script>
@stop
