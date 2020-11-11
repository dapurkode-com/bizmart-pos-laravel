<?php

namespace App\Providers;

use App\BuyPaymentHs;
use App\Opname;
use Carbon\Carbon;
use App\ReturnItem;
use App\OtherExpense;
use App\OtherRevenue;
use App\SellPaymentHs;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        // Cashflow Observer
        SellPaymentHs::observe(\App\Observers\SellCashObserver::class);
        OtherRevenue::observe(\App\Observers\ORCashObserver::class);
        OtherExpense::observe(\App\Observers\OECashObserver::class);
        ReturnItem::observe(\App\Observers\ReturnItemCashObserver::class);
        Opname::observe(\App\Observers\OpnameCashObserver::class);
        BuyPaymentHs::observe(\App\Observers\BuyCashObserver::class);
    }
}
