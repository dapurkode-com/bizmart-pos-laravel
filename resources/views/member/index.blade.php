@extends('adminlte::page')

@section('title', 'Member')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1 class="m-0 text-dark">Member</h1>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">Member</li>
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
                    <h3 class="card-title">Daftar Member</h3>
                    <div class="card-tools">
                        <a href="{{route('member.create')}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Tambah Member baru</a>
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
                                <th>Member</th>
                                <th>Alamat</th>
                                <th>No Kontak</th>
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
            ajax: "{{ route('member.datatables') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'address'},
                {data: 'phone'},
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
