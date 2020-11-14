@extends('adminlte::page')

@section('title', 'Return Item')

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
                                <th>Kode</th>
                                <th>Tgl</th>
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
                                            <div class="col-lg-11">
                                                <div class="form-group">
                                                    <label>Barang</label>
                                                    <select name="items" class="form-control select2-advance" data-placeholder="Pilih barang" data-url="{{ route('return_item.get_items') }}"></select>
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
                                        <h3 class="card-title">List Barang yang Diretur</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="listItem table table-hovered table-bordered" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Barcode</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty Retur</th>
                                                        <th>Harga Beli</th>
                                                        <th>Harga Total</th>
                                                        <th class="text-right">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4" class="text-right">Total</th>
                                                        <th class="p-1">
                                                            <div class="form-group mb-0">
                                                                <input type="number" name="summary" value="0" class="form-control" placeholder="0" readonly>
                                                                <div class="invalid-feedback"></div>
                                                            </div>
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
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

    <!-- modal detail -->
    <form>
        <div class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Title</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
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
                    {data: 'id', searchable: false, visible: false, printable: false},
                    {data: 'kode'},
                    {data: 'updated_at_idn'},
                    {data: 'suplier_name'},
                    {data: 'summary_iso'},
                    {data: 'user_name'},
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

                if(itemsElm.val() == null || itemsElm.val() == '') {
                    let validatorObj = {
                        'items': ["Barang wajib diisi."]
                    };
                    drawError(parentElm, validatorObj);
                }
                else {
                    let itemObj = JSON.parse(itemsElm.val());
                    renderTableListItem(itemObj);

                    itemsElm.val('').trigger('change');
                }
            });

            addListenToEvent('#modalForm table.listItem tbody .btnDeleteItem', 'click', (e) => {
                const thisElm = e.target.closest('button');
                renderEraseTableListItem(thisElm);
            });

            $('#modalForm').on('change', 'select[name="items"]', function(e) {
                const parentElm = document.querySelector('#modalForm');
                const thisElm = $(this);

                if (thisElm.val() != null && thisElm.val() != '') {
                    let itemObj = JSON.parse(thisElm.val());
                    const itemInTableArrElm = parentElm.querySelectorAll('input[name="items[]"]');

                    for (const itemInTableElm of itemInTableArrElm) {
                        itemInTableObj = JSON.parse(itemInTableElm.value);

                        if (itemObj.id == itemInTableObj.id) {
                            thisElm.val('').trigger('change');

                            let validatorObj = {
                                'items': [`Barang ${itemObj.name} sudah ada pada tabel.`]
                            };
                            drawError(parentElm, validatorObj);

                            return false;
                        }
                    }
                }
            });

            addListenToEvent('#modalForm button[type="reset"].myReset', 'click', (e) => {
                e.preventDefault();
                const btnDeleteItemArrElm = document.querySelectorAll('#modalForm table.listItem tbody .btnDeleteItem');
                
                for (const btnDeleteItemElm of btnDeleteItemArrElm) {
                    simulateEvent(btnDeleteItemElm, 'click');
                }
            });
            
            addListenToEvent('#modalForm input[name="qty[]"]', 'change', (e) => {
                e.preventDefault();
                renderCalculateTableListItem();
            });

            addListenToEvent('#modalForm input[name="buy_price[]"]', 'change', (e) => {
                e.preventDefault();
                renderCalculateTableListItem();
            });

            addListenToEvent('#modalForm button[type="submit"]', 'click', (e) => {
                e.preventDefault();
                const thisElm = e.target;

                swalConfirm('melakukan ini')
                    .then(() => {
                        submitModalForm(thisElm);
                    });
            });

            addListenToEvent('.mainContent .btnOpen', 'click', (e) => {
                const thisElm = e.target.closest('button');
                showModalDetail(thisElm, 'open');
            });
        });
        // dom event





        // other function
        function showModalForm(thisElm, action) {
            const parentElm = document.querySelector('#modalForm');
            const modalTitle = parentElm.querySelector('.modal-title');
            const modalBody = parentElm.querySelector('.modal-body');
            const modalFooter = parentElm.querySelector('.modal-footer');
            const resetBtn = parentElm.querySelector('button[type="reset"]');

            modalTitle.innerHTML = `Loading data...`;
            modalBody.classList.add('d-none');
            modalFooter.classList.add('d-none');
            simulateEvent(resetBtn, 'click');
            renderNoDataOnTableListItem();
            $(parentElm).modal('show');

            if (action == 'store') {
                parentElm.querySelector(`[name="_remote"]`).value = `{{ route('return_item.store') }}`;
                parentElm.querySelector(`[name="_method"]`).value = `POST`;

                modalTitle.innerHTML = `Tambah Retur Barang`;
                modalBody.classList.remove('d-none');
                modalFooter.classList.remove('d-none');
            }
        }

        function renderTableListItem(itemObj) {
            const parentElm = document.querySelector('#modalForm table.listItem tbody');

            let subHtml = `
                <td>${itemObj.barcode}</td>
                <td>${itemObj.name}</td>
                <td class="p-1">
                    <div class="form-group mb-0">
                        <input type="number" name="qty[]" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" placeholder="Tulis qty retur">
                        <div class="invalid-feedback"></div>
                    </div>
                </td>
                <td class="p-1">
                    <div class="form-group mb-0">
                        <input type="number" name="buy_price[]" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" value="${itemObj.buy_price}" placeholder="Tulis harga beli">
                        <div class="invalid-feedback"></div>
                    </div>
                </td>
                <td class="p-1">
                    <div class="form-group mb-0">
                        <input type="number" name="buy_price_tot[]" value="0" class="form-control" placeholder="0" readonly>
                        <div class="invalid-feedback"></div>
                    </div>
                </td>
                <td class="text-right">
                    <input type="hidden" name="items[]" value='${JSON.stringify(itemObj)}'>
                    <button type="button" class="btn btn-danger btn-xs btnDeleteItem d-block float-right" title="Hapus"><i class="fas fa-trash fa-fw"></i></button>
                </td>
            `;

            const itemInTableElms = parentElm.querySelectorAll('input[name="items[]"]');
            if (itemInTableElms.length <= 0) {
                parentElm.innerHTML = `<tr> ${subHtml} </tr> `;
            }
            else {
                let html = document.createElement('tr');
                html.innerHTML = subHtml;
                parentElm.insertBefore(html, parentElm.firstChild);
            }


        }

        function renderNoDataOnTableListItem(params) {
            const parentElm = document.querySelector('#modalForm table.listItem tbody');

            let html = `
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data dalam tabel</td>
                </tr>
            `;

            parentElm.innerHTML = html;
        }

        function renderEraseTableListItem(btnElm) {
            btnElm.closest('tr').remove();

            const parentElm = document.querySelector('#modalForm table.listItem tbody');
            const itemInTableElms = parentElm.querySelectorAll('input[name="items[]"]');

            if (itemInTableElms.length <= 0) {
                renderNoDataOnTableListItem();
            }

            renderCalculateTableListItem();
        }

        function renderCalculateTableListItem(params) {
            const parentElm = document.querySelector('#modalForm table.listItem');
            const summaryElm = parentElm.querySelector('input[name="summary"]');
            const qtyElms = parentElm.querySelectorAll('input[name="qty[]"');
            const buyPriceElms = parentElm.querySelectorAll('input[name="buy_price[]"');
            const buyPriceTotalElms = parentElm.querySelectorAll('input[name="buy_price_tot[]"');

            let buyPriceTotal = parseFloat(0);

            for (const i in qtyElms) {
                if (qtyElms.hasOwnProperty(i)) {
                    const qtyElm = qtyElms[i];
                    const buyPriceElm = buyPriceElms[i];
                    const buyPriceTotalElm = buyPriceTotalElms[i];

                    let qty = (qtyElm.value == '') ? parseFloat(0) : parseFloat(qtyElm.value);
                    let buyPrice = (buyPriceElm.value == '') ? parseFloat(0) : parseFloat(buyPriceElm.value);
                    
                    let _buyPriceTotal = qty * buyPrice;                    
                    buyPriceTotal += _buyPriceTotal;

                    buyPriceTotalElm.value = _buyPriceTotal;
                }
            }

            summaryElm.value = buyPriceTotal;
            simulateEvent(summaryElm, 'change');
        }

        function submitModalForm(thisElm) {
            const parentElm = document.querySelector('#modalForm').closest('form');
            
            // prepare data
            const remoteElm = parentElm.querySelector('[name="_remote"]');
            const methodElm = parentElm.querySelector('[name="_method"]');
            const suppliersElm = $(parentElm).find('select[name="suppliers"]');
            const itemsElms = parentElm.querySelectorAll('input[name="items[]"');
            const qtyElms = parentElm.querySelectorAll('input[name="qty[]"');
            const buyPriceElms = parentElm.querySelectorAll('input[name="buy_price[]"');

            let supplierObj = JSON.parse(suppliersElm.val());
            let supplierId = (supplierObj) ? supplierObj.id : '';

            let data = {
                'suplier_id': supplierId,
                'summary': parentElm.querySelector('input[name="summary"]').value,
                'note': parentElm.querySelector('textarea[name="note"]').value,
                'items': []
            }

            for (const i in itemsElms) {
                if (itemsElms.hasOwnProperty(i)) {
                    const itemsElm = itemsElms[i];
                    const qtyElm = qtyElms[i];
                    const buyPriceElm = buyPriceElms[i];
                    let itemObj = JSON.parse(itemsElm.value);
                    
                    data.items[i] = itemObj;
                    data.items[i].qty = qtyElm.value;
                    data.items[i].buy_price = buyPriceElm.value;
                }
            }
            // end prepare data
            
            // loading and disabled button
            const buttonText = thisElm.innerHTML;
            thisElm.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i> ${buttonText}...`
            for (const elm of parentElm.querySelectorAll('button')) {
                elm.disabled = true;
            }
            
            fetch(remoteElm.value, {
                    method: methodElm.value,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if(result.status == 'invalid'){
                        drawErrorOnModalForm(parentElm, result.validators);
                    }
                    if(result.status == 'valid'){
                        swalAlert(result.pesan, 'success');
                        tbIndex.ajax.reload();
                        $(parentElm).find('.modal').modal('hide');
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

        function drawErrorOnModalForm(parentElm, validators) {
            for (let keyName in validators) {
                if (validators.hasOwnProperty(keyName)) {
                    const value = validators[keyName][0];

                    if (keyName.includes('.')) {
                        const keyNameSplited = keyName.split('.');
                        const index = keyNameSplited[1];
                        const elmName = keyNameSplited[2];

                        keyName = `${elmName}[]`;
                         
                        parentElm.querySelectorAll(`[name="${keyName}"]`)[index].classList.add('is-invalid');
                        parentElm.querySelectorAll(`[name="${keyName}"]`)[index].closest('.form-group').querySelector('.invalid-feedback').innerHTML = `${value}`;
                    }
                    else {
                        let isDraw = true;
                        
                        if (keyName == 'suplier_id') {
                            keyName = 'suppliers';
                        }
                        if (keyName == 'items') {
                            isDraw = false;
                            swalAlert('List barang yang diretur harus diisi', 'warning');
                        }

                        if (isDraw === true) {
                            parentElm.querySelector(`[name="${keyName}"]`).classList.add('is-invalid');
                            parentElm.querySelector(`[name="${keyName}"]`).closest('.form-group').querySelector('.invalid-feedback').innerHTML = `${value}`;
                        }
                    }

                }
            }
        }

        function showModalDetail(thisElm, action) {
            const parentElm = document.querySelector('#modalDetail');
            const modalTitle = parentElm.querySelector('.modal-title');
            const modalBody = parentElm.querySelector('.modal-body');
            const modalFooter = parentElm.querySelector('.modal-footer');
            const resetBtn = parentElm.querySelector('button[type="reset"]');

            modalTitle.innerHTML = `Loading data...`;
            modalBody.classList.add('d-none');
            modalFooter.classList.add('d-none');
            $(parentElm).modal('show');

            if (action == 'open') {
                fetch(`${thisElm.dataset.remote_show}`)
                    .then(response => response.json())
                    .then(result => {
                        renderModalDetail(result);
                        modalTitle.innerHTML = `Detail Retur Barang`;
                        modalBody.classList.remove('d-none');
                        modalFooter.classList.remove('d-none');
                    });
            }
        }

        function renderModalDetail(data) {
            const parentElm = document.querySelector('#modalDetail');
            const returnItem = data.return_item;

            let subHtml = ``;
            for (let i in returnItem.details) {
                if (returnItem.details.hasOwnProperty(i)) {
                    const item = returnItem.details[i];

                    let buyPriceTotal = parseFloat(item.qty) * parseFloat(item.buy_price);

                    subHtml += `
                        <tr>
                            <td>${++i}</td>
                            <td>${item.item.barcode}</td>
                            <td>${item.item.name}</td>
                            <td class="text-right">${item.qty}</td>
                            <td class="text-right">${getIsoNumberWithSeparator(item.buy_price)}</td>
                            <td class="text-right">${getIsoNumberWithSeparator(buyPriceTotal)}</td>
                        </tr>
                    `;
                    
                }
            }

            let html = `
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card bg-info">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Umum</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4">Kode</dt>
                                    <dd class="col-sm-8">${returnItem.kode}</dd>
                                    <dt class="col-sm-4">Nama Supplier</dt>
                                    <dd class="col-sm-8">${returnItem.suplier.name}</dd>
                                    <dt class="col-sm-4">No Telp</dt>
                                    <dd class="col-sm-8">${returnItem.suplier.phone}</dd>
                                    <dt class="col-sm-4">Alamat</dt>
                                    <dd class="col-sm-8">${returnItem.suplier.address}</dd>
                                    <dt class="col-sm-4">Keterangan</dt>
                                    <dd class="col-sm-8">${returnItem.note}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card bg-info">
                            <div class="card-header">
                                <h3 class="card-title">Metadata</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-sm-4">Tgl Input</dt>
                                    <dd class="col-sm-8">${getIndoDate(returnItem.created_at)}</dd>
                                    <dt class="col-sm-4">Tgl Update</dt>
                                    <dd class="col-sm-8">${getIndoDate(returnItem.updated_at)}</dd>
                                    <dt class="col-sm-4">Pembuat</dt>
                                    <dd class="col-sm-8">${returnItem.user.name}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card bg-default mb-0">
                            <div class="card-header">
                                <h3 class="card-title">List Barang yang Diretur</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hovered table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Barcode</th>
                                                <th>Nama Barang</th>
                                                <th class="text-right">Qty Retur</th>
                                                <th class="text-right">Harga Beli</th>
                                                <th class="text-right">Harga Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>${subHtml}</tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Total</th>
                                                <th class="text-right">${getIsoNumberWithSeparator(returnItem.summary)}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            parentElm.querySelector('.modal-body').innerHTML = html;

            let htmlFooter = `
                <a href="${data.url_pdf}" target="_blank" class="btn btn-warning float-right">Print PDF</a>
            `;

            parentElm.querySelector('.modal-footer').innerHTML = htmlFooter;
        }
        
        function renderModalDetailFooter(data) {
            const parentElm = document.querySelector('#modalDetail');
            
            
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

        function swalConfirm(text){
            return new Promise((resolve, reject) => {
                Swal.fire({
                    customClass: {
                        confirmButton: 'btn btn-info',
                        cancelButton: 'btn btn-default'
                    },
                    buttonsStyling: false,
                    focusCancel: true,
                    position: 'center',
                    icon: 'question',
                    text: `Apakah anda yakin untuk ${text}?`,
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Batal'
                })
                .then((result) => {
                    if (result.value) {
                        resolve();
                    }
                });
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

        function getIsoNumberWithSeparator(isoNumber){
            return (isoNumber.toFixed(2)).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
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
