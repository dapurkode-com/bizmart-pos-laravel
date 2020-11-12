<?php

use App\SystemParam;
use Illuminate\Support\Facades\Route;
use Dompdf\Dompdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home');

Auth::routes(
    //    [
    //        'register' => false, // Registration Routes...
    //        'reset' => false, // Password Reset Routes...
    //        'verify' => false, // Email Verification Routes...
    //    ]
);




Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('suplier/datatables', 'SuplierController@datatables')->name('suplier.datatables');
    Route::get('buy/datatables', 'BuyController@datatables')->name('buy.datatables');
    Route::get('buy/datatablesReport', 'BuyController@datatablesReport')->name('buy.datatables_report');
    Route::get('buy/datatablesReportDetail', 'BuyController@datatablesReportDetail')->name('buy.datatables_report_detail');
    Route::post('buy/select', 'BuyController@select')->name('buy.select');
    Route::get('buy/print_report/{uniq_id}', 'BuyController@printReport')->name('buy.print_report');
    Route::get('buy/pdf_report/{uniq_id}', 'BuyController@generatePdfReport')->name('buy.pdf_report');
    Route::get('member/datatables', 'MemberController@datatables')->name('member.datatables');
    Route::get('item/datatables', 'ItemController@datatables')->name('item.datatables');
    Route::get('unit/datatables', 'UnitController@datatables')->name('unit.datatables');
    Route::get('category/datatables', 'CategoryController@datatables')->name('category.datatables');
    Route::get('user/datatables', 'UserController@datatables')->name('user.datatables');
    Route::get('user/get_privilege_code', 'UserController@getPrivilegeCode')->name('user.get_privilege_code');

    // for opname
    Route::get('opname/datatables', 'OpnameController@datatables')->name('opname.datatables');
    Route::get('opname/datatablesOpnameDetail', 'OpnameController@datatablesOpnameDetail')->name('opname.datatables_opname_detail');
    Route::get('opname/get_items', 'OpnameController@getItems')->name('opname.get_items');
    Route::get('opname/show_opname_detail/{id}', 'OpnameController@showOpnameDetail')->name('opname.show_opname_detail');
    Route::post('opname/store_opname_detail', 'OpnameController@storeOpnameDetail')->name('opname.store_opname_detail');
    Route::post('opname/store_stock_log', 'OpnameController@storeStockLog')->name('opname.store_stock_log');
    // for opname

    // for sell
    Route::get('sell/datatables', 'SellController@datatables')->name('sell.datatables');
    Route::get('sell/get_items', 'SellController@getItems')->name('sell.get_items');
    Route::get('sell/get_members', 'SellController@getMembers')->name('sell.get_members');
    Route::get('sell/generate_pdf/{id}', 'SellController@generatePdf')->name('sell.generate_pdf');
    // for sell

    // for sell_payment_hs
    Route::get('sell_payment_hs/datatables', 'SellPaymentHsController@datatables')->name('sell_payment_hs.datatables');
    // for sell_payment_hs

    // for sell_payment_hs
    Route::get('buy_payment_hs/datatables', 'BuyPaymentHsController@datatables')->name('buy_payment_hs.datatables');
    // for sell_payment_hs

    // for return item
    Route::get('return_item/datatables', 'ReturnItemController@datatables')->name('return_item.datatables');
    Route::get('return_item/get_suppliers', 'ReturnItemController@getSuppliers')->name('return_item.get_suppliers');
    Route::get('return_item/get_items', 'ReturnItemController@getItems')->name('return_item.get_items');
    Route::post('return_item/validate_add_item', 'ReturnItemController@validateAddItem')->name('return_item.validate_add_item');
    Route::get('return_item/generate_pdf/{id}', 'ReturnItemController@generatePdf')->name('return_item.generate_pdf');
    // for return item

    // for sell report
    Route::get('sell_report/get_total_transaction', 'SellReportController@getTotalTransaction')->name('sell_report.get_total_transaction');
    Route::get('sell_report/get_total_income_now', 'SellReportController@getTotalIncomeNow')->name('sell_report.get_total_income_now');
    Route::get('sell_report/get_total_piutang', 'SellReportController@getTotalPiutang')->name('sell_report.get_total_piutang');
    Route::get('sell_report/get_total_income', 'SellReportController@getTotalIncome')->name('sell_report.get_total_income');
    Route::get('sell_report/income_datatables', 'SellReportController@incomeDatatables')->name('sell_report.income_datatables');
    Route::get('sell_report/piutang_datatables', 'SellReportController@piutangDatatables')->name('sell_report.piutang_datatables');
    Route::get('sell_report/item_datatables', 'SellReportController@itemDatatables')->name('sell_report.item_datatables');
    Route::get('sell_report/member_datatables', 'SellReportController@memberDatatables')->name('sell_report.member_datatables');
    // for sell report

    Route::resource('unit', 'UnitController')->only('index', 'store', 'update', 'show', 'destroy');
    Route::resource('category', 'CategoryController')->only('index', 'store', 'update', 'show', 'destroy');
    Route::resource('buy', 'BuyController')->only('index', 'store', 'create', 'show', 'destroy');

    Route::get('other_revenue/datatables', 'OtherRevenueController@datatables')->name('other_revenue.datatables');
    Route::get('other_expense/datatables', 'OtherExpenseController@datatables')->name('other_expense.datatables');

    // for buy report
    Route::get('buy_report/get_total_transactions', 'BuyReportController@getTotalTransactions')->name('buy_report.get_total_transactions');
    Route::get('buy_report/get_current_expend', 'BuyReportController@getCurrentExpend')->name('buy_report.get_current_expend');
    Route::get('buy_report/get_overall_dept', 'BuyReportController@getOverallDept')->name('buy_report.get_overall_dept');
    Route::get('buy_report/get_estimated_total_expend', 'BuyReportController@getEstimatedTotalExpend')->name('buy_report.get_estimated_total_expend');
    Route::get('buy_report/item_datatables', 'BuyReportController@itemDatatables')->name('buy_report.item_datatables');
    Route::get('buy_report/expend_datatables', 'BuyReportController@expendDatatables')->name('buy_report.expend_datatables');
    Route::get('buy_report/dept_datatables', 'BuyReportController@deptDatatables')->name('buy_report.dept_datatables');
    Route::get('buy_report/suplier_datatables', 'BuyReportController@suplierDatatables')->name('buy_report.suplier_datatables');

    Route::get('cashflow', 'CashflowController@index')->name('cashflow');

    Route::get('item_report/item_datatables','ItemReportController@itemDatatables')->name('item_report.item_datatables');

    Route::resources([
        'suplier' => 'SuplierController',
        'member' => 'MemberController',
        'item'  => 'ItemController',
        'user' => 'UserController',
        'opname' => 'OpnameController',
        'sell' => 'SellController',
        'return_item' => 'ReturnItemController',
        'buy_payment_hs' => 'BuyPaymentHsController',
        'sell_payment_hs' => 'SellPaymentHsController',
        'other_revenue' => 'OtherRevenueController',
        'other_expense' => 'OtherExpenseController',
        'sell_report' => 'SellReportController',
        'buy_report' => 'BuyReportController',
        'sell_report' => 'SellReportController',
        'item_report' => 'ItemReportController',
    ]);
});
