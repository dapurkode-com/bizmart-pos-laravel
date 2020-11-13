@extends('adminlte::page')

@section('title', 'Arus Kas')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Arus Kas</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active"> Arus Kas</li>
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
                        <strong>Laporan Arus Kas</strong><br>
                        Tanggal {{ $date_start->format('d M Y') }} - {{ $date_end->format('d M Y') }}
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
                                @php
                                    $total = 0;
                                @endphp
                                @forelse ($cashflows as $key => $flow)
                                    @php
                                        $key++;
                                        $total += $flow->amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $flow->ref_uniq_id }}</td>
                                        <td>{{ $flow->trx_date->format('d M Y') }}</td>
                                        <td>{{ $flow->user->name }}</td>
                                        <td>{!! $flow->cashCauseText() !!}</td>
                                        <td>{!! $flow->ioCashText() !!}</td>
                                        <td class="text-right">
                                            {{ number_format($flow->amount) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right">{{ number_format($total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row no-print text-right">
                    <div class="col-12">
                        {{-- <a href="{{ route('cashflow.generate_pdf', ['date_start' => $date_start, 'date_end' => $date_end]) }}" class="btn btn-primary sm"><i class="fas fa-file"></i> Generate PDF</a> --}}
                        <a href="{{ route('cashflow.generate_pdf') }}?date_start={{ $date_start }}&date_end={{ $date_end }}" class="btn btn-primary sm"><i class="fas fa-file"></i> Generate PDF</a>
                        {{-- <a href="{{ route('cashflow.generate_pdf', ['date_start' => $date_start, 'date_end' => $date_end]) }}" class="btn btn-primary sm"><i class="fas fa-file"></i> Generate PDF</a> --}}
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
    })
</script>
@stop
