@extends('adminlte::page')

@section('title', 'Satuan Barang')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1 class="m-0 text-dark">Satuan Barang</h1>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">Satuan Barang</li>
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
                    <h3 class="card-title">Daftar Satuan Barang</h3>
                    <div class="card-tools">
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#addUnit"><i class="fa fa-plus"></i> Tambah Satuan Barang baru</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tbIndex">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Satuan Barang</th>
                                <th>Deskripsi</th>
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
    <div class="modal fade" id="addUnit" tabindex="-1" role="dialog" aria-labelledby="addUnitLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(array('url'=> route('unit.store'), 'id' => 'addUnitForm')) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitLabel">Tambah Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Nama') !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Tulis nama satuan.','required' => true]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Deskripsi') !!}
                        {!! Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Tulis deskripsi.',]) !!}
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
    <div class="modal fade" id="editUnit" tabindex="-1" role="dialog" aria-labelledby="editUnitLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(array('url'=> '', 'id' => 'editUnitForm', 'method' => 'POST')) !!}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUnitLabel">Edit Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Nama') !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Tulis nama satuan.','required' => true, 'id'=> 'newName']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Deskripsi') !!}
                        {!! Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Tulis deskripsi.', 'id'=>'newDescription']) !!}
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
            ajax: "{{ route('unit.datatables') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'description'},
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
                    $('#editUnitForm').attr('action', url);
                }
            });
        });
    });
</script>
@stop
