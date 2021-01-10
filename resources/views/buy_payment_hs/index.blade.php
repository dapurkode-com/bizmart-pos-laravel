@extends('adminlte::page')

@section('title', 'Pembayaran Hutang')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Daftar Hutang</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Hutang</li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- main content -->
    <div class="row mainContent">
        <div class="col-sm-12">
            <div class="card bg-default">
                <div class="card-body">
                    <div class="buyTableFilter">
                        <div class="form-group mb-0">
                            <input type="date" name="date_start" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            <input type="date" name="date_end" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="button" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                    </div>
                </div>
            </div>
            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Hutang</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default buyTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="buyTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Hutang</th>
                                <th>Tanggal</th>
                                <th>Supplier</th>
                                <th class="text-right">Total</th>
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

    <!-- modal detail -->
    <form>
        <div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Hutang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer justify-content-between"></div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .buyTableFilter {
            display: grid;
            grid-template-columns: 0fr 0fr 0fr 1fr;
            gap: 1rem;
            align-items: center;
        }
        .buyTableFilter .filterButton {
            width: 80px;
            justify-self: end;
        }
        @media only screen and (max-width: 617px) {
            .buyTableFilter {
                grid-template-columns: 1fr;
                justify-items: center;
                gap: 0;
            }
            .buyTableFilter .filterButton {
                margin-top: 1rem;
                width: 185.19px;
                justify-self: center;
            }
        }
        .sisaHutangBtn {
            border-radius: 0 4px 4px 0 !important;
        }
    </style>
@stop

