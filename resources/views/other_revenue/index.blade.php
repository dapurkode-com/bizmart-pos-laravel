@extends('adminlte::page')

@section('title', 'Daftar Pendapatan Lainnya')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Daftar Pendapatan Lainnya</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Pendapatan Lainnya</li>
                <li class="breadcrumb-item active">List</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- main content -->
    <div class="row mainContent">
        <div class="col-sm-12">
            <div class="card bg-default">
                <div class="card-body">
                    <div class="sellTableFilter">
                        <div class="form-group mb-0">
                            <input type="date" name="date_start" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <p class="mb-0">sampai</p>
                        <div class="form-group mb-0">
                            <input type="date" name="date_end" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="button" class="btn btn-info filterButton"><i class="fas fa-search mr-2"></i>Cari</button>
                    </div>
                </div>
            </div>
            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Pendapatan Lainnya</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="sellTable" class="table table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Oleh</th>
                                <th>Total</th>
                                <th>Note</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop


@section('js')
    <script>

    </script>
@stop
