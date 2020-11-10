@extends('adminlte::page')

@section('title', 'Laporan Pembelian')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Laporan Pembelian</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Pembelian</li>
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
                    <div class="buyTableFilter">
                        <div class="form-group mb-0">
                        <input type="date" name="start_date" class="form-control" value="{{$date_now}}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            <input type="date" name="end_date" class="form-control" value="{{$date_now}}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="button" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                        <h3 class="buy_qty">0</h3>
    
                        <p>Jumlah Transaksi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 class="buy_expend">0</h3>
            
                            <p>Total Pengeluaran</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="buy_dept">0</h3>
            
                            <p>Total Hutang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                {{-- <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 class="buy_estimated_expend">0</h3>
            
                            <p>Perkiraan Total Pengeluaran</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> --}}
            </div>
            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Pengeluaran</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default expendTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="expendTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tgl</th>
                                <th>Kode</th>
                                <th>Pengeluaran</th>
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
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> dept</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default deptTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="deptTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tgl</th>
                                <th>Kode</th>
                                <th>Hutang</th>
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
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Barang</h5>
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
                                <th>Barang</th>
                                <th>Qty</th>
                                <th>Pengeluaran</th>
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
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Suplier</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default suplierTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="suplierTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Suplier</th>
                                <th>Jumlah Transaksi</th>
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
                        <h4 class="modal-title">Detail Pembelian</h4>
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
    </style>
@stop
@section('js')
    <script type="module">
        import { select2DatatableInit, domReady, addListenToEvent, getIndoDate, getIsoNumberWithSeparator, swalConfirm, drawError, eraseErrorInit, swalAlert } from '{{ asset("plugins/custom/global.app.js") }}'

        const mainContentElm = document.querySelector('.mainContent');
        const detailModal = document.querySelector('#detailModal');

        const expendTable = $('#expendTable').DataTable({
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
                url: "{{ route('buy_report.expend_datatables') }}",
                data: function (d) {
                    d.filter = {
                        start_date: document.querySelector('input[name="start_date"]').value,
                        end_date: document.querySelector('input[name="end_date"]').value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'date'},
                {data: 'buy_code'},
                {data: 'sum_amount'},
            ],
            order: [[1, 'asc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
        const deptTable = $('#deptTable').DataTable({
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
                url: "{{ route('buy_report.dept_datatables') }}",
                data: function (d) {
                    d.filter = {
                        start_date: document.querySelector('input[name="start_date"]').value,
                        end_date: document.querySelector('input[name="end_date"]').value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'date'},
                {data: 'buy_code'},
                {data: 'sum_dept'},
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
                url: "{{ route('buy_report.item_datatables') }}",
                data: function (d) {
                    d.filter = {
                        start_date: document.querySelector('input[name="start_date"]').value,
                        end_date: document.querySelector('input[name="end_date"]').value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'sum_qty'},
                {data: 'sum_buy_price'},
            ],
            order: [[2, 'desc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
        const suplierTable = $('#suplierTable').DataTable({
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
                url: "{{ route('buy_report.suplier_datatables') }}",
                data: function (d) {
                    d.filter = {
                        start_date: document.querySelector('input[name="start_date"]').value,
                        end_date: document.querySelector('input[name="end_date"]').value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name'},
                {data: 'count_transaction'},
            ],
            order: [[2, 'desc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });

        domReady(() => {
            
            
            getTotalTransactions();
            getCurrentExpend();
            getOverallDept();
            // getEstimatedTotalExpend();

            addListenToEvent('.mainContent .filterButton', 'click', (event) => {
                getTotalTransactions();
                getCurrentExpend();
                getOverallDept();

                expendTable.ajax.reload()
                itemTable.ajax.reload()
                suplierTable.ajax.reload()
            });

            addListenToEvent('.mainContent .expendTableRefreshBtn', 'click', (event) => {
                expendTable.ajax.reload();
            });

            addListenToEvent('.mainContent .deptTableRefreshBtn', 'click', (event) => {
                deptTable.ajax.reload();
            });

            addListenToEvent('.mainContent .itemTableRefreshBtn', 'click', (event) => {
                itemTable.ajax.reload();
            });

            addListenToEvent('.mainContent .suplierTableRefreshBtn', 'click', (event) => {
                suplierTable.ajax.reload();
            });

        })

        function getTotalTransactions() {

            const selectElement = document.querySelector('.bg-info')
            selectElement.innerHTML += `
                <div class="overlay dark">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            `
            // get filter
            const url = '{{route("buy_report.get_total_transactions")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(url)
            .then(response => response.json())
            .then(result => {
                selectElement.querySelector('.buy_qty').innerText = result.buy_count;

                // finish loading
                let deleteElement = selectElement.querySelector('.overlay');
                deleteElement.remove();
            })
            
        }

        function getCurrentExpend() {
            
            const selectElement = document.querySelector('.bg-success')
            selectElement.innerHTML += `
                <div class="overlay dark">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            `
            // get filter
            const url = '{{route("buy_report.get_current_expend")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result.buy_expend)
                selectElement.querySelector('.buy_expend').innerText = getIsoNumberWithSeparator(result.total_expend);
            
                // finish loading
                let deleteElement = selectElement.querySelector('.overlay');
                deleteElement.remove();
            })
            
            // console.log(deleteElement)
        }

        function getOverallDept() {
    
            const selectElement = document.querySelector('.bg-warning')
            selectElement.innerHTML += `
                <div class="overlay dark">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            `
            // get filter
            const url = '{{route("buy_report.get_overall_dept")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(url)
            .then(response => response.json())
            .then(result => {
                // console.log(result.buy_dept)
                selectElement.querySelector('.buy_dept').innerText = getIsoNumberWithSeparator(result.buy_dept);
            
                // finish loading
                let deleteElement = selectElement.querySelector('.overlay');
                deleteElement.remove();
            })
            
            // console.log(deleteElement)
        }

        function getEstimatedTotalExpend() {
            
            const selectElement = document.querySelector('.bg-danger')
            selectElement.innerHTML += `
                <div class="overlay dark">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            `
            // get filter
            const url = '{{route("buy_report.get_estimated_total_expend")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result.buy_expend)
                selectElement.querySelector('.buy_estimated_expend').innerText = getIsoNumberWithSeparator(result.buy_expend);
            
                // finish loading
                let deleteElement = selectElement.querySelector('.overlay');
                deleteElement.remove();
            })
            
            // console.log(deleteElement)
        }
    </script>
@stop