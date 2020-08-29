@extends('adminlte::page')

@section('title', 'Detail Pembelian')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Detail Pembelian</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('buy.index') }}">Daftar Pembelian</a>
            </li>
			<li class="breadcrumb-item active"> Detail Pembelian</li>
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
                            style="opacity:.8; width:2rem; display: inline"> Bizmart
                        <small class="float-right">
                            {{ $buys->updated_at->isoFormat('DD/MM/Y') }}
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
                    <div class="col-sm-4 invoice-col">
                        Kepada
                        <address>
                        <strong>{{ $buys->suplier->name }}</strong><br>
                        {{ $buys->suplier->address }}<br>
                        {{ $buys->suplier->phone }}<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice</b><br>
                        {{ $buys->uniq_id }}<br><br>
                        <b>Pegawai: </b> {{ auth()->user()->name }}
                    </div>
               </div>
                <div class="row">
                    <div class="col-sm-12">
                        <input id="buy_id" type="hidden" name="buy_id" value="{{$buys->uniq_id}}">
                        <table class="table table-striped" id="tbIndex">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Barcode</th>
                                    <th>Qty</th>
                                    <th>Harga Barang</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
    
                            </tbody>
                            <tfoot>
                                <tr>   
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td><Strong>Total</Strong></td>
                                    <td>{{ $buys->summary }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        Keterangan : <br>
                        {{ ($buys->note == null) ? '-' : $buys->note }}
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{ route('buy.print_report', $buys->uniq_id)}}"  class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
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
     $(document).ready( function () {
        $('#tbIndex').DataTable({
            processing  : true,
            serverSide  : true,
            "paging"    : false,
            "ordering"  : false,
            "info"      : false,
            "searching" : false,
            ajax: {
                url: "{{ route('buy.datatables_report_detail') }}",
                data: function (data) {
                    data.uniq_id = $('#buy_id').val();
                    console.log(data.uniq_id);
                }
            },
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
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'item.name', orderable: false, searchable: false },
                {data: 'item.barcode', orderable: false, searchable: false },
                {data: 'qty', orderable: false, searchable: false },
                {data: 'buy_price', orderable: false, searchable: false },
                {data: 'subtotal', orderable: false, searchable: false },
            ],
            order: [[1, 'asc']]
        });

        
    });
</script>
@stop