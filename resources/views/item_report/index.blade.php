@extends('adminlte::page')

@section('title', 'Laporan Stok Barang')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Laporan Stok Barang</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Stok Barang</li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- main content -->
    <div class="row mainContent">
        <div class="col-sm-12">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-sm-12">
                         <h4><img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
                             alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
                             class=""
                             style="opacity:.8; width:2rem; display: inline">
                         </h4>
                    </div>
                </div>
                <div class="row invoice-info">
                     <div class="col-sm-4 invoice-col">
                         <address>
                         <strong>{{ $mrch_name->param_value }}</strong><br>
                         {{ $mrch_addr->param_value }}<br>
                         {{ $mrch_phone->param_value }}
                         </address>
                     </div>
                     <div class="col-sm-4 invoice-col"></div>
                     <div class="col-sm-4 invoice-col text-right">
                         <strong>Laporan Stok Barang</strong><br>
                     </div>
                </div>
                <div class="card bg-default">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Stok Barang</h5>
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
                                    <th>Barcode</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Kuantitas</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="row no-print text-right">
                    <div class="col-12">
                        <button type="button" class="btn btn-info sm" id="btnPrint"><i class="fas fa-print"></i> Print</button>
                    </div>
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

        const itemTable = $('#itemTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            paging: false,
            ordering: false,
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
                url: "{{ route('item_report.item_datatables') }}",
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'barcode', name: 'items.barcode'},
                {data: 'name', name: 'items.name'},
                {data: 'categories', name: 'categories.name'},
                {data: 'stock', name: 'items.stock'},
                {data: 'unit.name', name: 'units.name'},

            ],
            order: [[1, 'asc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });

        domReady(() => {

            addListenToEvent('.mainContent .filterButton', 'click', (event) => {
                itemTable.ajax.reload()
            });

            addListenToEvent('.mainContent .itemTableRefreshBtn', 'click', (event) => {
                itemTable.ajax.reload();
            });

            addListenToEvent('#btnPrint', 'click', (event) => {
                window.print()
            });

        })

     
    </script>
@stop