@section('js')
    <script type="module">
        import { select2DatatableInit, domReady, addListenToEvent, getIndoDate, getIsoNumberWithSeparator, swalConfirm, drawError, eraseErrorInit, swalAlert } from '{{ asset("plugins/custom/global.app.js") }}'

        const mainContentElm = document.querySelector('.mainContent');
        const buyTable = $('#buyTable').DataTable({
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
                url: "{{ route('buy_payment_hs.datatables') }}",
                data: function (d) {
                    const filterElm = mainContentElm.querySelector('.buyTableFilter');
                    d.filter = {
                        'date_start': filterElm.querySelector('[name="date_start"]').value,
                        'date_end': filterElm.querySelector('[name="date_end"]').value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: '_id'},
                {data: '_updated_at'},
                {data: '_suplier_name'},
                {data: 'summary', className: 'text-right'},
                {data: '_user_name'},
                {data: '_status_raw', name:"_status"},
                {data: '_action_raw', orderable: false, searchable: false, className: 'text-right text-nowrap'},
            ],
            order: [[1, 'desc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
        const detailModal = document.querySelector('#detailModal');
        const buyTableFilterElm = mainContentElm.querySelector('.buyTableFilter');
        let REMOTE_SET = null;
        let SISA_HUTANG = '';

        domReady(() => {
            eraseErrorInit();

            addListenToEvent('.mainContent .filterButton', 'click', (event) => {
                buyTable.ajax.reload();
            });

            addListenToEvent('.mainContent .buyTableRefreshBtn', 'click', (event) => {
                buyTableFilterElm.querySelectorAll('input').forEach((elm) => {
                    elm.value = '';
                });
                buyTable.ajax.reload();
            });

            addListenToEvent('#buyTable .openBtn', 'click', (event) => {
                const thisBtn = event.target.closest('button');

                detailModal.querySelector('.modal-title').innerHTML = `Loading data...`;
                detailModal.querySelector('.modal-body').classList.add('d-none');
                detailModal.querySelector('.modal-footer').classList.add('d-none');
                $(detailModal).modal('show');

                fetch(`${thisBtn.dataset.remote_get}`)
                    .then(response => response.json())
                    .then(result => {
                        detailModal.querySelector('.modal-body').innerHTML = drawToDetailModalBody(result.buy);
                        detailModal.querySelector('.modal-footer').innerHTML = '';

                        detailModal.querySelector('.modal-title').innerHTML = `Detail Hutang`;
                        detailModal.querySelector('.modal-body').classList.remove('d-none');
                        detailModal.querySelector('.modal-footer').classList.remove('d-none');
                    });
            });

            addListenToEvent('#buyTable .addBtn', 'click', (event) => {
                const thisBtn = event.target.closest('button');
                REMOTE_SET = thisBtn.dataset.remote_set;
                SISA_HUTANG = '';

                detailModal.querySelector('.modal-title').innerHTML = `Loading data...`;
                detailModal.querySelector('.modal-body').classList.add('d-none');
                detailModal.querySelector('.modal-footer').classList.add('d-none');
                $(detailModal).modal('show');

                fetch(`${thisBtn.dataset.remote_get}`)
                    .then(response => response.json())
                    .then(result => {
                        detailModal.querySelector('.modal-body').innerHTML = drawToDetailModalBody(result.buy);
                        detailModal.querySelector('.modal-body').append(drawFormNodeToDetailModalBody());
                        detailModal.querySelector('.modal-footer').innerHTML = drawToDetailModalFooter();

                        detailModal.querySelector('.modal-title').innerHTML = `Pembayaran Hutang`;
                        detailModal.querySelector('.modal-body').classList.remove('d-none');
                        detailModal.querySelector('.modal-footer').classList.remove('d-none');
                    });
            });

            addListenToEvent('#detailModal .submitButton', 'click', (event) => {
                event.preventDefault();
                const thisBtn = event.target.closest('button');

                swalConfirm('melakukan ini')
                    .then(() => {
                        // prepare data
                        let data = {
                            amount : detailModal.querySelector('[name="amount"]').value,
                            note : detailModal.querySelector('[name="note"]').value,
                            _method : 'PUT',
                        }
                        // end prepare data

                        // loading and disabled button
                        const thisBtnText = thisBtn.innerHTML;
                        thisBtn.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i> ${thisBtnText}...`
                        for (const elm of detailModal.querySelectorAll('button')) {
                            elm.disabled = true;
                        }

                        fetch(`${REMOTE_SET}`, {
                                method: "PUT",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => response.json())
                            .then(result => {
                                if(result.status == 'invalid'){
                                    drawError(detailModal, result.validators);
                                }
                                if(result.status == 'valid'){
                                    swalAlert(result.pesan, 'success');
                                    $(detailModal).modal('hide');
                                }
                                if(result.status == 'error'){
                                    swalAlert(result.pesan, 'warning');
                                }
                            })
                            .finally(() => {
                                // loading and disabled button
                                thisBtn.innerHTML = `${thisBtnText}`
                                for (const elm of detailModal.querySelectorAll('button')) {
                                    elm.disabled = false;
                                }
                                buyTable.ajax.reload();
                            });
                    });
            });

            addListenToEvent('#detailModal .sisaHutangBtn', 'click', (event) => {
                detailModal.querySelector('[name="amount"]').value = SISA_HUTANG;
            });
        });



        function drawToDetailModalBody(obj) {
            let subHtml = ``;
            let subTotal = Number(0);
            obj.buy_details.forEach((buy_detail, index) => {
                let buyPriceTotal = Number(buy_detail.qty) * Number(buy_detail.buy_price);
                subTotal += buyPriceTotal;
                subHtml += `
                    <tr>
                        <td>${++index}</td>
                        <td>${buy_detail.item.barcode}</td>
                        <td>${buy_detail.item.name}</td>
                        <td class="text-right">${buy_detail.qty}</td>
                        <td class="text-right">${getIsoNumberWithSeparator(buy_detail.buy_price)}</td>
                        <td class="text-right">${getIsoNumberWithSeparator(buyPriceTotal)}</td>
                    </tr>
                `;
            });

            let subHistoryHtml = ``;
            let sisa = Number(obj.summary);
            obj.buy_payment_hs.forEach((buy_payment_h, index) => {
                sisa -= Number(buy_payment_h.amount);
                subHistoryHtml += `
                    <tr>
                        <td>${++index}</td>
                        <td>${getIndoDate(buy_payment_h.updated_at)}</td>
                        <td>${(buy_payment_h.note) ? buy_payment_h.note : '-'}</td>
                        <td>${buy_payment_h.user?.name || '-'}</td>
                        <td class="text-right">${getIsoNumberWithSeparator(buy_payment_h.amount)}</td>
                    </tr>
                `;
            });

            SISA_HUTANG = sisa;

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
                                    <dd class="col-sm-8">${obj.kode}</dd>
                                    <dt class="col-sm-4">Nama Supplier</dt>
                                    <dd class="col-sm-8">${obj.supplier.name}</dd>
                                    <dt class="col-sm-4">Keterangan</dt>
                                    <dd class="col-sm-8">${(obj.note) ? obj.note : '-'}</dd>
                                    <dt class="col-sm-4">Status</dt>
                                    <dd class="col-sm-8">${obj.status_text}</dd>
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
                                    <dd class="col-sm-8">${getIndoDate(obj.created_at)}</dd>
                                    <dt class="col-sm-4">Tgl Update</dt>
                                    <dd class="col-sm-8">${getIndoDate(obj.updated_at)}</dd>
                                    <dt class="col-sm-4">Pembuat</dt>
                                    <dd class="col-sm-8">${obj.user.name}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card bg-default">
                            <div class="card-header">
                                <h3 class="card-title">List Barang yang Dijual</h3>
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
                                                <th>Nama</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-right">Harga Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>${subHtml}</tbody>
                                        <tfoot>
                                            <tr class="d-none">
                                                <th colspan="5" class="text-right">Subtotal</th>
                                                <th class="text-right">${getIsoNumberWithSeparator(subTotal)}</th>
                                            </tr>
                                            <tr class="d-none">
                                                <th colspan="5" class="text-right">PPN</th>
                                                <th class="text-right">${getIsoNumberWithSeparator(obj.tax)}</th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" class="text-right">Total</th>
                                                <th class="text-right">${getIsoNumberWithSeparator(obj.summary)}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card bg-default mb-0">
                            <div class="card-header">
                                <h3 class="card-title">Histori Pembayaran</h3>
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
                                                <th>Tgl</th>
                                                <th>Keterangan</th>
                                                <th>Oleh</th>
                                                <th class="text-right">Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>${subHistoryHtml}</tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">Sisa</th>
                                                <th class="text-right">${getIsoNumberWithSeparator(sisa)}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            return html;
        }

        function drawFormNodeToDetailModalBody() {
            const html = document.createElement('div');
            html.classList.add('row');
            html.innerHTML = `
                <div class="col-sm-12">
                    <div class="card bg-default" style="margin-top: 1rem">
                        <div class="card-header">
                            <h3 class="card-title">Form Pembayaran Hutang</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" name="amount" min="0" oninput="this.value = Math.abs(this.value)" class="form-control" placeholder="Tulis nominal tagihan"/>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary sisaHutangBtn" type="button">Sisa Hutang</button>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
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
            `;

            return html;
        }

        function drawToDetailModalFooter() {
            return `
                <button type="reset" class="myReset btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary submitButton">Simpan</button>
            `;
        }
    </script>
@stop
