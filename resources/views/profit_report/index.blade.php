@extends('adminlte::page')

@section('title', 'Laporan Laba-Rugi')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Laporan Laba-Rugi</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Laba-Rugi</li>
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
                    <div class="profitTableFilter">
                        <div class="form-group mb-0">
                            {!! Form::date('date_start', $date_start, ['class' => 'form-control', 'placeholder' => 'mm/dd/yyyy']) !!}
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            {!! Form::date('date_end', $date_end, ['class' => 'form-control', 'placeholder' => 'mm/dd/yyyy']) !!}
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                    </div>
                </div>
            </div>
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
                    <strong>Laporan Laba-Rugi</strong><br>
                    Tanggal {{ $date_start->format('d M Y') }} - {{ $date_end->format('d M Y') }}
                 </div>
            </div>
            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Hutang</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default buyTableRefreshBtn"><i class="fas fa-sync-alt" title="Refresh Table"></i></button>
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="profitTable" class="table table-hover" style="width: 100%">
                        <tr>
                            <th colspan="4">PENDAPATAN</th>
                        </tr>
                        <tr>
                            <td colspan="2">Penjualan</td>
                            <td>100.000</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Potongan Penjualan</td>
                            <td style="border-bottom: 2px solid black;">0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="2">JUMLAH PENDAPATAN BERSIH</th>
                            <td></td>
                            <td>100.000</td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="4">HARGA POKOK PENJUALAN (HPP)</th>
                        </tr>
                        <tr>
                            <td colspan="1">Persediaan Barang Awal</td>
                            <td>50.000</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <td colspan="1">Pembelian</td>
                            <td style="border-bottom: 2px solid black;">20.000</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Barang Tersedia Dijual</td>
                            <td>70.000</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Persedian Barang Akhir</td>
                            <td style="border-bottom: 2px solid black;">30.000</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="3">HPP</th>
                            <td style="border-bottom: 2px solid black;">40.000</td>
                        </tr>
                        <tr>
                            <th colspan="3">LABA KOTOR</th>
                            <td>60.000</td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="4">BEBAN USAHA</th>
                        </tr>
                        <tr>
                            <td colspan="1">Biaya Listrik</td>
                            <td>10.000</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <td colspan="1">Biaya Gaji Karyawan</td>
                            <td>15.000</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <td colspan="1">Biaya Perawatan Mesin</td>
                            <td style="border-bottom: 2px solid black;">10.000</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <th colspan="3">JUMLAH BEBAN USAHA</th>
                            <td style="border-bottom: 2px solid black;">35.000</td>
                        </tr>
                        <tr>
                            <th colspan="3">LABA/RUGI BERSIH</th>
                            <td>25.000</td>
                        </tr>

                    </table>
                    <div class="row no-print text-right mt-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-info sm" id="btnPrint"><i class="fas fa-print"></i> Print</button>
                        </div>
                    </div>
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
                        <h4 class="modal-title">Detail Hutang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer justify-content-between"></div>
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
        .sisaHutangBtn {
            border-radius: 0 4px 4px 0 !important;
        }
    </style>
@stop
@section('js')
    <script type="module">
        import { select2DatatableInit, domReady, addListenToEvent, getIndoDate, getIsoNumberWithSeparator, swalConfirm, drawError, eraseErrorInit, swalAlert } from '{{ asset("plugins/custom/global.app.js") }}'

        const mainContentElm = document.querySelector('.mainContent');

        domReady(() => {

            // addListenToEvent('.mainContent .filterButton', 'click', (event) => {
            //     itemTable.ajax.reload()
            // });

            // addListenToEvent('.mainContent .itemTableRefreshBtn', 'click', (event) => {
            //     itemTable.ajax.reload();
            // });

            addListenToEvent('#btnPrint', 'click', (event) => {
                window.print()
            });

        })


    </script>
@stop