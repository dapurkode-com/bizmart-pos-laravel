@extends('adminlte::page')

@section('title', 'Sell Report')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Laporan Penjualan</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Penjualan</li>
                <li class="breadcrumb-item active">Laporan</li>
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
                    <div class="sellTableFilter">
                        <div class="form-group mb-0">
                            <input type="date" name="date_start" value="{{ date('Y-m-d') }}" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            <input type="date" name="date_end" value="{{ date('Y-m-d') }}" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="button" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                    </div>
                </div>
            </div>

            <div class="row ">
                <div class="col-lg-4 col-sm-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="transactionCount"><i class="fas fa-spin fa-sync-alt"></i></h3>
                            <p>Jumlah Transaksi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list-alt"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-sm-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="incomeNowSum"><i class="fas fa-spin fa-sync-alt"></i></h3>

                            <p>Total Pemasukan Saat Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-sm-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="piutangSum"><i class="fas fa-spin fa-sync-alt"></i></h3>

                            <p>Total Piutang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="incomeSum"><i class="fas fa-spin fa-sync-alt"></i></h3>

                            <p>Total Pemasukan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> List Barang</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default sellTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="itemTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barang</th>
                                <th>Qty</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Laba Bersih</th>
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
                        <h4 class="modal-title">Detail Penjualan</h4>
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
        .sellTableFilter {
            display: grid;
            grid-template-columns: 0fr 0fr 0fr 1fr;
            gap: 1rem;
            align-items: center;
        }
        .sellTableFilter .filterButton {
            width: 80px;
            justify-self: end;
        }

        @media only screen and (max-width: 617px) {
            .sellTableFilter {
                grid-template-columns: 1fr;
                justify-items: center;
                gap: 0;
            }
            .sellTableFilter .filterButton {
                margin-top: 1rem;
                width: 185.19px;
                justify-self: center;
            }
        }
    </style>
@stop

