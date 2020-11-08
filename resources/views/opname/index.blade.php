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
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Opname</h5>
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
                                <th>Oleh</th>
                                <th>Total</th>
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
    <div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false" tabindex="-2" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <!-- <form id="insertItemForm"> -->
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
                        <div class="row insertBarangElm">
                            <div class="col-sm-12">
                                <form id="insertItemForm">
                                    <input type="hidden" name="_remote" class="noReset">
                                    <input type="hidden" name="_method" class="noReset">
                                    <input type="hidden" name="opname_id" class="noReset">
                                    <input type="hidden" name="ref_uniq_id" class="noReset">

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
                                                        <select name="items" id="selectItems" class="form-control select2" data-placeholder="Pilih barang" data-url="{{ route('opname.get_items') }}"></select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Qty Sekarang</label>
                                                        <input type="number" name="new_stock" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" placeholder="Tulis qty barang saat ini">
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
                                            <button type="reset" class="myReset btn btn-default btn-sm">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- opname details -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card bg-default mb-0">
                                    <div class="card-header">
                                        <h3 class="card-title">Barang yang sudah di-Opname</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="tbOpnameDetail" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tanggal</th>
                                                    <th>Barcode</th>
                                                    <th>Nama Barang</th>
                                                    <th>Stock Sistem</th>
                                                    <th>Stock Sekarang</th>
                                                    <th>Harga Beli</th>
                                                    <th>Harga Jual</th>
                                                    <th>Deskripsi</th>
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
                <!-- </form> -->
            </div>
        </div>
    </div>

    <!-- modal reason for opname -->
    <form>
        <div class="modal fade" id="modalReasonForOpname" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Form Alasan Perbedaan Stock Barang</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                
                                <input type="hidden" name="_remote" class="noReset">
                                <input type="hidden" name="_method" class="noReset">
                                <input type="hidden" name="opname_id" class="noReset">
                                <input type="hidden" name="ref_uniq_id" class="noReset">
                                <input type="hidden" name="item_id" class="noReset">
                                <input type="hidden" name="buy_price" class="noReset">
                                <input type="hidden" name="sell_price" class="noReset">

                                <div class="form-group">
                                    <label>Barcode Barang</label>
                                    <input type="text" name="barcode" class="form-control noReset" placeholder="" readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" name="name" class="form-control noReset" placeholder="" readonly>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stock Sistem</label>
                                            <input type="text" name="old_stock" class="form-control noReset" placeholder="" readonly>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stock Sekarang</label>
                                            <input type="text" name="new_stock" class="form-control noReset" placeholder="" readonly>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea type="text" name="description" rows="5" class="form-control" placeholder="Deskripsikan alasannya disini"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="reset" class="myReset btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
        let tbOpnameDetail = null;
        let selectItems = null;

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
                    {data: 'id', searchable: false, visible: false, printable: false},
                    {data: 'created_at_idn'},
                    {data: 'uniq_id'},
                    {data: 'created_by'},
                    {data: 'summary_iso'},
                    {data: 'status_color', name: 'status_text'},
                    {data: 'action', orderable: false, searchable: false, className: 'text-right text-nowrap'},
                ],
                order: [[1, 'desc']],
                initComplete: () => {
                    initSelect2Datatables();
                },
            });

            tbOpnameDetail = $('#tbOpnameDetail').DataTable({
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
                ajax: {
                    url: "{{ route('opname.datatables_opname_detail') }}",
                    data: function (extra_data) {
                        extra_data.opname_id = document.querySelector('#modalForm input[name="opname_id"]').value;
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'updated_at_idn'},
                    {data: 'barcode'},
                    {data: 'name'},
                    {data: 'old_stock'},
                    {data: 'new_stock'},
                    {data: 'buy_price'},
                    {data: 'sell_price'},
                    {data: 'description'},
                    {data: 'action', orderable: false, searchable: false, className: 'text-right text-nowrap'},
                ],
                order: [[1, 'desc']],
                initComplete: () => {
                    initSelect2Datatables();
                },
            });

            selectItems = $('#selectItems').select2({
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
                            page: params.page || 1,
                            opname_id: document.querySelector('#modalForm input[name="opname_id"]').value || 0,
                        }
                    },
                    cache: true
                }
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
            
            addListenToEvent('.mainContent .btnEdit', 'click', (e) => {
                const parentElm = document.querySelector('#modalForm');
                const thisElm = e.target.closest('button');

                showModalForm(parentElm, thisElm, 'update');
            });

            addListenToEvent('.mainContent .btnOpen', 'click', (e) => {
                const parentElm = document.querySelector('#modalForm');
                const thisElm = e.target.closest('button');

                showModalForm(parentElm, thisElm, 'show');
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

            addListenToEvent('#modalForm #tbOpnameDetail .btnEdit', 'click', (e) => {
                e.preventDefault();
                const parentElm = document.querySelector('#tbOpnameDetail');
                const thisElm = e.target.closest('button');

                // loading and disabled button
                const buttonText = thisElm.innerHTML;
                thisElm.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i>`;
                for (const elm of parentElm.querySelectorAll('button')) {
                    elm.disabled = true;
                }

                // get data from api
                fetch(`${thisElm.dataset.remote_show_opname_detail}`, {
                    method: `GET`,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                })
                .then(response => response.json())
                .then((result) => {
                    if(result.status == 'error'){
                        swalAlert(result.pesan, 'warning');
                    }
                    if(result.status == 'valid'){
                        swalAlert(result.pesan, 'success');
                        showModalReasonForOpname(result);
                    }
                })
                .finally(() => {
                    // loading and disabled button
                    thisElm.innerHTML = `${buttonText}`
                    for (const elm of parentElm.querySelectorAll('button')) {
                        elm.disabled = false;
                    }
                });
            });

            addListenToEvent('#modalReasonForOpname button[type="submit"]', 'click', (e) => {
                e.preventDefault();
                const parentElm = e.target.closest('.modal');
                const thisElm = e.target;
                submitReasonStockLog(parentElm, thisElm);
            });
        });
        // dom event





        // other function
        function showModalForm(parentElm, thisElm, action) {
            const modalTitle = parentElm.querySelector('.modal-title');
            const modalBody = parentElm.querySelector('.modal-body');
            const modalFooter = parentElm.querySelector('.modal-footer');
            const insertBarangElm = parentElm.querySelector('.insertBarangElm');
            let modalTitleText = null;

            modalTitle.innerHTML = `Loading data...`;
            modalBody.classList.add('d-none');
            modalFooter.classList.add('d-none');
            $(parentElm).modal('show');

            if (action == 'show') {
                modalTitleText = `Detail Opname`;
                insertBarangElm.classList.add('d-none');
            }
            if (action == 'update') {
                modalTitleText = `Proses Opname`;
                insertBarangElm.classList.remove('d-none');
            }

            fetch(`${thisElm.dataset.remote_show}`)
            .then(response => response.json())
            .then(result => {
                renderOpnameInfo(result);

                if (action == 'show') {
                    renderItemInfo(result.count_item_in_opname_detail, result.count_item_in_opname_detail);
                }
                if (action == 'update') {
                    renderItemInfo(result.count_item_in_opname_detail, result.count_item);
                }

                parentElm.querySelector('#insertItemForm input[name="_remote"]').value = `${thisElm.dataset.remote_store_opaname_detail}`;
                parentElm.querySelector('#insertItemForm input[name="_method"]').value = 'POST';
                parentElm.querySelector('#insertItemForm input[name="opname_id"]').value = result.opname.id;
                parentElm.querySelector('#insertItemForm input[name="ref_uniq_id"]').value = result.opname.uniq_id;

                modalTitle.innerHTML = modalTitleText;
                modalBody.classList.remove('d-none');
                modalFooter.classList.remove('d-none');

                tbOpnameDetail.ajax.reload();
            });
        }
        
        function submitItemToOpnameDetail(parentElm, thisElm) {
            let formData = new FormData(parentElm.querySelector('form#insertItemForm'));
            let jsonStr = JSON.stringify(fdToJsonObj(formData));
            const resetBtn = parentElm.querySelector('form#insertItemForm button[type="reset"]')
            
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
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: jsonStr,
            })
            .then(response => response.json())
            .then((result) => {
                if(result.status == 'invalid'){
                    drawError(parentElm, result.validators);
                }
                if(result.status == 'exist'){
                    swalAlert(result.pesan, 'warning');
                }
                if(result.status == 'error'){
                    swalAlert(result.pesan, 'warning');
                }
                if(result.status == 'valid'){
                    swalAlert(result.pesan, 'success');
                    simulateEvent(resetBtn, 'click');
                    renderOpnameInfo(result);
                    renderItemInfo(result.count_item_in_opname_detail, result.count_item);
                    tbIndex.ajax.reload();
                    tbOpnameDetail.ajax.reload();

                    if(result.is_new_stock_and_old_stock_same === false){
                        showModalReasonForOpname(result);
                    }
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

        function renderOpnameInfo(data){
            const parentElm = document.querySelector('#modalForm');
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

        function renderItemInfo(countItemOpnamed, countAllItem){
            const parentElm = document.querySelector('#modalForm');
            let html = `
                <div class="small-box bg-info mb-3 edit">
                    <div class="inner">
                        <h3>${countItemOpnamed} / ${countAllItem}</h3>
                        <p>Barang sudah di Opname</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cookie-bite"></i>
                    </div>
                </div>
            `;

            parentElm.querySelector('.itemInfoElm').innerHTML = html;
        }

        function showModalReasonForOpname(data){
            const parentElm = document.querySelector('#modalReasonForOpname');
            const refUniqIdElm = document.querySelector('#insertItemForm input[name="ref_uniq_id"]');
            const resetButton = parentElm.querySelector('button[type="reset"]');

            simulateEvent(resetButton, 'click');

            parentElm.querySelector('input[name="_remote"]').value = `{{ route('opname.store_stock_log') }}`;
            parentElm.querySelector('input[name="_method"]').value = `POST`;
            parentElm.querySelector('input[name="opname_id"]').value = data.opname_id;
            parentElm.querySelector('input[name="ref_uniq_id"]').value = refUniqIdElm.value;
            parentElm.querySelector('input[name="item_id"]').value = data.item.id;
            parentElm.querySelector('input[name="barcode"]').value = data.item.barcode;
            parentElm.querySelector('input[name="name"]').value = data.item.name;
            parentElm.querySelector('input[name="old_stock"]').value = data.item.old_stock;
            parentElm.querySelector('input[name="new_stock"]').value = data.item.new_stock;
            parentElm.querySelector('input[name="buy_price"]').value = data.item.buy_price;
            parentElm.querySelector('input[name="sell_price"]').value = data.item.sell_price;
            
            $(parentElm).modal('show');
        }

        function submitReasonStockLog(parentElm, thisElm) {
            let formData = new FormData(parentElm.closest('form'));
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
            .then((result) => {
                if(result.status == 'invalid'){
                    drawError(parentElm, result.validators);
                }
                if(result.status == 'error'){
                    swalAlert(result.pesan, 'warning');
                }
                if(result.status == 'valid'){
                    swalAlert(result.pesan, 'success');
                    renderOpnameInfo(result);
                    tbIndex.ajax.reload();
                    tbOpnameDetail.ajax.reload();

                    $(parentElm).modal('hide');
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
