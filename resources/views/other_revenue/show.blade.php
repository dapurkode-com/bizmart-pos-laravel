@extends('adminlte::page')

@section('title', 'Detail Pendapatan Lainnya')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Detail Pendapatan Lainnya</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('other_revenue.index') }}">Daftar Pendapatan Lainnya</a>
            </li>
			<li class="breadcrumb-item active"> Detail</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
   <div class="row">
       <div class="col-sm-12">
           <div class="invoice p-3 mb-3">
               <div class="row">
                   <div class="col-sm-12">
                        <h4><img src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
                            alt="{{ config('adminlte.logo_img_alt', 'AdminLTE') }}"
                            class=""
                            style="opacity:.8; width:2rem; display: inline">
                        <small class="float-right">
                            {{ $otherRevenue->updated_at->isoFormat('DD/MM/Y') }}
                        </small>
                        </h4>
                   </div>
               </div>
               <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        Dari
                        <address>
                        <strong>{{ $mrch_name->param_value }}</strong><br>
                        {{ $mrch_addr->param_value }}<br>
                        {{ $mrch_phone->param_value }}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col"></div>
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice</b><br>
                        {{ $otherRevenue->uniq_id }}<br><br>
                        <b>Oleh </b> {{ $otherRevenue->user->name }}
                    </div>
               </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input id="buy_id" type="hidden" name="buy_id" value="{{$otherRevenue->uniq_id}}">
                        <table class="table table-striped" id="tbIndex">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Deskripsi</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($otherRevenue->details as $key => $detail)
                                @php
                                    $key++;
                                @endphp
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $detail->description }}</td>
                                        <td class="text-right">{{ number_format($detail->amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><Strong>Total</Strong></td>
                                    <td class="text-right">{{ number_format($otherRevenue->summary) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <strong>Keterangan :</strong> <br>
                        {{ $otherRevenue->note ?? '-' }}
                    </div>
                </div>
                <div class="row no-print text-right">
                    <div class="col-12">
                        <button type="button" onclick="window.print()" class="btn btn-info sm"><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
           </div>
       </div>
   </div>
@stop

@section('css')

@stop

@section('js')
<script>

</script>
@stop
