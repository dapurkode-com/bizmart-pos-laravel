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
                    <div class="filter">
                        <div class="form-group mb-0">
                            <input type="date" name="date_start" value="{{ $tglNow }}" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            <input type="date" name="date_end" value="{{ $tglNow }}" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div style="justify-self: end">
                            <button type="button" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                            <button type="button" class="btn btn-primary generatePdf"><i class="fas fa-file mr-2"></i> Generate PDF</button>
                        </div>
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

                            <p>Total Pemasukan</p>
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
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Pemasukan</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default incomeTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="incomeTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tgl</th>
                                <th>Kode</th>
                                <th class="text-right">Pemasukan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Piutang</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default piutangTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="piutangTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tgl</th>
                                <th>Kode</th>
                                <th class="text-right">Piutang</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Barang / Jasa</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default itemTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="itemTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barang / Jasa</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Pemasukan</th>
                                <th class="text-right">Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Konsumen</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default memberTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="memberTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Konsumen</th>
                                <th class="text-right">Jumlah Transaksi</th>
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
        .filter {
            display: grid;
            grid-template-columns: 0fr 0fr 0fr 1fr;
            gap: 1rem;
            align-items: center;
        }
        .filter .filterButton {
            width: 80px;
        }

        #incomeNowSum::before,
        #piutangSum::before{
            content:"Rp "
        }

        @media only screen and (max-width: 617px) {
            .filter {
                grid-template-columns: 1fr;
                justify-items: center;
                gap: 0;
            }
            .filter .filterButton {
                margin-top: 1rem;
                width: 185.19px;
                justify-self: center;
            }
        }
    </style>
@stop

@section('js')
    <script type="module">
        import { select2DatatableInit, domReady, addListenToEvent, getIsoNumberWithSeparator } from '{{ asset("plugins/custom/global.app.js") }}'

        const mainContentElm = document.querySelector('.mainContent');
        const dateStartInput = document.querySelector('.filter [name="date_start"]');
        const dateEndInput = document.querySelector('.filter [name="date_end"]');
        const transCountElm = document.querySelector('#transactionCount');
        const incomeNowElm = document.querySelector('#incomeNowSum');
        const piutangSumElm = document.querySelector('#piutangSum');
        const incomeSumElm = document.querySelector('#incomeSum');
        const detailModal = document.querySelector('#detailModal');
        const incomeTable = $('#incomeTable').DataTable({
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
                url: "{{ route('sell_report.income_datatables') }}",
                data: function (d) {
                    d.filter = {
                        'date_start': dateStartInput.value,
                        'date_end': dateEndInput.value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'date'},
                {data: 'sell_code'},
                {data: 'sum_amount', className: 'text-right'},
            ],
            order: [[1, 'asc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
        const piutangTable = $('#piutangTable').DataTable({
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
                url: "{{ route('sell_report.piutang_datatables') }}",
                data: function (d) {
                    d.filter = {
                        'date_start': dateStartInput.value,
                        'date_end': dateEndInput.value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'date'},
                {data: 'sell_code'},
                {data: 'sum_piutang', className: 'text-right'},
            ],
            order: [[1, 'asc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
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
                url: "{{ route('sell_report.item_datatables') }}",
                data: function (d) {
                    d.filter = {
                        'date_start': dateStartInput.value,
                        'date_end': dateEndInput.value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'sum_qty', className: 'text-right'},
                {data: 'sum_sell_price', className: 'text-right'},
                {data: 'net_income', className: 'text-right'},
            ],
            order: [[2, 'desc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
        const memberTable = $('#memberTable').DataTable({
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
                url: "{{ route('sell_report.member_datatables') }}",
                data: function (d) {
                    d.filter = {
                        'date_start': dateStartInput.value,
                        'date_end': dateEndInput.value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'count_transaction', className: 'text-right'},
            ],
            order: [[2, 'desc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });

        domReady(() => {
            drawTransaction()
            drawIncomeNow()
            drawPiutang()
            // drawIncome()

            addListenToEvent('.mainContent .filterButton', 'click', (event) => {
                drawTransaction()
                drawIncomeNow()
                drawPiutang()
                // drawIncome()
                incomeTable.ajax.reload()
                itemTable.ajax.reload()
                memberTable.ajax.reload()
            });

            addListenToEvent('.generatePdf', 'click', (event) => {
                console.log("haha");
                let targetUrl = new URL("{{ route('sell_report.generate_pdf') }}");
                targetUrl.searchParams.append("date_start", dateStartInput.value);
                targetUrl.searchParams.append("date_end", dateEndInput.value);
                window.open(targetUrl);
            });

            addListenToEvent('.mainContent .incomeTableRefreshBtn', 'click', (event) => {
                incomeTable.ajax.reload();
            });

            addListenToEvent('.mainContent .piutangTableRefreshBtn', 'click', (event) => {
                piutangTable.ajax.reload();
            });

            addListenToEvent('.mainContent .itemTableRefreshBtn', 'click', (event) => {
                itemTable.ajax.reload();
            });

            addListenToEvent('.mainContent .memberTableRefreshBtn', 'click', (event) => {
                memberTable.ajax.reload();
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
    </script>
@stop
