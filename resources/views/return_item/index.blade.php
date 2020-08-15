@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Retur Barang Ke Supplier</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Retur</li>
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
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Retur</h5>
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
                                <th>ID</th>
                                <th>Tgl</th>
                                <th>Uniq ID</th>
                                <th>Suplier</th>
                                <th>Total</th>
                                <th>Oleh</th>
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
    <form>
        <div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Title</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="_remote" class="noReset">
                                <input type="hidden" name="_method" class="noReset">

                                <div class="card bg-default">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Informasi Umum</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Supplier</label>
                                                    <select name="suppliers" class="form-control select2-advance" data-placeholder="Pilih supplier" data-url="{{ route('return_item.get_suppliers') }}"></select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea name="note" rows="5" class="form-control" placeholder="Tulis keterangan tambahan"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- insert barang -->
                        <div class="row insertBarangElm">
                            <div class="col-sm-12">
                                <div class="card bg-default">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Pilih Barang</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label>Barang</label>
                                                    <select name="items" class="form-control select2-advance" data-placeholder="Pilih barang" data-url="{{ route('return_item.get_items') }}"></select>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Qty Retur</label>
                                                    <input type="number" name="qty" class="form-control" placeholder="Tulis qty retur">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label>Aksi</label>
                                                    <button type="button" class="btn btn-info btn-block btnAddItem" title="Tambahkan barang ke tabel"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- opname details -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card bg-default mb-0">
                                    <div class="card-header">
                                        <h3 class="card-title">List Barang yang akan diretur</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Barcode</th>
                                                    <th>Nama Barang</th>
                                                    <th>Qty Retur</th>
                                                    <th>Harga Beli</th>
                                                    <th class="text-right">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                    </div>
                </div>
            </div>
        </div>
    </form>

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
            padding-right: 16px;
            padding-left: 16px;
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

        /* multiple modal */
        .modal {
            overflow-y: auto !important;
        }
        /* multiple modal */
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
                ajax: "{{ route('return_item.datatables') }}",
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'ID', orderable: false, searchable: false, visible: false, printable: false},
                    {data: 'updated_at_idn'},
                    {data: 'uniq_id'},
                    {data: 'suplier_name'},
                    {data: 'summary_iso'},
                    {data: 'user_name', name: 'status_text'},
                    {data: 'action', orderable: false, searchable: false, className: 'text-right text-nowrap'},
                ],
                order: [[1, 'desc']],
                initComplete: () => {
                    initSelect2Datatables();
                },
            });

            addListenToEvent('.mainContent .btnAdd', 'click', (e) => {
                const thisElm = e.target.closest('button');
                showModalForm(thisElm, 'store');
            });

            addListenToEvent('#modalForm .btnAddItem', 'click', (e) => {
                const parentElm = document.querySelector('#modalForm');
                const thisElm = e.target.closest('button');
                const itemsElm = $(parentElm).find('select[name="items"]');
                const qtyElm = parentElm.querySelector('input[name="qty"]');
                
                let dataJson = JSON.stringify({
                    'items': itemsElm.val(),
                    'qty': qtyElm.value
                });
                
                // loading and disabled button
                const buttonText = thisElm.innerHTML;
                thisElm.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i>`
                for (const elm of parentElm.querySelectorAll('button')) {
                    elm.disabled = true;
                }
                validateToServer(`{{ route('return_item.validate_add_item') }}`, dataJson)
                    .then((result) => {
                        if(result.status == 'invalid'){
                            drawError(parentElm, result.validators);
                        }
                        if(result.status == 'valid'){
                            // todo
                        }

                        // loading and disabled button
                        thisElm.innerHTML = `${buttonText}`
                        for (const elm of parentElm.querySelectorAll('button')) {
                            elm.disabled = false;
                        }
                    });
            });
        });
        // dom event





        // other function
        function showModalForm(thisElm, action) {
            const parentElm = document.querySelector('#modalForm');
            const modalTitle = parentElm.querySelector('.modal-title');
            const modalBody = parentElm.querySelector('.modal-body');
            const modalFooter = parentElm.querySelector('.modal-footer');

            modalTitle.innerHTML = `Loading data...`;
            modalBody.classList.add('d-none');
            modalFooter.classList.add('d-none');
            $(parentElm).modal('show');

            if (action == 'store') {
                parentElm.querySelector(`[name="_remote"]`).value = `{{ route('return_item.store') }}`;
                parentElm.querySelector(`[name="_method"]`).value = `POST`;

                modalTitle.innerHTML = `Tambah Retur Barang`;
                modalBody.classList.remove('d-none');
                modalFooter.classList.remove('d-none');
            }
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

        function simulateEvent(elm, eventName) {
            let evt = new MouseEvent(eventName, {
                bubbles: true,
                cancelable: true,
                view: window
            });
            let canceled = !elm.dispatchEvent(evt);
        };

        function validateToServer (url, jsonStr) {
            return new Promise((resolve, reject) => {
                fetch(url, {
                    method: `POST`,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: jsonStr,
                })
                .then(response => response.json())
                .then((result) => {
                    resolve(result);
                });
            });  
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
                for (const elm of parentFormElm.querySelectorAll('textarea:not(.noReset)')) {
                    elm.value = '';
                }

                $(parentFormElm).find('select:not(.noReset).select2-advance').each(function(i, elm){
                    $(elm).val('').trigger('change');
                });
                $(parentFormElm).find('select:not(.noReset).select2').each(function(i, elm){
                    $(elm).val('').trigger('change');
                });
            });
        });
        // fixed event
    </script>
@stop
