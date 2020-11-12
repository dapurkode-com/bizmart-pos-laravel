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
                                        <option value="{{$i}}" {{Request::input('month', date('m')) == $i ? 'selected' : ''}}>{{DateTime::createFromFormat('!m', $i)->format('F')}}</option>
                                    @endfor
                                </select>
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
                        Bulan {{DateTime::createFromFormat('!m', $month)->format('F')}}
                    </div>
               </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped" id="tbIndex">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ref ID</th>
                                    <th>Tanggal</th>
                                    <th>Oleh</th>
                                    <th>Keterangan</th>
                                    <th>Arus</th>
                                    <th class="text-right">Sejumlah</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>

                            </tfoot>
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
