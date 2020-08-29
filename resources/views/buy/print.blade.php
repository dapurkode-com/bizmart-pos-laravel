<html><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Invoice Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->
  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
  
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body>
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
                 <br>
                 <b>ID Pembelian: </b>{{ $buys->uniq_id }}<br>
                 <b>User: </b> {{ auth()->user()->name }}
             </div>
        </div>
         <div class="row">
             <div class="col-sm-12">
                 <input id="buy_id" type="hidden" name="buy_id" value="{{$buys->id}}">
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
                        @foreach ($details as $i => $detail)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $detail->item->name }}</td>
                                <td>{{ $detail->item->barcode }}</td>
                                <td>{{ $detail->qty}}</td>
                                <td>{{ $detail->buy_price}}</td>
                                <td>{{ $detail->qty * $detail->buy_price }}</td>

                            </tr>
                        @endforeach
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
         
    </div>
  
  <script type="text/javascript"> 

    window.addEventListener("load", window.print());

  </script>
  
  
  </body></html>

