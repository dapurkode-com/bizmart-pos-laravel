@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Penjualan</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Penjualan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- main content -->
    <div class="row mainContent">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Daftar Retur</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button class="btn btn-info btnAdd" title="Tambah Data"><i class="fas fa-plus mr-2"></i>Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tbIndex" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Tgl</th>
                                <th>Uniq ID</th>
                                <th>Suplier</th>
                                <th>Total</th>
                                <th>Oleh</th>
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

@section('css')
    <style>
        /* navbar */
        ul.navbar-nav li.nav-item.active{
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            background: #0079fa;
            border-radius: .25rem;
        }
        ul.navbar-nav li.nav-item.active a.nav-link{
            color: white;
            padding-right: 16px;
            padding-left: 16px;
        }
        /* end navbar */
    </style>
@stop

@section('js')
    <script>
        
    </script>
@stop
