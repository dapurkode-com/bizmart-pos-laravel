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
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                        <h3 class="buy_qty">0</h3>
    
                        <p>Jumlah Pembelian</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 class="buy_expend">0</h3>
            
                            <p>Pengeluaran Saat Ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="buy_dept">0</h3>
            
                            <p>Hutang</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
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
                </div>
            </div>
            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Barang yang Dibeli</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default buyTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="itemTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah Dibeli</th>
                                <th>Total Biaya</th>
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
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Suplier Tempat Membeli</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default buyTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
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
                                <th>Banyak Transaksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
        // const itemTable = $('#itemTable').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     language: {
        //         decimal:        "",
        //         emptyTable:     "Tidak ada data di dalam tabel",
        //         info:           "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
        //         infoEmpty:      "Data kosong",
        //         infoFiltered:   "(Difilter dari _MAX_ total data)",
        //         infoPostFix:    "",
        //         thousands:      ".",
        //         lengthMenu:     "Tampilkan _MENU_ data",
        //         loadingRecords: "Memuat...",
        //         processing:     "Memproses...",
        //         search:         "",
        //         zeroRecords:    "Tidak ada data yang cocok",
        //         paginate: {
        //             previous: '<i class="fas fa-chevron-left"></i>',
        //             next: '<i class="fas fa-chevron-right"></i>'
        //         },
        //         aria: {
        //             sortAscending:  ": mengurutkan kolom yang naik",
        //             sortDescending: ": mengurutkan kolom yang turun"
        //         },
        //         searchPlaceholder: 'Cari data',
        //     },
        //     scrollX: true,
        //     ajax: {
        //         url: "{{ route('buy_report.datatables_item') }}",
        //         data: function (d) {
        //             const filterElm = mainContentElm.querySelector('.itemTableFilter');
        //             d.filter = {
        //                 'date_start': filterElm.querySelector('[name="start_date"]').value,
        //                 'date_end': filterElm.querySelector('[name="end_date"]').value,
        //             };
        //         },
        //     },
        //     columns: [
        //         {data: 'DT_RowIndex', orderable: false, searchable: false },
        //         {data: '_updated_at'},
        //         {data: '_suplier_name'},
        //         {data: 'summary'},
        //         {data: '_user_name'},
               
        //     ],
        //     order: [[1, 'desc']],
        //     initComplete: () => {
        //         select2DatatableInit();
        //     },
        // });

        domReady(() => {
            // start loading
            const selectElement = document.querySelectorAll('.small-box')
            selectElement.forEach(element => {
                element.innerHTML += `
                <div class="overlay dark">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
            `
            });
            
            getTotalTransactions();
            getCurrentExpend();
            getOverallDept();
            getEstimatedTotalExpend();

        })

        function getTotalTransactions() {

            const selectElement = document.querySelector('.bg-info')
            // get filter
            const url = '{{route("buy_report.get_total_transactions")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(`${url}`, {
                method: "GET",                          
            })
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
            
            // get filter
            const url = '{{route("buy_report.get_current_expend")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(`${url}`, {
                method: "GET",                          
            })
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
            
            // get filter
            const url = '{{route("buy_report.get_overall_dept")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(`${url}`, {
                method: "GET",                          
            })
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
            // get filter
            const url = '{{route("buy_report.get_estimated_total_expend")}}?'+ new URLSearchParams({
                start_date: document.querySelector('input[name="start_date"]').value,
                end_date: document.querySelector('input[name="end_date"]').value,
            })

            //process data
            fetch(`${url}`, {
                method: "GET",                          
            })
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