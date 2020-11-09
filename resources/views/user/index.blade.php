@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">User</h1>
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
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar User</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-info btnAdd" title="Tambah Data"><i class="fas fa-plus mr-2"></i>Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tbIndex" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Hak Akses</th>
                                <th>Status</th>
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
    <style>
        /* sweetalert */
		.swal2-container .swal2-actions button {
			margin: 0 2px 1rem;
		}
		.swal2-container .swal2-validation-message {
			margin-top: 1rem;
		}
		/* end sweetalert */
    </style>
@stop

@section('js')
<script>
    // global variable
    let tbIndex = null;

    // dom event
    domReady(() => {
        tbIndex = $('#tbIndex').DataTable({
            processing: true,
            serverSide: true,
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
            scrollX: true,
            ajax: "{{ route('user.datatables') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'email'},
                {data: 'username'},
                {data: 'privilege_code'},
                {data: 'is_active'},
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
            const thisElm = e.target;

            submitModalForm(parentElm, thisElm);
        });

        addListenToEvent('.mainContent .btnEdit', 'click', (e) => {
            const parentElm = document.querySelector('#modalForm');
            const thisElm = e.target.closest('button');

            showModalForm(parentElm, thisElm, 'update');
        });

        addListenToEvent('.mainContent .btnDelete', 'click', (e) => {
            const thisElm = e.target.closest('button');
            let url = `${thisElm.dataset.remote_destroy}`;

            swalDelete(url)
            .then((result) => {
                if(result){
                    if(result.status == 'valid'){
                        swalAlert(result.pesan, 'success');
                        tbIndex.ajax.reload();
                    }
                    if(result.status == 'error'){
                        swalAlert(result.pesan, 'warning');
                    }
                }
            });
        });
    });
    // dom event





    // other function
    function showModalForm(parentElm, thisElm, action) {
        const modalTitle = parentElm.querySelector('.modal-title');
        const modalBody = parentElm.querySelector('.modal-body');
        const modalFooter = parentElm.querySelector('.modal-footer');
        const resetBtn = parentElm.querySelector('button[type="reset"]');

        modalTitle.innerHTML = `Loading data...`;
        modalBody.classList.add('d-none');
        modalFooter.classList.add('d-none');
        simulateEvent(resetBtn, 'click');
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

    function submitModalForm(parentElm, thisElm) {
        let formData = new FormData(parentElm.querySelector('form'));
        let jsonStr = JSON.stringify(fdToJsonObj(formData));

        // loading and disabled button
        const buttonText = thisElm.innerHTML;
        thisElm.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i> ${buttonText}...`
        for (const elm of parentElm.querySelectorAll('button')) {
            elm.disabled = true;
        }

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
        })
        .finally(() => {
            // loading and disabled button
            thisElm.innerHTML = `${buttonText}`
            for (const elm of parentElm.querySelectorAll('button')) {
                elm.disabled = false;
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

    function swalDelete(url){
        return new Promise((resolve, reject) => {
            Swal.fire({
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-default'
                },
                buttonsStyling: false,
                focusCancel: true,
                position: 'center',
                icon: 'question',
                text: 'Apakah anda yakin untuk menghapus data ini?',
                showCancelButton: true,
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () =>
                    fetch(url, {
                        method: `DELETE`,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            '_method' : 'DELETE'
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Tidak ada respon. Reload atau perbaiki koneksi anda!`);
                    }),
                allowOutsideClick: () => !Swal.isLoading()
            })
            .then(result => {
                resolve(result.value);
            });
        });
    }

    function fdToJsonObj(formData) {
        let jsonObj = {};
        formData.forEach((value, key) => {jsonObj[key] = value});
        return jsonObj;
    }

    function simulateEvent(elm, eventName) {
        let evt = new MouseEvent(eventName, {
            bubbles: true,
            cancelable: true,
            view: window
        });
        let canceled = !elm.dispatchEvent(evt);
    };
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
