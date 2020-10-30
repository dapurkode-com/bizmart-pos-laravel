@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Daftar Penjualan</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Penjualan</li>
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
                    <div class="sellTableFilter">
                        <input type="date" name="date_start" class="form-control">
                        <p class="mb-0">sampai</p>
                        <input type="date" name="date_end" class="form-control">
                        <button type="button" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                    </div>
                </div>
            </div>
            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Penjualan</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="sellTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Tgl</th>
                                <th>Member</th>
                                <th>Total</th>
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
            }
            .sellTableFilter .filterButton {
                width: 100%;
            }
        }
    </style>
@stop

@section('js')
    <script type="module">
        import { select2DatatableInit, domReady, addListenToEvent, drawError, eraseErrorInit, swalAlert, swalConfirm, simulateEvent } from '{{ asset("plugins/custom/global.app.js") }}'
        
        const mainContentElm = document.querySelector('.mainContent');
        const sellTable = $('#sellTable').DataTable({
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
                url: "{{ route('sell.datatables') }}",
                data: function (d) {
                    const filterElm = mainContentElm.querySelector('.sellTableFilter');
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
                {data: '_member_name'},
                {data: 'summary'},
                {data: '_user_name'},
                {data: '_status'},
                {data: 'action', orderable: false, searchable: false, className: 'text-right text-nowrap'},
            ],
            order: [[1, 'desc']],
            initComplete: () => {
                select2DatatableInit();
            },
        });
        const itemsSelect = $('.mainContent [name="items"]').select2({
            width: '100%',
            placeholder: () => {
                return $(this).data('placeholder');
            },
            language: {
                errorLoading: function(){
                    return "Searching..."
                }
            },
            allowClear: true,
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
        const membersSelect = $('.mainContent [name="members"]').select2({
            width: '100%',
            placeholder: () => {
                return $(this).data('placeholder');
            },
            language: {
                errorLoading: function(){
                    return "Searching..."
                }
            },
            allowClear: true,
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
        const itemsTable = document.querySelector('.mainContent .itemsTable');



        $(document).ready(() => {   
        });

        domReady(() => {
            eraseErrorInit();

            addListenToEvent('.mainContent .addItemBtn', 'click', (event) => {
                const isItemsSelectEmpty = itemsSelect.val() === '' || itemsSelect.val() === null;
                if (isItemsSelectEmpty) {
                    drawError(itemsSelect[0].parentElement.parentElement, {
                        items: ['Barang wajib diisi.']
                    })
                } else {
                    const itemObj = JSON.parse(itemsSelect.val());
                    let isItemExistInTable = false;
                    itemsTable.querySelectorAll('[name="items[]"]').forEach((_elm) => {
                        const _itemObj = JSON.parse(_elm.value);
                        if (_itemObj.id === itemObj.id) {
                            isItemExistInTable = true;
                            return false;
                        }
                    });
                    if (isItemExistInTable) {
                        swalAlert('Barang ini sudah ada dalam table', 'error');
                    } else {
                        itemsTable.querySelector('tbody').append(drawItemToTable(itemObj));
                        calculateTable();
                    }
                }
            });

            addListenToEvent('.mainContent .itemsTable .deleteItemBtn', 'click', (event) => {
                const thisBtn = event.target.closest('button');
                thisBtn.closest('tr').remove();
                calculateTable();
            });

            addListenToEvent('.mainContent .itemsTable [name="qty[]"]', 'input', (event) => {
                calculateTable();
            });
            
            addListenToEvent('.mainContent .itemsTable [name="tax_percent"]', 'input', (event) => {
                calculateTable();
            });
            
            addListenToEvent('.mainContent .itemsTable [name="paid_amount"]', 'input', (event) => {
                calculateTable();
            });

            addListenToEvent('.mainContent button[type="reset"]', 'click', (event) => {
                itemsTable.querySelector('tbody').innerHTML = '';
                itemsSelect.html('').trigger('change');
                membersSelect.html('').trigger('change');
            });

            addListenToEvent('.mainContent .submitButton', 'click', (event) => {
                swalConfirm('melakukan ini')
                    .then(() => {
                        // prepare data
                        const paidAmountInput = itemsTable.querySelector('[name="paid_amount"]');
                        const summaryInput = itemsTable.querySelector('[name="summary"]');
                        const itemsInputs = itemsTable.querySelectorAll('[name="items[]"]');
                        const resetButton = mainContentElm.querySelector('button[type="reset"]');
                        let memberObj = JSON.parse(membersSelect.val());
                        let paidAmount = (Number(paidAmountInput.value) > Number(summaryInput.value)) ? summaryInput.value : paidAmountInput.value;

                        let data = {
                            member_id : (memberObj) ? memberObj.id : '',
                            summary : summaryInput.value,
                            tax : itemsTable.querySelector('[name="tax"]').value,
                            note : mainContentElm.querySelector('[name="note"]').value,
                            paid_amount : paidAmount,
                            sell_details : []
                        }

                        itemsInputs.forEach((itemsInput, index) => {
                            console.log(data, index);
                            const itemObj = JSON.parse(itemsInput.value);
                            const qtyInput = itemsTable.querySelectorAll('[name="qty[]"]')[index];

                            data.sell_details[index] = {};
                            data.sell_details[index].item_id = (itemObj) ? itemObj.id : '';
                            data.sell_details[index].qty = qtyInput.value;
                            data.sell_details[index].sell_price = (itemObj) ? itemObj.sell_price : '';
                        });
                        // end prepare data
                        
                        // loading and disabled button
                        document.querySelector('.submitButton').classList.toggle('d-none');
                        document.querySelector('.submitButtonLoading').classList.toggle('d-none');
                        
                        fetch("{{ route('sell.store') }}", {
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
                                    customDrawError(mainContentElm, result.validators);
                                }
                                if(result.status == 'valid'){
                                    swalAlert(result.pesan, 'success');
                                    simulateEvent(resetButton, 'click');
                                }
                                if(result.status == 'error'){
                                    swalAlert(result.pesan, 'warning');
                                }
                            })
                            .finally(() => {
                                // loading and disabled button
                                document.querySelector('.submitButton').classList.toggle('d-none');
                                document.querySelector('.submitButtonLoading').classList.toggle('d-none');
                            });
                    });
            });
        });



        function drawItemToTable (itemObj) {
            const htmlNode = document.createElement('tr');
            htmlNode.innerHTML = `
                <tr>
                    <td>${itemObj.barcode}</td>
                    <td>${itemObj.name}</td>
                    <td class="p-1">
                        <div class="form-group mb-0">
                            <input type="number" name="qty[]" class="form-control text-right" placeholder="0">
                            <div class="invalid-feedback"></div>
                        </div>
                    </td>
                    <td class="text-right">${itemObj.sell_price}</td>
                    <td class="p-1">
                        <div class="form-group mb-0">
                            <input type="number" name="sell_price_total[]" class="form-control text-right" placeholder="0" readonly>
                            <div class="invalid-feedback"></div>
                        </div>
                    </td>
                    <td class="text-right">
                        <button type="button" class="btn btn-danger btn-xs deleteItemBtn d-block float-right" title="Hapus"><i class="fas fa-trash fa-fw"></i></button>
                        <input type="hidden" name="items[]" value='${JSON.stringify(itemObj)}'>
                    </td>
                </tr>
            `;
            return htmlNode;
        }

        function calculateTable() {
            const summaryBeforeTaxInput = itemsTable.querySelector('[name="summary_before_tax"]');
            const summaryInput = itemsTable.querySelector('[name="summary"]');
            const taxPercentInput = itemsTable.querySelector('[name="tax_percent"]');
            const taxInput = itemsTable.querySelector('[name="tax"]');
            const paidAmountInput = itemsTable.querySelector('[name="paid_amount"]');
            const paidReturnInput = itemsTable.querySelector('[name="paid_return"]');
            let summaryBeforeTax = Number(0);
            itemsTable.querySelectorAll('[name="qty[]"]').forEach((qtyInput, index) => {
                const itemsInput = itemsTable.querySelectorAll('[name="items[]"]')[index];
                const itemsObj = JSON.parse(itemsInput.value);
                const sellPriceTotalInput = itemsTable.querySelectorAll('[name="sell_price_total[]"]')[index];
                let sellPriceTotal = Number(qtyInput.value) * Number(itemsObj.sell_price);
                summaryBeforeTax = summaryBeforeTax + Number(sellPriceTotal);

                sellPriceTotalInput.value = sellPriceTotal;
            });
            let tax = (summaryBeforeTax * Number(taxPercentInput.value) / Number(100));
            let summary = summaryBeforeTax + tax;
            let paidReturn = Number(paidAmountInput.value) - summary;
            
            summaryBeforeTaxInput.value = summaryBeforeTax;
            taxInput.value = tax;
            summaryInput.value = summary;
            paidReturnInput.value = paidReturn;
        }

        function customDrawError(parentElm, validators) {
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
                        
                        if (keyName == 'member_id') {
                            keyName = 'members';
                        }
                        if (keyName == 'sell_details') {
                            isDraw = false;
                            swalAlert('List barang harus diisi', 'warning');
                        }

                        if (isDraw === true) {
                            parentElm.querySelector(`[name="${keyName}"]`).classList.add('is-invalid');
                            parentElm.querySelector(`[name="${keyName}"]`).closest('.form-group').querySelector('.invalid-feedback').innerHTML = `${value}`;
                        }
                    }

                }
            }
        }
    </script>
@stop
