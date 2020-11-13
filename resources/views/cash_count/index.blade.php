@extends('adminlte::page')

@section('title', 'Cash Count')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Hitung Kas</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Hitung Kas</li>
                <li class="breadcrumb-item active">Riwayat</li>
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
                    <div class="indexTableFilter">
                        <div class="form-group mb-0">
                            <input type="date" name="date_start" value="{{ Carbon::now()->toDateString() }}" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            <input type="date" name="date_end" value="{{ Carbon::now()->toDateString() }}" class="form-control">
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
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Riwayat Hitung Kas</h5>
                        </div>
                        <div class="col-6 text-right">
                            <!-- <button type="button" class="btn btn-info addBtn" title="Tambah Hitung Kas"><i class="fas fa-plus mr-2"></i>Tambah</button> -->
                            <button type="button" class="btn btn-default indexTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse" title="Toggle Table"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="indexTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Tgl Waktu</th>
                                <th>Saldo Hitung</th>
                                <th>Saldo Sistem</th>
                                <th>Selisih</th>
                                <th>Oleh</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- form modal -->
    <form>
        <div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Hitung Kas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Saldo Hitung</label>
                                    <input type="number" name="counted_amount" class="form-control" placeholder="Tulis saldo terhitung saat ini"/>
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
        .indexTableFilter {
            display: grid;
            grid-template-columns: 0fr 0fr 0fr 1fr;
            gap: 1rem;
            align-items: center;
        }
        .indexTableFilter .filterButton {
            width: 80px;
            justify-self: end;
        }
        @media only screen and (max-width: 617px) {
            .indexTableFilter {
                grid-template-columns: 1fr;
                justify-items: center;
                gap: 0;
            }
            .indexTableFilter .filterButton {
                margin-top: 1rem;
                width: 185.19px;
                justify-self: center;
            }
        }
    </style>
@stop

@section('js')
    <script type="module">
        import { select2DatatableInit, domReady, addListenToEvent, drawError, eraseErrorInit, swalAlert, simulateEvent } from '{{ asset("plugins/custom/global.app.js") }}'
        
        const mainContentElm = document.querySelector('.mainContent');
        const dateStartFilterInput = document.querySelector('.indexTableFilter [name="date_start"]')
        const dateEndFilterInput = document.querySelector('.indexTableFilter [name="date_end"]')
        const indexTable = $('#indexTable').DataTable({
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
                url: "{{ route('cash_count.datatables') }}",
                data: function (d) {
                    d.filter = {
                        'date_start': dateStartFilterInput.value,
                        'date_end': dateEndFilterInput.value,
                    };
                },
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'kode'},
                {data: 'date'},
                {data: 'counted_amount'},
                {data: 'counted_system'},
                {data: 'deviation'},
                {data: 'user'},
            ],
            order: [[1, 'desc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
        const formModal = document.querySelector('#formModal');
        const resetFormModalBtn = formModal.querySelector('button[type="reset"]')

        domReady(() => {
            eraseErrorInit();

            addListenToEvent('.mainContent .filterButton', 'click', (event) => {
                indexTable.ajax.reload();
            });

            addListenToEvent('.mainContent .indexTableRefreshBtn', 'click', (event) => {
                indexTable.ajax.reload();
            });

            addListenToEvent('.mainContent .addBtn', 'click', (event) => {
                simulateEvent(resetFormModalBtn, 'click')
                $(formModal).modal('show');
            });

            addListenToEvent('#formModal button[type="submit"]', 'click', (event) => {
                event.preventDefault();
                const thisBtn = event.target.closest('button');

                // prepare data
                let data = {
                    counted_amount : formModal.querySelector('[name="counted_amount"]').value,
                    _method : 'POST',
                }
                // end prepare data
                
                // loading and disabled button
                const thisBtnText = thisBtn.innerHTML;
                thisBtn.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i> ${thisBtnText}...`
                for (const elm of formModal.querySelectorAll('button')) {
                    elm.disabled = true;
                }
                
                fetch(`{{ route('cash_count.store') }}`, {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.status == 'invalid'){
                            drawError(formModal, result.validators);
                        }
                        if(result.status == 'valid'){
                            if(result.is_selisih === true){
                                swalAlert(result.pesan, 'error');
                            } else {
                                swalAlert(result.pesan, 'success');
                            }
                            $(formModal).modal('hide');
                        }
                        if(result.status == 'error'){
                            swalAlert(result.pesan, 'warning');
                        }
                    })
                    .finally(() => {
                        // loading and disabled button
                        thisBtn.innerHTML = `${thisBtnText}`
                        for (const elm of formModal.querySelectorAll('button')) {
                            elm.disabled = false;
                        }
                        indexTable.ajax.reload();
                    });
            });
        });

    </script>
@stop
