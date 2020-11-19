@extends('adminlte::page')

@section('title', 'Pengaturan Profile')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Pengaturan Profile</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
			<li class="breadcrumb-item active">Pengaturan Profile</li>
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
                    <h3 class="card-title">Profile Anda</h3>
                </div>
                <div class="card-body">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            {!! \Session::get('success') !!}
                        </div>
                    @endif
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" disabled class="form-control"value="{{ auth()->user()->username }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" disabled class="form-control" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" disabled class="form-control" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="form-group">
                            <label for="old_password">Kata Sandi Lama</label>
                            <input type="password" name="old_password" id="old_password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" placeholder="Kata sandi lama" >
                            @if ($errors->has('old_password'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('old_password') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="new_password">Kata Sandi Baru</label>
                            <input type="password" name="new_password" id="new_password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" placeholder="Kata sandi baru" >
                            @if ($errors->has('new_password'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('new_password') as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" placeholder="Konfirmasi kata sandi baru" >
                            @if ($errors->has('new_password_confirmation'))
                                <div class="invalid-feedback">
                                    <ul>
                                        @foreach ($errors->get('new_password_confirmation') as $message)
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
