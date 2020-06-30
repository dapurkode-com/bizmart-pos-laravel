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
    <div class="row subContent">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar User</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm"">
                            <button class="btn btn-sm btn-primary btnAdd"><i class="fas fa-plus" style="padding-right: 1rem;"></i>User Baru</button>
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


    <!-- modal insert edit -->
    <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Inget Ganti Ne</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Inget Ganti Ne</button>
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

        addListenToEvent('.subContent .btnAdd', 'click', (e) => {
            $('#modalForm').modal('show');
        });
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

    function addListenToEvent(elementSelector, eventName, handler) {
        document.addEventListener(eventName, function(e) {
            for (var target = e.target; target && target != this; target = target.parentNode) {
                if (target.matches(elementSelector)) {
                    handler.call(target, e);
                    break;
                }
            }
        }, false);
    }

    // fixed function
</script>
@stop
