@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Opname Stok Barang</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Opname</li>
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
                    <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i> Daftar Opname</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <button class="btn btn-sm btn-info btnAdd" title="Tambah Data"><i class="fas fa-plus" style="padding-right: 1rem;"></i>Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tbIndex" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tgl</th>
                                <th>Uniq ID</th>
                                <th>Oleh</th>
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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form id="insertItemForm">
                    <div class="modal-header">
                        <h4 class="modal-title">Title</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <!-- master info -->
                        <div class="row">
                            <div class="col-lg-8 opnameInfoElm">
                                <!-- <div class="card bg-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Informasi Umum</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-3">Tanggal</dt>
                                            <dd class="col-sm-9">25 Juli 2020</dd>
                                            <dt class="col-sm-3">Uniq ID</dt>
                                            <dd class="col-sm-9">6102246e-4610-4cfc-9df3-3c81bb519b53</dd>
                                            <dt class="col-sm-3">Pembuat</dt>
                                            <dd class="col-sm-9">Admin</dd>
                                            <dt class="col-sm-3">Status</dt>
                                            <dd class="col-sm-9">Sedang Berlangsung</dd>
                                        </dl>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-lg-4 itemInfoElm">
                                <!-- <div class="small-box bg-info mb-3 edit">
                                    <div class="inner">
                                        <h3>150 / 2000</h3>
                                        <p>Barang sudah di Opname</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-cookie-bite"></i>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <!-- insert barang -->
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- <form id="insertItemForm"> -->
                                    <input type="nohidden" name="_remote" class="noReset">
                                    <input type="nohidden" name="_method" class="noReset">
                                    <input type="nohidden" name="opname_id" class="noReset">

                                    <div class="card bg-default">
                                        <div class="card-header">
                                            <h3 class="card-title">Tambahkan Barang</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label>Barang</label>
                                                        <select name="items" class="form-control select2-advance" data-placeholder="Pilih barang" data-url="{{ route('opname.get_items') }}"></select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Qty Sekarang</label>
                                                        <input type="number" name="new_stock" class="form-control" placeholder="Tulis qty barang saat ini">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label>Aksi</label>
                                                        <button type="button" class="btn btn-info btn-block addItemBtn" title="Tambahkan barang ke tabel"><i class="fas fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                <!-- </form> -->
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="reset" class="myReset btn btn-default">Reset</button>
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

        /* navbar */
        ul.navbar-nav li.nav-item.active{
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            background: #0079fa;
            border-radius: .25rem;
        }
        ul.navbar-nav li.nav-item.active a.nav-link{
            color: white;
        }
        /* end navbar */

        /* small box edit */
        @media only screen and (min-width: 992px) {
            .small-box.edit{
                height: 217px;
            }
            .small-box.edit .inner {
                padding-top: 62px;
            }
            .small-box.edit .icon i {
                top: 66px;
            }
        }
        @media (max-width: 767.98px) {
            .small-box.edit {
                text-align: unset;
            }
            .small-box.edit .inner p {
                font-size: unset;
            }
            .small-box.edit .icon {
                display: unset;
            }
        }
        /* end small box edit */

        /* is-invalid on select2 */
        select.is-invalid + .select2 .selection .select2-selection{
            border-color: #dc3545;
        }
        /* end is-invalid on select2 */
    </style>
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
                ajax: "{{ route('opname.datatables') }}",
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'created_at_idn'},
                    {data: 'uniq_id'},
                    {data: 'created_by'},
                    {data: 'status_color', name: 'status_text'},
                    {data: 'action', orderable: false, searchable: false, className: 'text-right text-nowrap'},
                ],
                order: [[1, 'desc']],
                initComplete: () => {
                    initSelect2Datatables();
                },
            });

            addListenToEvent('.mainContent .btnAdd', 'click', (e) => {
                const thisElm = e.target.closest('button');
                let url = `{{ route('opname.store') }}`;
                let text = `melakukan Opname Stock Barang`;

                swalCreate(url, text)
                .then((result) => {
                    if(result){
                        if(result.status == 'valid'){
                            swalAlert(result.pesan, 'success');
                            tbIndex.ajax.reload();
                        }
                        if(result.status == 'invalid'){
                            swalAlert(result.pesan, 'error');
                        }
                        if(result.status == 'error'){
                            swalAlert('Terjadi kesalahan internal', 'warning');
                            console.log(result.pesan);
                        }
                    }
                });
            });
            /*
            addListenToEvent('#modalForm button[type="submit"]', 'click', (e) => {
                e.preventDefault();
                const parentElm = e.target.closest('.modal');
                const thisElm = e.target;

                submitModalForm(parentElm, thisElm);
            });
            */
            
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
                        if(result.status == 'invalid'){
                            swalAlert(result.pesan, 'error');
                        }
                        if(result.status == 'error'){
                            swalAlert('Terjadi kesalahan internal', 'warning');
                            console.log(result.pesan);
                        }
                    }
                });
            });

            addListenToEvent('#modalForm .addItemBtn', 'click', (e) => {
                e.preventDefault();
                const parentElm = e.target.closest('.modal');
                const thisElm = e.target;
                submitItemToOpnameDetail(parentElm, thisElm);
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

            if(action == 'update'){
                fetch(`${thisElm.dataset.remote_show}`)
                .then(response => response.json())
                .then(result => {
                    renderOpnameInfo(parentElm, result);
                    renderItemInfo(parentElm, result);

                    parentElm.querySelector('#insertItemForm input[name="_remote"]').value = `${thisElm.dataset.remote_store_opaname_detail}`;
                    parentElm.querySelector('#insertItemForm input[name="_method"]').value = 'POST';
                    parentElm.querySelector('#insertItemForm input[name="opname_id"]').value = result.opname.id;

                    modalTitle.innerHTML = `Proses Opname`;
                    modalBody.classList.remove('d-none');
                    modalFooter.classList.remove('d-none');
                });
            }
        }
        
        /*
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
        */
        function submitItemToOpnameDetail(parentElm, thisElm) {
            let formData = new FormData(parentElm.querySelector('form#insertItemForm'));
            let jsonStr = JSON.stringify(fdToJsonObj(formData));
            
            // loading and disabled button
            const buttonText = thisElm.innerHTML;
            thisElm.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i>`
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

        function renderOpnameInfo(parentElm, data){
            let html = `
                <div class="card bg-info">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Umum</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Tanggal</dt>
                            <dd class="col-sm-9">${getIndoDate(data.opname.created_at)}</dd>
                            <dt class="col-sm-3">Uniq ID</dt>
                            <dd class="col-sm-9">${data.opname.uniq_id}</dd>
                            <dt class="col-sm-3">Pembuat</dt>
                            <dd class="col-sm-9">${data.opname.user.name}</dd>
                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-9">${data.statusText}</dd>
                        </dl>
                    </div>
                </div>
            `;

            parentElm.querySelector('.opnameInfoElm').innerHTML = html;
        }

        function renderItemInfo(parentElm, data){
            let html = `
                <div class="small-box bg-info mb-3 edit">
                    <div class="inner">
                        <h3>0 / ${data.count_item}</h3>
                        <p>Barang sudah di Opname</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cookie-bite"></i>
                    </div>
                </div>
            `;

            parentElm.querySelector('.itemInfoElm').innerHTML = html;
        }





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

        function swalCreate(url, text){
            return new Promise((resolve, reject) => {
                Swal.fire({
                    customClass: {
                        confirmButton: 'btn btn-info',
                        cancelButton: 'btn btn-default'
                    },
                    buttonsStyling: false,
                    focusCancel: true,
                    position: 'top',
                    icon: 'question',
                    text: `Apakah anda yakin untuk ${text}?`,
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () =>
                        fetch(url, {
                            method: `POST`,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                '_method' : 'POST'
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

        function initSelect2Advance(){
            $('select.select2-advance').select2({
                width: '100%',
                placeholder: () => {
                    return $(this).data('placeholder');
                },
                language: {
                    errorLoading: function(){
                        return "Searching..."
                    }
                },
                allowClear: false,
                ajax: {
                    url: function () {
                        return $(this).data('url');
                    },
                    dataType: 'json',
                    data: function (params) {
                        return {
                            _token: `{{ csrf_token() }}`,
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    cache: true
                }
            });
        }

        function getIndoDate(val){
            let date = new Date(val).toDateString();
            let date_split = date.split(' ');
            return `${date_split[2]} ${date_split[1]} ${date_split[3]}`;
        }
        // fixed function

        // fixed event
        domReady(() => {
            initSelect2Advance();

            addListenToEvent('input, textarea', 'change', (e) => {
                e.target.classList.remove('is-invalid');
                e.target.closest('.form-group').querySelector('.invalid-feedback').innerHTML = ``;
            });
            $(document).on('change', '.select2-advance', (e) => {
                e.target.classList.remove('is-invalid');
                e.target.closest('.form-group').querySelector('.invalid-feedback').innerHTML = ``;
            })

            addListenToEvent('button[type="reset"].myReset', 'click', (e) => {
                e.preventDefault();
                const parentFormElm = e.target.closest('form');
                for (const elm of parentFormElm.querySelectorAll('.is-invalid')) {
                    elm.classList.remove('is-invalid');
                    elm.closest('.form-group').querySelector('.invalid-feedback').innerHTML = ``;
                }

                for (const elm of parentFormElm.querySelectorAll('input:not(.noReset)')) {
                    elm.value = '';
                }

                $(parentFormElm).find('select:not(.noReset).select2-advance').each(function(i, elm){
                    $(elm).val('').trigger('change');
                })
            });
        });
        // fixed event
    </script>
@stop
