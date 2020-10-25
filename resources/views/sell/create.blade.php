@extends('adminlte::page')

@section('title', 'User')

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
    <div class="row mainContent">
        <div class="col-lg-9 col-md-12">
            <div class="row">
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
                            <h3 class="card-title">List Barang yang Dijual</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
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
                                        <tr>
                                            <th colspan="4" class="text-right">Total</th>
                                            <th class="p-1">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="summary_before_tax" value="0" class="form-control" placeholder="0" readonly>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">PPN (%)</th>
                                            <th class="p-1">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="tax_percent" value="0" class="form-control" placeholder="0">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </th>
                                            <th class="p-1">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="tax" value="0" class="form-control" placeholder="0" readonly>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Grand Total</th>
                                            <th class="p-1">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="summary" value="0" class="form-control" placeholder="0" readonly>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Nominal Bayar</th>
                                            <th class="p-1">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="paid_amount" value="0" class="form-control" placeholder="0">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Nominal Kembali</th>
                                            <th class="p-1">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="paid_return" value="0" class="form-control" placeholder="0" readonly>
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
                            <h3 class="card-title">Form Lainnya</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
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
                            <button type="button" class="btn btn-success btn-block" title="Bersihkan semua form"><i class="fas fa-fw fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        import { domReady, addListenToEvent, drawError, eraseErrorInit, swalAlert } from '{{ asset("plugins/custom/global.app.js") }}'
        
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
        });



        function drawItemToTable (itemObj) {
            const htmlNode = document.createElement('tr');
            htmlNode.innerHTML = `
                <tr>
                    <td>${itemObj.barcode}</td>
                    <td>${itemObj.name}</td>
                    <td class="p-1">
                        <div class="form-group mb-0">
                            <input type="number" name="qty[]" value="0" class="form-control text-right" placeholder="0">
                            <div class="invalid-feedback"></div>
                        </div>
                    </td>
                    <td class="text-right">${itemObj.sell_price}</td>
                    <td class="p-1">
                        <div class="form-group mb-0">
                            <input type="number" name="sell_price_total[]" value="0" class="form-control text-right" placeholder="0" readonly>
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
            let summary = summaryBeforeTax - tax;
            let paidReturn = Number(paidAmountInput.value) - summary;
            
            summaryBeforeTaxInput.value = summaryBeforeTax;
            taxInput.value = tax;
            summaryInput.value = summary;
            paidReturnInput.value = paidReturn;
        }
    </script>
@stop
