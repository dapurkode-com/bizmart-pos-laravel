@extends('adminlte::page')

@section('title', 'Laba Rugi')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Laba Rugi</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active"> Laba Rugi</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
   <div class="row">
       <div class="col-sm-12 no-print">
           <form method="get">
               <div class="card bg-default">
                    <div class="card-body">
                        <div class="sellTableFilter">
                            <div class="form-group mb-0">
                               <select name="month" id="month" class="form-control">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{$i}}" {{$month == $i ? 'selected' : ''}}>{{DateTime::createFromFormat('!m', $i)->format('F')}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group mb-0" style="width: 100px ">
                                {!! Form::number('year',  $year, ['class'=>'form-control', 'style' => 'width:100%']) !!}
                            </div>
                            <button type="submit" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                        </div>
                    </div>
                </div>
           </form>
       </div>
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
                        <strong>Laporan Laba Rugi</strong><br>
                        Bulan {{DateTime::createFromFormat('!m', $month)->format('F')}} {{ $year }}
                    </div>
               </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="profitTable" class="table table-hover" style="width: 100%">
                        <tr>
                            <th colspan="4">PENDAPATAN</th>
                        </tr>
                        <tr>
                            <td colspan="2">Penjualan</td>
                            <td>{{ number_format($sellSummary) }}</td>
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
                            <td>{{ number_format($sellSummary) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <th colspan="4">HARGA POKOK PENJUALAN (HPP)</th>
                        </tr>
                        <tr>
                            <td colspan="1">Persediaan Barang Awal</td>
                            <td>{{ number_format($stockValueOld) }}</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <td colspan="1">Pembelian</td>
                            <td style="border-bottom: 2px solid black;">{{ number_format($buySummary) }}</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Barang Tersedia Dijual</td>
                            <td>{{ number_format($buySummary + $stockValueOld) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Persedian Barang Akhir</td>
                            <td style="border-bottom: 2px solid black;">{{ number_format($stockValueNew) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th colspan="3">HPP</th>
                            <td style="border-bottom: 2px solid black;">{{ number_format($buySummary + $stockValueOld - $stockValueNew) }}</td>
                        </tr>
                        <tr>
                            <th colspan="3">LABA KOTOR</th>
                            <td>{{ number_format($sellSummary - ($buySummary + $stockValueOld - $stockValueNew)) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <th colspan="4">BEBAN USAHA</th>
                        </tr>
                        <tr>
                            <td colspan="1">Biaya Lainnya.</td>
                            <td style="border-bottom: 2px solid black;">{{ number_format($otherExpenseSummary) }}</td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <th colspan="3">LABA/RUGI BERSIH</th>
                            <td>{{ number_format($sellSummary - ($buySummary + $stockValueOld - $stockValueNew) - $otherExpenseSummary) }}</td>
                        </tr>

                    </table>
                    </div>
                </div>
                <div class="row no-print text-right">
                    <div class="col-12">
                        <a href="{{ route('profit_loss.print_pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary sm"><i class="fas fa-file"></i> Generate PDF</a>
                        <button type="button" class="btn btn-info sm" id="btnPrint"><i class="fas fa-print"></i> Print</button>
                    </div>
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
                gap: 0;
            }
            .sellTableFilter .filterButton {
                margin-top: 1rem;
                width: 185.19px;
                justify-self: center;
            }
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready( function () {
        $('#btnPrint').click(function () {
            window.print()
        })
        $('#month').select2({
            width: '100%'

        });
    })
</script>
@stop
