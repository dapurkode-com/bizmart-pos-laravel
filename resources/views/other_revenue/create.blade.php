@extends('adminlte::page')

@section('title', 'Tambah Pendapatan Baru')

@section('content_header')
<div class="row mb-2">
	<div class="col-sm-6">
		<blockquote style="margin: 0; background: unset;">
            <h1 class="m-0 text-dark">Tambah Pendapatan Baru</h1>
        </blockquote>
	</div>
	<!-- /.col -->
	<div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="{{ route('other_revenue.index') }}">Pendapatan Lainnya</a>
            </li>
			<li class="breadcrumb-item active">Buat Baru</li>
		</ol>
	</div>
	<!-- /.col -->
</div>
@stop

@section('content')
<form action="{{ route('other_revenue.store') }}" method="post" id="formRevenue">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card" id="items">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">Detail Pendapatan Lainnya</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6"><input required type="text" name="description[]" placeholder="Deskripsi" class="form-control"></div>
                        <div class="col-5"><input required type="number" min="0" name="amount[]" placeholder="Nominal" class="form-control"></div>
                        <div class="col-1"><button class="btn btn-sm btn-danger removeItem" type="button" ><i class="fas fa-minus fa-fw"></i></button></div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-sm btn-info btn" type="button" id="addItem"><i class="fas fa-plus fa-fw"></i> Tambah</button>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">Info Pendapatan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="username">Dibuat oleh</label>
                        {!! Form::text('username', auth()->user()->username, ['readonly'=> true, 'id'=> 'username', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="note">Catatan</label>
                        {!! Form::textarea('note', null, ['id'=> 'note', 'class' => 'form-control', 'rows'=>5]) !!}
                    </div>
                </div>
                <div class="card-footer text-right">
                    {!! Form::submit("Simpan", ['class'=> 'btn btn-warning' ]) !!}
                </div>
            </div>
        </div>
    </div>
</form>
@stop

@section('js')
<script>
    $(document).ready( function () {
        $('#addItem').click(function () {
            $('#items > .card-body').append(`
                <div class="row mb-2">
                    <div class="col-6"><input required type="text" name="description[]" placeholder="Deskripsi" class="form-control"></div>
                    <div class="col-5"><input required type="number" min="0" name="amount[]" placeholder="Nominal" class="form-control"></div>
                    <div class="col-1"><button class="btn btn-sm btn-danger removeItem" type="button" ><i class="fas fa-minus fa-fw"></i></button></div>
                </div>
            `)
        })
        $('#items').on('click', '.removeItem', function () {
            console.log('coba');
            $(this).closest('.row').remove();
        })
        let frm = $('#formRevenue')
        frm.on('submit', function (e) {
            e.preventDefault()
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                dataType: 'json',
                success: function (response) {
                    swalAlert('Berhasil', 'success')
                    setTimeout(() => {  window.location.href = '{{ route('other_revenue.index') }}' }, 2000)
                },
                error: function (response) {
                    swalAlert("Gagal menyimpan", 'error')
                    console.log(response.responseText)
                }
            });
        })
        function swalAlert(content, type){
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: content,
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }
    })
</script>
@stop
