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
    <!-- main content -->
    <div class="row mainContent">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar User</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
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
                <form>
                    <input type="hidden" name="_remote">
                    <input type="hidden" name="_method">
                    <div class="modal-header">
                        <h4 class="modal-title">User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Tulis nama">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Tulis email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Tulis username">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Tulis password">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
<script>
    // global variable
    var tbIndex = null;

    // dom event
    domReady(() => {
        tbIndex = $('#tbIndex').DataTable({
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

        addListenToEvent('.mainContent .btnAdd', 'click', (e) => {
            const parentElm = document.querySelector('#modalForm');
            
            showModalForm(parentElm, null, 'store');
        });

        addListenToEvent('#modalForm button[type="submit"]', 'click', (e) => {
            e.preventDefault();
            const parentElm = e.target.closest('.modal');

            submitModalForm(parentElm);
        });

        addListenToEvent('.mainContent .btnEdit', 'click', (e) => {
            const parentElm = document.querySelector('#modalForm');
            const thisElm = e.target.closest('button');
            
            showModalForm(parentElm, thisElm, 'update');
        });
    });
    // dom event





    // other function
    function showModalForm(parentElm, thisElm, action) {
        const modalTitle = parentElm.querySelector('.modal-title');
        const modalBody = parentElm.querySelector('.modal-body');
        const modalFooter = parentElm.querySelector('.modal-footer');

        modalTitle.innerHTML = `Loading data...`;
        modalBody.classList.add('d-none');
        modalFooter.classList.add('d-none');
        $(parentElm).modal('show');

        if(action == 'store'){
            parentElm.querySelector(`[name="_remote"]`).value = `{{ route('user.store') }}`;
            parentElm.querySelector(`[name="_method"]`).value = `POST`;

            modalTitle.innerHTML = `Tambah User`;
            modalBody.classList.remove('d-none');
            modalFooter.classList.remove('d-none');
        }
        if(action == 'update'){
            fetch(`${thisElm.dataset.remote_show}`)
            .then(response => response.json())
            .then(result => {
                parentElm.querySelector(`[name="_remote"]`).value = thisElm.dataset.remote_update;
                parentElm.querySelector(`[name="_method"]`).value = `PUT`;
                parentElm.querySelector(`[name="name"]`).value = result.users.name;
                parentElm.querySelector(`[name="email"]`).value = result.users.email;
                parentElm.querySelector(`[name="username"]`).value = result.users.username;
                parentElm.querySelector(`[name="password"]`).value = "";

                modalTitle.innerHTML = `Edit User`;
                modalBody.classList.remove('d-none');
                modalFooter.classList.remove('d-none');
            });
        }
    }

    function submitModalForm(parentElm) {
        let formData = new FormData(parentElm.querySelector('form'));
        let jsonStr = JSON.stringify(fdToJsonObj(formData));
        
        fetch(`${formData.get('_remote')}`, {
            method: `${formData.get('_method')}`,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: jsonStr,
        })
        .then(response => response.json())
        .then(result => {
            if(result.status == 'invalid'){
                drawError(parentElm, result.validators);
            }
            if(result.status == 'valid'){
                swalAlert(result.pesan, 'success');
                tbIndex.ajax.reload();
                $(parentElm).modal('hide');
            }
            if(result.status == 'error'){
                swalAlert(result.pesan, 'warning');
            }
        });
    }
    // other function





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

    function drawError(parentElm, validators) {
        for (const keyName in validators) {
            if (validators.hasOwnProperty(keyName)) {
                const value = validators[keyName][0];
                
                parentElm.querySelector(`[name="${keyName}"]`).classList.add('is-invalid');
                parentElm.querySelector(`[name="${keyName}"]`).closest('.form-group').querySelector('.invalid-feedback').innerHTML = `${value}`;
            }
        }
    }

    function swalAlert(content, type){
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: content,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }

    function fdToJsonObj(formData) {
        let jsonObj = {};
        formData.forEach((value, key) => {jsonObj[key] = value});
        return jsonObj;
    }
    // fixed function

    // fixed event
    domReady(() => {
        addListenToEvent('input, textarea', 'change', (e) => {
            e.target.classList.remove('is-invalid');
            e.target.closest('.form-group').querySelector('.invalid-feedback').innerHTML = ``;;
        });

        addListenToEvent('button[type="reset"]', 'click', (e) => {
            const parentFormElm = e.target.closest('form');
            for (const elm of parentFormElm.querySelectorAll('.is-invalid')) {
                elm.classList.remove('is-invalid');
                elm.closest('.form-group').querySelector('.invalid-feedback').innerHTML = ``;;
            }
        });
    });
    // fixed event
</script>
@stop