@section('js')
    <script type="module">
        import { select2DatatableInit, domReady, addListenToEvent, getIndoDate, getIsoNumberWithSeparator } from '{{ asset("plugins/custom/global.app.js") }}'
        
        const mainContentElm = document.querySelector('.mainContent');
        const dateStartInput = document.querySelector('.sellTableFilter [name="date_start"]');
        const dateEndInput = document.querySelector('.sellTableFilter [name="date_end"]');
        const transCountElm = document.querySelector('#transactionCount');
        const incomeNowElm = document.querySelector('#incomeNowSum');
        const piutangSumElm = document.querySelector('#piutangSum');
        const incomeSumElm = document.querySelector('#incomeSum');

        const itemTable = $('#itemTable').DataTable({
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
                url: "{{ route('sell_report.datatables') }}",
                data: function (d) {
                    const filterElm = mainContentElm.querySelector('.sellTableFilter');
                    d.filter = {
                        'date_start': dateStartInput.value,
                        'date_end': dateEndInput.value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: '_id'},
                {data: '_updated_at'},
                {data: '_member_name'},
                {data: 'summary'},
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
        const sellTableFilterElm = mainContentElm.querySelector('.sellTableFilter');



        domReady(() => {
            drawTransaction()
            drawIncomeNow()
            drawPiutang()
            // drawIncome()

            addListenToEvent('.mainContent .filterButton', 'click', (event) => {
                sellTable.ajax.reload();
            });

            addListenToEvent('.mainContent .sellTableRefreshBtn', 'click', (event) => {
                sellTableFilterElm.querySelectorAll('input').forEach((elm) => {
                    elm.value = '';
                });
                sellTable.ajax.reload();
            });

            addListenToEvent('#sellTable .openBtn', 'click', (event) => {
                const thisBtn = event.target.closest('button');

                detailModal.querySelector('.modal-title').innerHTML = `Loading data...`;
                detailModal.querySelector('.modal-body').classList.add('d-none');
                detailModal.querySelector('.modal-footer').classList.add('d-none');
                $(detailModal).modal('show');

                fetch(`${thisBtn.dataset.remote_get}`)
                    .then(response => response.json())
                    .then(result => {
                        detailModal.querySelector('.modal-body').innerHTML = drawToDetailModalBody(result.sell);

                        detailModal.querySelector('.modal-title').innerHTML = `Detail Penjualan`;
                        detailModal.querySelector('.modal-body').classList.remove('d-none');
                        detailModal.querySelector('.modal-footer').classList.remove('d-none');
                    });
            });
        });

        


        function drawTransaction() {
            transCountElm.innerHTML = `<i class="fas fa-spin fa-sync-alt"></i>`;
            const url = `{{ route('sell_report.get_total_transaction') }}?` + new URLSearchParams({
                date_start: dateStartInput.value,
                date_end: dateEndInput.value,
            });
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    transCountElm.innerHTML = result.total_transaction;
                });
        }

        function drawIncomeNow() {
            incomeNowElm.innerHTML = `<i class="fas fa-spin fa-sync-alt"></i>`;
            const url = `{{ route('sell_report.get_total_income_now') }}?` + new URLSearchParams({
                date_start: dateStartInput.value,
                date_end: dateEndInput.value,
            });
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    incomeNowElm.innerHTML = getIsoNumberWithSeparator(result.total_income_now);
                });
        }

        function drawPiutang() {
            piutangSumElm.innerHTML = `<i class="fas fa-spin fa-sync-alt"></i>`;
            const url = `{{ route('sell_report.get_total_piutang') }}?` + new URLSearchParams({
                date_start: dateStartInput.value,
                date_end: dateEndInput.value,
            });
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    piutangSumElm.innerHTML = getIsoNumberWithSeparator(result.total_piutang);
                });
        }

        // function drawIncome() {
        //     incomeSumElm.innerHTML = `<i class="fas fa-spin fa-sync-alt"></i>`;
        //     const url = `{{ route('sell_report.get_total_income') }}?` + new URLSearchParams({
        //         date_start: dateStartInput.value,
        //         date_end: dateEndInput.value,
        //     });
        //     fetch(url)
        //         .then(response => response.json())
        //         .then(result => {
        //             incomeSumElm.innerHTML = getIsoNumberWithSeparator(result.total_income);
        //         });
        // }

        function drawToDetailModalBody(obj) {
            let subHtml = ``;
            let subTotal = Number(0);
            obj.sell_details.forEach((sell_detail, index) => {
                let sellPriceTotal = Number(sell_detail.qty) * Number(sell_detail.sell_price);
                subTotal += sellPriceTotal;
                subHtml += `
                    <tr>
                        <td>${++index}</td>
                        <td>${sell_detail.item.barcode}</td>
                        <td>${sell_detail.item.name}</td>
                        <td class="text-right">${sell_detail.qty}</td>
                        <td class="text-right">${getIsoNumberWithSeparator(sell_detail.sell_price)}</td>
                        <td class="text-right">${getIsoNumberWithSeparator(sellPriceTotal)}</td>
                    </tr>
                `;
            });

            let subHistoryHtml = ``;
            let sisa = Number(obj.summary);
            obj.sell_payment_hs.forEach((sell_payment_h, index) => {
                sisa -= Number(sell_payment_h.amount);
                subHistoryHtml += `
                    <tr>
                        <td>${++index}</td>
                        <td>${getIndoDate(sell_payment_h.updated_at)}</td>
                        <td>${(sell_payment_h.note) ? sell_payment_h.note : '-'}</td>
                        <td>${sell_payment_h.user?.name || '-'}</td>
                        <td class="text-right">${getIsoNumberWithSeparator(sell_payment_h.amount)}</td>
                    </tr>
                `;
            });

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
                                    <dt class="col-sm-4">Nama Member</dt>
                                    <dd class="col-sm-8">${obj.member.name}</dd>
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
                                            <tr>
                                                <th colspan="5" class="text-right">Nonimal Bayar</th>
                                                <th class="text-right">${getIsoNumberWithSeparator(obj.paid_amount)}</th>
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
                                <h3 class="card-title">Histori Penagihan</h3>
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
    </script>
@stop
