@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-12">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </blockquote>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                <i class="fa fa-info-circle"></i> Hai, {{ auth()->user()->name }}! Semoga harimu menyenangkan !
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $badge_data['count_today_sell'] }}</h3>
                    <p>Penjualan Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{{ route('sell.index') }}" class="small-box-footer">Lihat selengkapnya<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $badge_data['count_today_buy'] }}</h3>
                    <p>Pembelian Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fa fa-truck"></i>
                </div>
                <a href="{{ route('buy.index') }}" class="small-box-footer">Lihat selengkapnya<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $badge_data['count_today_receiveable'] }}</h3>
                    <p>Piutang dari Konsumen</p>
                </div>
                <div class="icon">
                    <i class="fa fa-sticky-note"></i>
                </div>
                <a href="{{ route('sell_payment_hs.index') }}" class="small-box-footer">Lihat selengkapnya<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $badge_data['count_today_debt'] }}</h3>
                    <p>Hutang pada Suplier</p>
                </div>
                <div class="icon">
                    <i class="fa fa-donate"></i>
                </div>
                <a href="{{ route('buy_payment_hs.index') }}" class="small-box-footer">Lihat selengkapnya<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header"> Penjualan Mingguan
                </h5>
                <div class="card-body">
                    {!! $chartWeekly->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header"> Penjualan Bulanan
                </h5>
                <div class="card-body">
                    {!! $chartMonthly->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header"> Barang Terlaris Bulan Ini
                </h5>
                <div class="card-body">
                    {!! $chartBestSeller->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header"> Barang Terbanyak Retur Bulan Ini
                </h5>
                <div class="card-body">
                    {!! $chartMostRetur->container() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card-deck">
                <div class="card">
                    <h5 class="card-header">Barang dengan stok minim
                    </h5>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($minItemStock as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>< {{ $item->min_stock }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">Pembelian Terakhir
                    </h5>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Suplier</th>
                                    <th>Status</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse ($lastBuy as $buy)
                                    <tr>
                                        <td>{{ $buy->suplier->name }}</td>
                                        <td>{{ $buy->statusText() }}</td>
                                        <td class="text-right">{{ number_format($buy->summary) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">Penjualan Terakhir
                    </h5>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Status</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lastSell as $sell)
                                    <tr>
                                        <td>{{ $sell->member->name }}</td>
                                        <td>{{ $sell->statusText() }}</td>
                                        <td class="text-right">{{ number_format($sell->summary) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
{!! $chartWeekly->script() !!}
{!! $chartMonthly->script() !!}
{!! $chartBestSeller->script() !!}
{!! $chartMostRetur->script() !!}
@stop
