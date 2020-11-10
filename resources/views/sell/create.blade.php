@extends('adminlte::page')

@section('title', 'Sell')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Penjualan</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Penjualan</li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- main content -->
    <form>
        <div class="row mainContent">
            <div class="col-lg-9 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card bg-default">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Form Pilih Barang</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <label>Barang</label>
                                            <select name="items" class="form-control" data-placeholder="Pilih barang" data-url="{{ route('sell.get_items') }}"></select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label>Aksi</label>
                                            <button type="button" class="btn btn-info btn-block addItemBtn" title="Tambahkan barang ke tabel"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-sm-12">
                        <div class="card bg-default">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> List Barang yang Dijual</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="itemsTable table table-hovered table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Barcode</th>
                                                <th>Barang</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-right">Harga</th>
                                                <th class="text-right">Harga Total</th>
                                                <th class="text-right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr class="d-none">
                                                <th colspan="4" class="text-right">Subtotal</th>
                                                <th class="p-1">
                                                    <div class="form-group mb-0">
                                                        <input type="number" name="summary_before_tax" value="0" class="form-control text-right" placeholder="0" readonly>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </th>
                                                <th></th>
                                            </tr>
                                            <tr class="d-none">
                                                <th colspan="3" class="text-right">PPN (%)</th>
                                                <th class="p-1">
                                                    <div class="form-group mb-0">
                                                        <input type="number" name="tax_percent" value="0" min="0" oninput="this.value = Math.abs(this.value)" class="form-control text-right" placeholder="0">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </th>
                                                <th class="p-1">
                                                    <div class="form-group mb-0">
                                                        <input type="number" name="tax" value="0" class="form-control text-right" placeholder="0" readonly>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">Total</th>
                                                <th class="p-1">
                                                    <div class="form-group mb-0">
                                                        <input type="number" name="summary" value="0" class="form-control text-right" placeholder="0" readonly>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">Nominal Bayar</th>
                                                <th class="p-1">
                                                    <div class="form-group mb-0">
                                                        <input type="number" name="paid_amount" min="0" oninput="this.value = Math.abs(this.value)" class="form-control text-right" placeholder="0">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">Nominal Kembali</th>
                                                <th class="p-1">
                                                    <div class="form-group mb-0">
                                                        <input type="number" name="paid_return" value="0" class="form-control text-right" placeholder="0" readonly>
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

            <div class="col-lg-3 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card bg-default">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Form Lainnya  </h5>
                                    </div>
                                    <div class="col-4 text-right">
                                        <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Member</label>
                                            <select name="members" class="form-control" data-placeholder="Pilih member" data-url="{{ route('sell.get_members') }}"></select>
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
            </div>

            <div class="col-lg-12">
                <div class="card bg-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="reset" class="btn btn-danger btn-block" title="Bersihkan semua form"><i class="fas fa-fw fa-times"></i> Reset</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="mt-0 btn btn-success btn-block submitButtonLoading d-none" disabled><i class="fas fa-spin fa-fw fa-spinner"></i> Simpan...</button>
                                <button type="button" class="mt-0 btn btn-success btn-block submitButton" title="Proses penjualan"><i class="fas fa-fw fa-check"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        /* btn reset */
        @media screen and (max-width: 575px) {
            .btn[type="reset"] {
                margin-bottom: 1rem;
            }
        }
        /* btn reset */
    </style>
@stop

@section('js')
    <script type="module">
        import { domReady, addListenToEvent, drawError, eraseErrorInit, swalAlert, swalConfirm, simulateEvent } from '{{ asset("plugins/custom/global.app.js") }}'
        
        const mainContentElm = document.querySelector('.mainContent');
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
                    itemsTable.querySelectorAll('[name="items[]"]').forEach((_elm, index) => {
                        const _itemObj = JSON.parse(_elm.value);
                        if (_itemObj.id === itemObj.id) {
                            const qtyBefore = itemsTable.querySelectorAll('[name="qty[]"]')[index].value;
                            const qtyNew = Number(qtyBefore) + Number(1);
                            itemsTable.querySelectorAll('[name="qty[]"]')[index].value = qtyNew;
                            isItemExistInTable = true;
                            return false;
                        }
                    });
                    if (!isItemExistInTable) {
                        itemsTable.querySelector('tbody').append(drawItemToTable(itemObj));
                    }
                    calculateTable();
                    itemsSelect.html('').trigger('change');
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
                            <input type="number" name="qty[]" value="1" min="0" oninput="this.value = Math.abs(this.value)" class="form-control text-right" placeholder="0">
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
