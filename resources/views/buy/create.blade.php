@extends('adminlte::page')

@section('title', 'Transaksi Pembelian Barang')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
        <blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Transaksi Pembelian {{count(old('items_id',[]))}}</h1>
            
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('buy.index') }}">Pembelian</a>
            </li>
			<li class="breadcrumb-item active">Buat Baru</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
    <div class="row row-flex">
        <div class="col-md-6">
             <div class="card">
                 <div class="card-body">
                    
                    <h3 class="card-title mb-3"><i class="fa fa-search"></i> Pencari Barang</h3>
                    <div class="input-group">
                    <input type="text" id="barcode" class="form-control" placeholder="Tulis barcode disini." aria-label="Tulis barcode" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button id="btnList" class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#itemList"><i class="fa fa-list"></i> List Barang</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <p>Total Pembelian</p>
                    <h3 id="total_value">0</h3>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('buy.store') }}" method="post">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Pembelian</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 border p-3">
                            <b>Barang yang dibeli</b>
                            <table id="my_table" class="table table-bordered table-sm mt-2" >
                                <thead>
                                    <tr>
                                        <th style="width: 40%">Nama</th>
                                        <th style="width: 20%">Qty</th>
                                        <th style="width: 30%">Harga Beli</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count(old('items_id',[]))>0)
                                        @for($i =0; $i < count(old('items_id')); $i++)                            
                                            <tr class="my_tr">
                                                <td><input type="hidden" name="items_id[]" value="{{ old('items_id.'.$i)}}">
                                                    <input type="hidden" name="name[]" value="{{ old('name.'.$i)}}">{{ old('name.'.$i)}}</td>
                                                <td><input name="qty[]" data-val="{{ old('qty.'.$i)}}" id="qty" type="number" class="form-control" value="{{ old('qty.'.$i)}}"></td>
                                                <td><input name="buy_price[]" data-val="{{ old('buy_price.'.$i)}}" id="buy_price" type="number" class="form-control" value="{{ old('buy_price.'.$i)}}"></td>
                                                <td><button id= "btn_delete" data-id="{{ old('items_id.'.$i)}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></td> 
                                            </tr>                            
                                        @endfor
                                    @endif
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                        <div class="col-sm-6 border p-3">
                            <div class="form-group">
                                <label for="suplier_id">Cari Suplier</label>
                                <select name="suplier_id" id="suplier_id" class="form-control">
                                    <option value="0" selected hidden disabled>--Pilih Suplier--</option>
                                    @foreach ($options['SUPLIER'] as $option)
                                        <option value="{{ $option->id }}" {{ $option->id == old('suplier_id') ? 'selected' : '' }}>{{ $option->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <table class="table table-bordered table-sm table-striped">
                                <tr>
                                    <th>Nama Suplier</th>
                                    <td id="suplier_name" class="detail"> -- </td>
                                </tr>
                                <tr>
                                    <th>No Kontak</th>
                                    <td id="suplier_phone" class="detail"> -- </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td id="suplier_address" class="detail"> -- </td>
                                </tr>
                            </table>
                            <hr>
                            <div class="form-group">
                                <label for="note">Keterangan</label>
                                <textarea  class="form-control" name="note" id="note" cols="10" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <button id="reset" type="reset" class="btn btn-lg btn-block btn-danger"><i class="fa fa-times"></i> Batalkan</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-lg btn-block btn-success"><i class="fa fa-check"></i> Bayar</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="itemList" tabindex="-1" role="dialog" aria-labelledby="itemListLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="itemListLabel">Daftar barang pada persediaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="tbIndex" class="table table-striped table-sm table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
@endsection

@section('js')
<script>
    $(document).ready(function () {

        var msg = '{{ Session::get('message') }}';
        var exist = '{{Session::has('message')}}';
        if (exist) {
            alert(msg);
        }

        $("#suplier_id").select2();

        $('#tbIndex').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('buy.datatables') }}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'name', name: 'items.name'},
                {data: 'categories', name: 'categories.name'},
                {data: 'description', name: 'items.description'},
                {data: 'action', orderable: false, searchable: false},
            ],
            order: [[1, 'asc']]
        });

        $('#tbIndex').on('click','.my_btn', function (event) {
            var id = $(this).data('id');
            var elem = document.getElementById ( "total_value" );
            var text = elem.innerHTML;
            var sum = parseInt(text, 10);
            console.log(sum); 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url: "{{ route('buy.select') }}",
                data: {
                    'flag': 'uniq',
                    'item': id
                },
                dataType: "json",
                success: function (res) {
                    console.log(res.row);
                    var item = res.row;
                    var total = sum + item.buy_price;
                    var content = '<tr class="my_tr">'+
                        '<td><input type="hidden" name="items_id[]" value="'+item.id+'"><input type="hidden" name="name[]" value="'+item.name+'">'+item.name+'</td>'+
                        '<td><input name="qty[]" data-val="1" id="qty" type="number" class="form-control" value="1"></td>'+
                        '<td><input name="buy_price[]" data-val="'+item.buy_price+'" id="buy_price" type="number" class="form-control" value="'+item.buy_price+'"></td>'+
                        '<td><button id= "btn_delete" data-id="'+item.id+'" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></td>'+    
                    '</tr>';
                    $('#my_table').find('tbody').append(content);
                    $('#total_value').html(total);
                }
            });
        });

        $('#barcode').keypress(function (e) {
            
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode == '13'){
                var barcode = $(this).val();
                var elem = document.getElementById ( "total_value" );
                var text = elem.innerHTML;
                var sum = parseInt(text, 10);
                // console.log(barcode); 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('buy.select') }}",
                    data: {
                        'flag': 'barcode',
                        'item': barcode
                    },
                    dataType: "json",
                    success: function (res) {
                        if (res.status == 'valid') {
                            console.log(res.row[0].name);
                            var item = res.row[0];
                            var total = sum + item.buy_price;
                            var content = '<tr class="my_tr">'+
                                '<td><input type="hidden" name="items_id[]" value="'+item.id+'">'+item.name+'</td>'+
                                '<td><input name="qty[]" data-val="1" id="qty" type="number" class="form-control" value="1"></td>'+
                                '<td><input name="buy_price[]" data-val="'+item.buy_price+'" id="buy_price" type="number" class="form-control" value="'+item.buy_price+'"</td>'+
                                '<td><button id= "btn_delete" data-id="'+item.id+'" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></td>'+    
                            '</tr>';
                            $('#my_table').find('tbody').append(content);
                            $('#total_value').html(total);
                            $('#barcode').val('');

                        } else {
                            alert('Data tidak ditemukan');
                        }
                    }
                });    
            }  
        });

        $('#my_table').on('click', '#btn_delete', function (e) {
            e.preventDefault();
            var elem = document.getElementById ( "total_value" );
            var text = elem.innerHTML;
            var sum = parseInt(text, 10);
            var qty = $(this).parents('.my_tr').find('#qty').val();
            var buy_price = $(this).parents('.my_tr').find('#buy_price').val();
            var total = sum - (qty*buy_price);

            $('#total_value').html(total);
            $(this).parents('.my_tr').remove();
        });

        $('#my_table').on('change', '#qty', function (e) {
            e.preventDefault();
            var elem = document.getElementById ( "total_value" );
            var text = elem.innerHTML;
            var sum = parseInt(text, 10);
            var prev_qty = $(this).data("val");
            var qty = $(this).parents('.my_tr').find('#qty').val();
            var buy_price = $(this).parents('.my_tr').find('#buy_price').val();
            var diff = qty-prev_qty;
            var total = sum+(buy_price*diff);

            if (qty <= 0) {
                alert('Jumlah barang yang dimasukkan harus lebih dari 0!');
            } else {
                $('#total_value').html(total);
                $(this).data("val",qty);
            }
            console.log(qty);
            console.log(prev_qty);

        });

        $('#my_table').on('change', '#buy_price', function (e) {
            e.preventDefault();
            var elem = document.getElementById ( "total_value" );
            var text = elem.innerHTML;
            var sum = parseInt(text, 10);
            var prev_buy_price = $(this).data("val");
            var qty = $(this).parents('.my_tr').find('#qty').val();
            var buy_price = $(this).parents('.my_tr').find('#buy_price').val();
            var diff = buy_price-prev_buy_price;
            var total = sum+(qty*diff);
            if (buy_price == 0) {
                alert('Harga barang yang dimasukkan harus lebih dari 0!');
            } else {
                $('#total_value').html(total);
                $(this).data("val",buy_price);
            }

            console.log(qty);
            console.log(buy_price);
            console.log(prev_buy_price);

        });
        
        
    });

    $('#reset').click(function (e){
            $('.my_tr').remove();
            $('#suplier_id').select2('val', '0');
            $('#total_value').html(0);
            $('.detail').html('--');
        });

    $('#suplier_id').change(function (e) { 
        e.preventDefault();
        var suplier_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "{{ route('buy.select') }}",
            data: {
                'flag': 'suplier',
                'suplier_id': suplier_id
            },
            dataType: "json",
            success: function (res) {
                if (res) {
                    // console.log(res.suplier.name);
                    $('#suplier_name').html(res.suplier.name);
                    $('#suplier_phone').html(res.suplier.phone);
                    $('#suplier_address').html(res.suplier.address);
                } else {
                    alert('Data tidak ditemukan');
                }
            }
        });
    });

   

    
    
    


</script>
@endsection

@section('footer')

@endsection
