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
                                        <button type="button" class="btn btn-info btn-block btnAddItem" title="Tambahkan barang ke tabel"><i class="fas fa-plus"></i></button>
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
                                <table class="listItem table table-hovered table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Harga Total</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-right">Total</th>
                                            <th class="p-1">
                                                <div class="form-group mb-0">
                                                    <input type="number" name="summary" value="0" class="form-control" placeholder="0" readonly>
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
        /* navbar */
        ul.navbar-nav li.nav-item.active{
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            background: #0079fa;
            border-radius: .25rem;
        }
        ul.navbar-nav li.nav-item.active a.nav-link{
            color: white;
            padding-right: 16px;
            padding-left: 16px;
        }
        /* end navbar */

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
    <script>
        const selectItemsElm = $('[name="items"]').select2({
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

        const selectMembersElm = $('[name="members"]').select2({
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
        $(document).ready(() => {
        });
    </script>
@stop
