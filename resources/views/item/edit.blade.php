@extends('adminlte::page')

@section('title', 'Ubah Data Barang')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Ubah Data Barang</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('item.index') }}">Barang</a>
            </li>
			<li class="breadcrumb-item active">Ubah Data</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Ubah Data Barang</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('item.update', $item->slug) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <div class="input-group">
                                <input type="text" name="barcode" id="barcode" class="form-control {{ $errors->has('barcode') ? 'is-invalid' : '' }}" placeholder="Tulis barcode disini." value="{{ old('barcode', $item->barcode) }}" required>
                                <div class="input-group-append">
                                    <button id="randBarcode" class="btn btn-outline-secondary" type="button" data-toogle="tooltips" title="Generate barcode acak"><i class="fa fa-sync"></i></button>
                                </div>
                            </div>
                            @if ($errors->has('barcode'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('barcode') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Tulis nama disini." value="{{ old('name' , $item->name) }}" required >
                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('name') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="categories">Kategori</label>
                            <input type="text" data-role="tagsinput" name="categories" id="categories" class="form-control {{ $errors->has('categories') ? 'is-invalid' : '' }}" placeholder="Tulis kategori disini." value="{{ old('categories', $categories) }}" required >
                            @if ($errors->has('categories'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('categories') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Tulis deskripsi disini." cols="30" rows="5">{{ old('description', $item->description ) }}</textarea>
                            @if ($errors->has('description'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('description') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="is_stock_active">Barang Berstok</label>
                            <select name="is_stock_active" id="is_stock_active" class="form-control {{ $errors->has('is_stock_active') ? 'is-invalid' : '' }}" required>
                                <option value="" selected hidden disabled>--Pilih--</option>
                                @foreach ($options['STCK_ACTV'] as $option)
                                    <option value="{{ $option->key }}" {{ $option->key == old('is_stock_active', $item->is_stock_active) ? 'selected' : '' }}>{{ $option->label }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('is_stock_active'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('is_stock_active') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="min_stock">Jumlah Stok Minimum</label>
                                    <input type="number" name="min_stock" id="min_stock" class="form-control {{ $errors->has('min_stock') ? 'is-invalid' : '' }}" placeholder="Tulis jumlah stok minimum disini." min="0" value="{{ old('min_stock', $item->min_stock) }}">
                                    @if ($errors->has('min_stock'))
                                        <div class="invalid-feedback">
                                            <ul>
                                                @foreach ($errors->get('min_stock') as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="unit_id">Satuan</label>
                                    <select name="unit_id" id="unit_id" class="form-control {{ $errors->has('unit_id') ? 'is-invalid' : '' }}">
                                        <option value="" selected hidden disabled>--Pilih--</option>
                                        @foreach ($options['UNITS'] as $option)
                                            <option value="{{ $option->id }}" {{ $option->id == old('unit_id', $item->unit_id) ? 'selected' : '' }}>{{ $option->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('unit_id'))
                                        <div class="invalid-feedback">
                                            <ul>
                                                @foreach ($errors->get('unit_id') as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="buy_price">Harga Beli</label>
                            <input type="number" name="buy_price" id="buy_price" class="currency form-control {{ $errors->has('buy_price') ? 'is-invalid' : '' }}" placeholder="Tulis harga beli disini." value="{{ old('buy_price', $item->buy_price) }}" required min="0">
                            @if ($errors->has('buy_price'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('buy_price') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="sell_price_determinant">Penentu harga</label>
                            <select name="sell_price_determinant" id="sell_price_determinant" class="form-control {{ $errors->has('sell_price_determinant') ? 'is-invalid' : '' }}" required>
                                <option value="" selected hidden disabled>--Pilih--</option>
                                @foreach ($options['SLL_PRC_DTRM'] as $option)
                                    <option value="{{ $option->key }}" {{ $option->key == old('sell_price_determinant', $item->sell_price_determinant) ? 'selected' : '' }}>{{ $option->label }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('sell_price_determinant'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('sell_price_determinant') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="sell_price">Harga Jual</label>
                            <input  {{ $item->sell_price_determinant!=0?'disabled':'' }} type="number" name="sell_price" id="sell_price" class="currency form-control {{ $errors->has('sell_price') ? 'is-invalid' : '' }}" placeholder="Tulis harga jual disini." value="{{ old('sell_price', $item->sell_price) }}" min="0">
                            @if ($errors->has('sell_price'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('sell_price') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profit">Profit</label>
                                    <input {{ $item->sell_price_determinant != 3 ? 'disabled' : '' }} type="number" name="profit" id="profit" class="currency form-control {{ $errors->has('profit') ? 'is-invalid' : '' }}" placeholder="Tulis profit disini." value="{{ old('profit' , $item->profit) }}" min="0">
                                    @if ($errors->has('profit'))
                                        <div class="invalid-feedback">
                                            <ul>
                                                @foreach ($errors->get('profit') as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="margin">Margin</label>
                                    <input {{ $item->sell_price_determinant != 1 ? 'disabled' : '' }} type="number" name="margin" id="margin" class="form-control {{ $errors->has('margin') ? 'is-invalid' : '' }}" placeholder="Tulis margin disini." value="{{ old('margin', $item->margin) }}" min="0">
                                    @if ($errors->has('margin'))
                                        <div class="invalid-feedback">
                                            <ul>
                                                @foreach ($errors->get('margin') as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="markup">Markup</label>
                                    <input {{ $item->sell_price_determinant != 2 ? 'disabled' : '' }} type="number" name="markup" id="markup" class="form-control {{ $errors->has('markup') ? 'is-invalid' : '' }}" placeholder="Tulis markup disini." value="{{ old('markup', $item->markup) }}" min="0">
                                    @if ($errors->has('markup'))
                                        <div class="invalid-feedback">
                                            <ul>
                                                @foreach ($errors->get('markup') as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ url('plugins/bootstrap-tagsinput/tagsinput.css') }}">
@endsection

@section('js')
<script src="{{ url('plugins/bootstrap-tagsinput/tagsinput.js') }}"></script>
<script src="{{ url('plugins/jquery-mask/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function () {
        $('select#unit_id').select2();

        $('#randBarcode').on('click', function () {
            var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
            var string_length = 15;
            var randomstring = '';
            for (var i=0; i<string_length; i++) {
                var rnum = Math.floor(Math.random() * chars.length);
                randomstring += chars.substring(rnum,rnum+1);
            }

            $('#barcode').val(randomstring)
        })

        $('#sell_price_determinant').on('change', function () {
            $('#sell_price').prop('disabled', false);
            $('#profit').prop('disabled', false);
            $('#markup').prop('disabled', false);
            $('#margin').prop('disabled', false);

            switch ($(this).val()) {
                case '0':
                        $('#profit').prop('disabled', true);
                        $('#markup').prop('disabled', true);
                        $('#margin').prop('disabled', true);
                    break;

                case '1':
                        $('#profit').prop('disabled', true);
                        $('#markup').prop('disabled', true);
                        $('#sell_price').prop('disabled', true);
                    break;

                case '2':
                        $('#profit').prop('disabled', true);
                        $('#sell_price').prop('disabled', true);
                        $('#margin').prop('disabled', true);
                    break;

                case '3':
                        $('#sell_price').prop('disabled', true);
                        $('#markup').prop('disabled', true);
                        $('#margin').prop('disabled', true);
                    break;

                default:
                    break;
            }
        })
    })
</script>
@endsection
