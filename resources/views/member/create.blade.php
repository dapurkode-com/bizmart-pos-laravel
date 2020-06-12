@extends('adminlte::page')

@section('title', 'Tambah Member Baru')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<h1 class="m-0 text-dark">Member</h1>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('member.index') }}">Member</a>
            </li>
			<li class="breadcrumb-item active">Buat Baru</li>
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
                    <h3 class="card-title">Form Tambah Member Baru</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Tulis nama member disini." value="{{ old('name') }}" required autocomplete="off">
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
                            <label for="address">Alamat</label>
                            <input type="text" name="address" id="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" placeholder="Tulis alamat member disini." value="{{ old('address') }}" autocomplete="off">
                            @if ($errors->has('address'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('address') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="phone">Kontak</label>
                            <input type="text" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" placeholder="Tulis kontak member disini." value="{{ old('phone') }}" autocomplete="off">
                            @if ($errors->has('phone'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('phone') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
