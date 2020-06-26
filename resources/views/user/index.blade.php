@extends('adminlte::page')

@section('title', 'User | Bizmart')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">USER</h1>
        </blockquote>
	</div>
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">User</li>
		</ol>
	</div>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar User</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm"">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-plus" style="padding-right: 1rem;"></i>User Baru</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tbIndex" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
    tbIndex = null;

    domReady(() => {
        $('#tbIndex').DataTable({
            processing: true,
            serverSide: true,
            language: {
				paginate: {
					previous: '<i class="fas fa-chevron-left"></i>',
					next: '<i class="fas fa-chevron-right"></i>'
				},
				lengthMenu: '_MENU_',
				search: '',
				searchPlaceholder: 'Search data'
            },
            scrollX: true,
            ajax: "{{ route('user.datatables') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'username'},
                {data: 'email'},
                {data: 'action', orderable: false, searchable: false, className: 'text-right text-nowrap'},
            ],
            order: [[1, 'asc']],
            initComplete: () => {
                initSelect2Datatables();
            },
        });

        // $('#tbIndex').on('click', 'button[data-remote]', function (e) {
        //     e.preventDefault();
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     var url = $(this).data('remote');

        //     $.ajax({
        //         url: url,
        //         type: 'DELETE',
        //         dataType: 'json',
        //         data: {method: '_DELETE', submit: true, _token: '{{csrf_token()}}'},
        //         beforeSend: function () {
        //             return confirm('Apakah anda yakin ?');
        //         }
        //     }).always(function (data) {
        //         $('#tbIndex').DataTable().draw(false);
        //     });
        // });
    });



    // fixed function
    function domReady(fn) {
        if (document.readyState != 'loading'){
            fn();
        } else if (document.addEventListener) {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            document.attachEvent('onreadystatechange', function() {
            if (document.readyState != 'loading')
                fn();
            });
        }
    }

    function initSelect2Datatables() {
        for (const elm of document.querySelectorAll('.dataTables_length select')) {
            $(elm).select2({
                minimumResultsForSearch: Infinity
            });
        }
        for (const elm of document.querySelectorAll('.dataTables_length span.select2')) {
            elm.style.width = '5rem';
        }
        
    }
    // fixed function
</script>
@stop
