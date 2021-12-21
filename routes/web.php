<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>false]);

Route::get('menu', 'HomeController@menu'); 
Broadcast::routes();
//created by Ashish
Route::prefix('api/mobile')->group(function () {


	Route::post('login', 'Api\HomeController@login');
	Route::get('customer_category', 'Api\UserController@customer_category'); //get lists of customer category
	Route::post('user_select', 'Api\UserController@user_select'); //get lists of customer according to user type
	Route::get('all_table_select', 'Api\TableController@all_table_select'); //get lists of tables
	Route::get('all_item_select', 'Api\ItemController@all_item_select'); //get lists of items
	Route::post('get_selected_items', 'Api\ItemController@get_selected_item'); //get lists of items
	Route::post('pre_order_store', 'Api\PreOrderController@store'); //store menu items in pre_order before confirming order
	Route::post('get_pre_order', 'Api\PreOrderController@get_pre_order'); //get pre_order by sending table_id
	Route::post('store_order', 'Api\OrderController@store_order'); //get pre_order by sending table_id
	Route::post('get_review_order_billId', 'Api\ReviewController@get_review_order_billId'); //get lists of order for review
	
	
	Route::get('get_bill_id', 'Api\ReviewController@get_bill_id'); // get list of bill id for spinner in android
	
	Route::get('get_table_list', 'Api\ReviewController@get_table_list'); //get table list from order_details table

	Route::post('store_review_order', 'Api\ReviewController@store_review_order');

	Route::post('get_bill_from_table', 'Api\ReviewController@get_bill_from_table'); //get bill id while selecting table in android

	Route::post('deletePreOrderItems', 'Api\PreOrderController@deletePreOrderItems'); //delete pre_order list

	Route::post('get_tablewise_Order','Api\OrderController@get_tablewise_Order'); //get order accordingt to table

	Route::get('get_waiter_log','Api\OrderController@get_waiter_log'); //get waiter's order according to today's date from order_detail table

	Route::post('get_waiter_log_details','Api\OrderController@get_waiter_log_details');

	Route::post('change_password','Api\HomeController@change_password');//change pass
	
	Route::post('items_from_category','Api\ItemController@items_from_category');//change pass


	//Online CUSTOMER
	Route::post('register', 'Api\Customer\UserController@register');

	Route::post('storeCart', 'Api\Customer\CartController@storeCart');
	
	Route::get('get_cart_items', 'Api\Customer\CartController@get_cart_items');

	Route::post('deleteCartItems', 'Api\Customer\CartController@deleteCartItems');

	Route::post('customer_store_order', 'Api\Customer\CustomerOrderController@customer_store_order');
	
	//category list
	Route::get('get_category', 'Api\CategoryController@get_category');

	Route::post('get_menu_from_category', 'Api\ItemController@get_menu_from_category');

	
});

Route::group(["middleware" => 'admin'], function(){
  // home routes
  Route::get('/home/activitylog', 'Admin\ActivityLogController@index');
  Route::get('/home/report','Admin\Report\HomeController@loadDashboard');

  Route::resource('/home/setting','Admin\SettingController');
  Route::get('home/fiscalyear/select/getAllFiscalYear', 'Admin\FiscalYearController@getAllFiscalYear');
  Route::resource('home/fiscalyear','Admin\FiscalYearController');
  Route::get('/home/fiscalyear/status/{id}/{status}', 'Admin\FiscalYearController@status');

  Route::resource('home/configure','Admin\ConfigureController');

	Route::get('/home', 'Admin\HomeController@index')->name('home');
	Route::get('/home/dashboard','Admin\HomeController@loadDashboard');
	Route::get('/home/billsetting','Admin\SettingController@billsetting');
	Route::post('/home/user-type/search', 'Admin\UsertypeController@index');
	Route::post('/home/user-type/store', 'Admin\UsertypeController@store');
	Route::post('/home/user-type/{id}', 'Admin\UsertypeController@update');
	Route::get('/home/user-type/delete/{id}', 'Admin\UsertypeController@delete');
	Route::get('/home/user-type/status/{id}/{status}', 'Admin\UsertypeController@status');
	Route::get('/home/user-type/salary/{id}/{status}', 'Admin\UsertypeController@salary');
	Route::get('/home/usertypeList', 'Admin\UsertypeController@all_usertype_select');
	Route::get('/home/sellerusertypeList', 'Admin\UsertypeController@all_sellerusertype_select');
  //customer category buyer and seller
	Route::resource('/home/customer/buyer','Admin\CustomerBuyerController');
	Route::get('/home/customer/buyer/status/{id}/{status}', 'Admin\CustomerBuyerController@status');
	Route::get('/home/customer/buyer/salary/{id}/{status}', 'Admin\CustomerBuyerController@salary');
	Route::resource('/home/customer/seller','Admin\CustomerSellerController');
	Route::get('/home/customer/seller/status/{id}/{status}', 'Admin\CustomerSellerController@status');
	Route::get('/home/customer/seller/salary/{id}/{status}', 'Admin\CustomerSellerController@salary');

	// Route::get('/home/user/{id}/show','Admin\UserController@show');
	Route::get('/home/userList', 'Admin\UserController@all_user_select');
	Route::get('/home/buyerList', 'Admin\UserController@all_user_buyer_select');

	// category routes
	Route::resource('/home/category/buying','Admin\CategoryBuyingController');
	Route::get('/home/category/buying/status/{id}/{status}', 'Admin\CategoryBuyingController@status');
	Route::resource('/home/category/selling','Admin\CategorySellingController');
	Route::get('/home/category/selling/status/{id}/{status}', 'Admin\CategorySellingController@status');
	Route::resource('/home/testcategory','Admin\TestCategoryController');
	Route::get('/home/categoryList', 'Admin\CategoryController@all_category_select');
	Route::get('/home/buyercategoryList', 'Admin\CategoryController@all_categorybuyer_select');
	Route::get('/home/buyercategoryListAll', 'Admin\CategoryController@all_categorybuyer');

	Route::get('/home/sellercategoryListAll', 'Admin\CategoryController@all_categoryseller');

	// unit routes
	Route::resource('/home/unit','Admin\UnitsController');
	Route::get('/home/unitList', 'Admin\UnitsController@all_unit_select');
	
	// table routes
	Route::resource('/home/table','Admin\TableController');
	Route::get('/home/tableList', 'Admin\TableController@all_table_select');


	// item routes
	Route::resource('/home/item','Admin\ItemController');
	Route::get('/home/item/status/{id}/{status}', 'Admin\ItemController@status');
	Route::get('/home/itemList', 'Admin\ItemController@all_item_select');

	// order routes
	Route::resource('/home/order','Admin\OrderController');
	Route::get('/home/order/{id}/preview','Admin\OrderController@bill');

	// confirm routes
	Route::get('/home/confirm/print/{id}','Admin\ConfirmController@printStatus');
	Route::resource('/home/confirm','Admin\ConfirmController');
	Route::get('/home/confirm/{id}/preview','Admin\ConfirmController@bill');
	Route::get('/home/confirm/{id}/show','Admin\ConfirmController@orderbill');
	Route::get('/home/confirm/status/{id}', 'Admin\ConfirmController@status');

	// review routes
	Route::resource('/home/review','Admin\ReviewController');
	Route::get('/home/review/{id}/preview','Admin\ReviewController@bill');
	Route::get('/home/befreview/{id}/preview','Admin\ReviewController@befbill');

	// stock routes
	Route::resource('/home/stock','Admin\StockController');
	Route::get('/home/stock/status/{id}/{status}', 'Admin\StockController@status');
	
	Route::get('/home/asset','Admin\AssetController@index');
	Route::get('/home/asset/status/{id}/{status}', 'Admin\AssetController@status');

	// package routes
	Route::resource('/home/package','Admin\PackageController');
	Route::get('/home/package/status/{id}/{status}', 'Admin\PackageController@status');
	Route::get('/home/packageList', 'Admin\PackageController@all_package_select');
	Route::get('/home/spcialuserpackage', 'Admin\PackageController@special_user_package_select');

	Route::resource('/home/user/package','Admin\UserPackageController');
	Route::resource('/home/user/salary','Admin\UserSalaryController');

	// income topic
	Route::resource('/home/income/topic','Admin\IncomeTopicController');
	Route::get('/home/incometopicList', 'Admin\IncomeTopicController@all_incometopic_select');
	// income
	Route::resource('/home/income','Admin\IncomeController');

	//room
	Route::resource('/home/room','Admin\RoomController');

	// expense topic
	Route::resource('/home/expense/topic','Admin\ExpenseTopicController');
	Route::get('/home/expensetopicList', 'Admin\ExpenseTopicController@all_expensetopic_select');
	// expense
	Route::resource('/home/expense','Admin\ExpenseController');

	// salary routes
	Route::resource('/home/salary','Admin\SalaryController');
	Route::get('/home/userSalaryList', 'Admin\UserController@all_user_salary_select');

	Route::resource('/home/month','Admin\MonthController');

	// report part
	Route::get('/home/report/sales/export','Admin\Report\SalesController@fileExport');
	Route::resource('/home/report/sales','Admin\Report\SalesController');

	Route::get('/home/report/purchases/export','Admin\Report\PurchasesController@fileExport');
	Route::resource('/home/report/purchases','Admin\Report\PurchasesController');

	Route::get('/home/report/items/export','Admin\Report\ItemsController@fileExport');
	Route::resource('/home/report/items','Admin\Report\ItemsController');

	Route::get('/home/report/stocks/export','Admin\Report\StocksController@fileExport');
	Route::resource('/home/report/stocks','Admin\Report\StocksController');

	Route::get('/home/report/kitchen-stocks','Admin\Report\KitchenStocksController@index');
	Route::get('/home/report/kitchen-stocks/export','Admin\Report\KitchenStocksController@fileExport');

	Route::get('/home/purchase/list','Admin\PurchaseListsController@index');

	Route::resource('/home/report/counter','Admin\Report\CounterController');

	Route::resource('/home/report/waiter','Admin\Report\WaiterController');
	// report ends
	// visitor-order routes
	Route::resource('/home/visitor-order','Admin\VisitorOrderController');
	Route::get('/home/visitor-order/{id}/preview','Admin\VisitorOrderController@bill');

	// manager routes
	Route::resource('/home/manager','Admin\ManagerController');
	Route::get('/home/manager/status/{id}/{status}', 'Admin\ManagerController@status');
	Route::get('/home/managerList', 'Admin\ManagerController@all_manager_select');
	Route::get('/home/counterList', 'Admin\ManagerController@all_counter_select');
  //waiter ko list ho
	Route::get('/home/waiterList', 'Admin\ManagerController@all_waiter_select');
	
	// user routes
	Route::resource('/home/customer','Admin\UserController');

	// change password
	Route::post('/home/change-password/submit','Admin\HomeController@changePassword');

	Route::resource('/home/report/customer/seller','Admin\Report\CustomerDetailController');
	Route::get('/home/report/customer/pay','Admin\Report\CustomerController@pay');

	Route::get('/home/report/customer/export','Admin\Report\CustomerDetailController@fileExport');
	Route::resource('/home/report/customer','Admin\Report\CustomerController');

	Route::get('/home/report/overall/export','Admin\Report\OverallController@fileExport');
	Route::resource('/home/report/overall','Admin\Report\OverallController');

	Route::get('/home/report/asset','Admin\Report\AssetController@index');
	Route::get('/home/report/asset/export','Admin\Report\AssetController@fileExport');

	Route::resource('/home/report/daybook','Admin\Report\DaybookController');

	Route::get('/home/report/incomereport/export','Admin\Report\IncomeReportController@fileExport');
	Route::resource('/home/report/incomereport','Admin\Report\IncomeReportController');

	Route::get('/home/report/expensereport/export','Admin\Report\ExpenseReportController@fileExport');
	Route::resource('/home/report/expensereport','Admin\Report\ExpenseReportController');

	Route::get('/home/report/roomreport/export','Admin\Report\RoomReportController@fileExport');
	Route::resource('/home/report/roomreport','Admin\Report\RoomReportController');

	Route::get('/home/stock/{id}/out/list','Admin\PurchaseListsController@stockoutlist');

	// report part
	Route::get('/home/report/bill/export','Admin\Report\BillController@fileExport');
	Route::resource('/home/report/bill','Admin\Report\BillController');
	// Route::get('/home/customer/{id}','Admin\UserController@index');
	Route::post('/home/customer/{id}','Admin\UserController@store');
	Route::post('/home/customer/{id}/edit','Admin\UserController@edit');
	// Route::get('/home/customer/{id}/{sid}/edit','Admin\UserController@edit');
	// ,['parameters' => ['{sid}' => 'abc']]
});

Route::group(["middleware" => 'manager'], function(){
	// counter routes
	Route::resource('/manager/counter','Manager\CounterController');
	Route::get('/manager/counter/status/{id}/{status}', 'Manager\CounterController@status');

	Route::get('/manager/billsetting','Manager\SettingController@billsetting');
	Route::get('/manager/report','Manager\Report\HomeController@loadDashboard');
	
	// waiter routes
	Route::resource('/manager/waiter','Manager\WaiterController');
	Route::get('/manager/waiter/status/{id}/{status}', 'Manager\WaiterController@status');
	// bar routes
	Route::resource('/manager/bar','Manager\BarController');
	Route::get('/manager/bar/status/{id}/{status}', 'Manager\BarController@status');
		// kitchen routes
	Route::resource('/manager/kitchen','Manager\KitchenController');
	Route::get('/manager/kitchen/status/{id}/{status}', 'Manager\KitchenController@status');
	// manager routes
	Route::get('/manager', 'Manager\HomeController@index')->name('manager');
	Route::get('/manager/dashboard','Manager\HomeController@loadDashboard');
	Route::post('/manager/user-type/search', 'Manager\UsertypeController@index');
	//customer category buyer and seller
	Route::resource('/manager/customer/buyer','Manager\CustomerBuyerController');
	Route::get('/manager/customer/buyer/status/{id}/{status}', 'Manager\CustomerBuyerController@status');
	Route::get('/manager/customer/buyer/salary/{id}/{status}', 'Manager\CustomerBuyerController@salary');
	
	Route::resource('/manager/customer/seller','Manager\CustomerSellerController');
	Route::get('/manager/customer/seller/status/{id}/{status}', 'Manager\CustomerSellerController@status');
	Route::get('/manager/customer/seller/salary/{id}/{status}', 'Manager\CustomerSellerController@salary');

	Route::post('/manager/user-type/store', 'Manager\UsertypeController@store');
	Route::post('/manager/user-type/{id}', 'Manager\UsertypeController@update');
	Route::get('/manager/user-type/delete/{id}', 'Manager\UsertypeController@delete');
	Route::get('/manager/user-type/status/{id}/{status}', 'Manager\UsertypeController@status');
	Route::get('/manager/user-type/salary/{id}/{status}', 'Manager\UsertypeController@salary');
	Route::get('/manager/usertypeList', 'Manager\UsertypeController@all_usertype_select');
	Route::get('/manager/sellerusertypeList', 'Manager\UsertypeController@all_sellerusertype_select');

	Route::get('/manager/userList', 'Manager\UserController@all_user_select');
	Route::get('/manager/buyerList', 'Manager\UserController@all_user_buyer_select');

	// category routes
	Route::resource('/manager/category/buying','Manager\CategoryBuyingController');
	Route::get('/manager/category/buying/status/{id}/{status}', 'Manager\CategoryBuyingController@status');
	Route::resource('/manager/category/selling','Manager\CategorySellingController');
	Route::get('/manager/category/selling/status/{id}/{status}', 'Manager\CategorySellingController@status');
	Route::resource('/manager/category','Manager\CategoryController');
	Route::resource('/manager/testcategory','Manager\TestCategoryController');
	Route::get('/manager/category/status/{id}/{status}', 'Manager\CategoryController@status');
	Route::get('/manager/categoryList', 'Manager\CategoryController@all_category_select');
	Route::get('/manager/buyercategoryList', 'Manager\CategoryController@all_categorybuyer_select');
	Route::get('/manager/buyercategoryListAll', 'Manager\CategoryController@all_categorybuyer');

	Route::get('/manager/sellercategoryListAll', 'Manager\CategoryController@all_categoryseller');

	// unit routes
	Route::resource('/manager/unit','Manager\UnitsController');
	Route::get('/manager/unitList', 'Manager\UnitsController@all_unit_select');

	// income topic
	Route::resource('/manager/income/topic','Manager\IncomeTopicController');
	Route::get('/manager/incometopicList', 'Manager\IncomeTopicController@all_incometopic_select');
	// income
	Route::resource('/manager/income','Manager\IncomeController');

	//room
	Route::resource('/manager/room','Manager\RoomController');

	// expense topic
	Route::resource('/manager/expense/topic','Manager\ExpenseTopicController');
	Route::get('/manager/expensetopicList', 'Manager\ExpenseTopicController@all_expensetopic_select');
	// expense
	Route::resource('/manager/expense','Manager\ExpenseController');

	// table routes
	Route::resource('/manager/table','Manager\TableController');
	Route::get('/manager/tableList', 'Manager\TableController@all_table_select');


	// item routes
	Route::get('/manager/item/export','Manager\ItemController@fileExport');
	Route::resource('/manager/item','Manager\ItemController');
	Route::get('/manager/item/{id}/addimage','Manager\ItemController@viewImage');
	Route::post('/manager/item/addimage/store', 'Manager\ItemController@addImage');
	Route::delete('/manager/item/destroyimage/{id}','Manager\ItemController@destroyimage');
	Route::get('/manager/item/status/{id}/{status}', 'Manager\ItemController@status');
	Route::get('/manager/itemList', 'Manager\ItemController@all_item_select');
	Route::get('/manager/itemListReady', 'Manager\ItemController@all_item_select_ready');

	// order routes
	Route::resource('/manager/order','Manager\OrderController');
	Route::get('/manager/order/{id}/preview','Manager\OrderController@bill');

	// confirm routes
	Route::get('/manager/confirm/print/{id}','Manager\ConfirmController@printStatus');
	Route::resource('/manager/confirm','Manager\ConfirmController');
	Route::get('/manager/confirm/{id}/preview','Manager\ConfirmController@bill');
	Route::get('/manager/confirm/{id}/show','Manager\ConfirmController@orderbill');
	Route::get('/manager/confirm/status/{id}', 'Manager\ConfirmController@status');

	// review routes
	Route::resource('/manager/review','Manager\ReviewController');
	Route::get('/manager/review/{id}/preview','Manager\ReviewController@bill');
	Route::get('/manager/befreview/{id}/preview','Manager\ReviewController@befbill');

	// stock routes
	Route::resource('/manager/stock','Manager\StockController');
	Route::get('/manager/stock/status/{id}/{status}', 'Manager\StockController@status');
	// purchase list routes

	Route::get('/manager/purchase/list','Manager\PurchaseListsController@index');
	Route::post('/manager/purchase/list/store','Manager\PurchaseListsController@store');

	Route::get('/manager/stock/{id}/out','Manager\PurchaseListsController@stock_out');
	Route::get('/manager/stock/out/{id}/list','Manager\PurchaseListsController@stock_outlist');
	// stock routes
	Route::resource('/manager/asset','Manager\AssetController');
	Route::get('/manager/asset/status/{id}/{status}', 'Manager\AssetController@status');

	Route::resource('/manager/vendor','Manager\VendorController');
	Route::get('/manager/vendor/status/{id}/{status}', 'Manager\VendorController@status');

	Route::resource('/manager/vendorasset','Manager\VendorAssetController');
	Route::get('/manager/vendorasset/status/{id}/{status}', 'Manager\VendorAssetController@status');

	// package routes
	Route::resource('/manager/package','Manager\PackageController');
	Route::get('/manager/package/status/{id}/{status}', 'Manager\PackageController@status');
	Route::get('/manager/packageList', 'Manager\PackageController@all_package_select');
	Route::get('/manager/spcialuserpackage', 'Manager\PackageController@special_user_package_select');

	Route::resource('/manager/user/package','Manager\UserPackageController');
	Route::resource('/manager/user/salary','Manager\UserSalaryController');

	// salary routes
	Route::resource('/manager/salary','Manager\SalaryController');
	Route::get('/manager/userSalaryList', 'Manager\UserController@all_user_salary_select');

	Route::resource('/manager/month','Manager\MonthController');

	// visitor-order routes
	Route::resource('/manager/visitor-order','Manager\VisitorOrderController');
	Route::get('/manager/visitor-order/{id}/preview','Manager\VisitorOrderController@bill');
	
	// user routes
	Route::resource('/manager/customer','Manager\UserController');

	// change password
	Route::post('/manager/change-password/submit','Manager\HomeController@changePassword');

	// report part
	Route::get('/manager/report/sales/export','Manager\Report\SalesController@fileExport');
	Route::resource('/manager/report/sales','Manager\Report\SalesController');
	
	Route::get('/manager/report/purchases/export','Manager\Report\PurchasesController@fileExport');
	Route::resource('/manager/report/purchases','Manager\Report\PurchasesController');

	Route::get('/manager/report/asset','Manager\Report\AssetController@index');
	Route::get('/manager/report/asset/export','Manager\Report\AssetController@fileExport');

	Route::get('/manager/report/stocks/export','Manager\Report\StocksController@fileExport');
	Route::resource('/manager/report/stocks','Manager\Report\StocksController');

	Route::get('/manager/report/kitchen-stocks','Manager\Report\KitchenStocksController@index');
	Route::get('/manager/report/kitchen-stocks/export','Manager\Report\KitchenStocksController@fileExport');
	
	Route::resource('/manager/report/daybook','Manager\Report\DaybookController');

	Route::get('/manager/report/items/export','Manager\Report\ItemsController@fileExport');
	Route::resource('/manager/report/items','Manager\Report\ItemsController');

	Route::resource('/manager/report/customer/seller','Manager\Report\CustomerDetailController');
	Route::get('/manager/report/customer/pay','Manager\Report\CustomerController@pay');
	
	Route::get('/manager/report/customer/export','Manager\Report\CustomerDetailController@fileExport');
	Route::resource('/manager/report/customer','Manager\Report\CustomerController');

	Route::get('/manager/report/overall/export','Manager\Report\OverallController@fileExport');
	Route::resource('/manager/report/overall','Manager\Report\OverallController');

	Route::get('/manager/report/incomereport/export','Manager\Report\IncomeReportController@fileExport');
	Route::resource('/manager/report/incomereport','Manager\Report\IncomeReportController');

	Route::get('/manager/report/expensereport/export','Manager\Report\ExpenseReportController@fileExport');
	Route::resource('/manager/report/expensereport','Manager\Report\ExpenseReportController');




});

Route::group(["middleware" => 'counter'], function(){
	// counter routes
	Route::get('/counter', 'Counter\HomeController@index')->name('counter');
	Route::get('/counter/dashboard','Counter\HomeController@loadDashboard');

	Route::get('/counter/billsetting','Counter\SettingController@billsetting');
	Route::post('/counter/user-type/search', 'Counter\UsertypeController@index');
	Route::post('/counter/user-type/store', 'Counter\UsertypeController@store');
	Route::post('/counter/useruser-type/{id}', 'Counter\UsertypeController@update');
	Route::get('/counter/user-type/delete/{id}', 'Counter\UsertypeController@delete');
	Route::get('/counter/user-type/status/{id}/{status}', 'Counter\UsertypeController@status');
	Route::get('/counter/user-type/salary/{id}/{status}', 'Counter\UsertypeController@salary');
	Route::get('/counter/usertypeList', 'Counter\UsertypeController@all_usertype_select');
	Route::get('/counter/sellerusertypeList', 'Counter\UsertypeController@all_sellerusertype_select');

	Route::get('/counter/userList', 'Counter\UserController@all_user_select');
	Route::get('/counter/buyerList', 'Counter\UserController@all_user_buyer_select');

	// category routes
	Route::get('/counter/category/buying','Counter\CategoryBuyingController@index');
	Route::get('/counter/category/selling','Counter\CategorySellingController@index');
	Route::resource('/counter/category','Counter\CategoryController');
	Route::resource('/counter/testcategory','Counter\TestCategoryController');
	Route::get('/counter/category/status/{id}/{status}', 'Counter\CategoryController@status');
	Route::get('/counter/categoryList', 'Counter\CategoryController@all_category_select');
	Route::get('/counter/buyercategoryList', 'Counter\CategoryController@all_categorybuyer_select');
	Route::get('/counter/buyercategoryListAll', 'Counter\CategoryController@all_categorybuyer');

	// unit routes
	Route::get('/counter/unit','Counter\UnitsController@index');
	Route::get('/counter/unitList', 'Counter\UnitsController@all_unit_select');

	// table routes
	Route::get('/counter/table','Counter\TableController@index');
	Route::get('/counter/tableList', 'Counter\TableController@all_table_select');


	// item routes
	Route::get('/counter/item/export','Counter\ItemController@fileExport');
	Route::get('/counter/item','Counter\ItemController@index');
	Route::get('/counter/item/status/{id}/{status}', 'Counter\ItemController@status');
	Route::get('/counter/itemList', 'Counter\ItemController@all_item_select');
	Route::get('/counter/itemListReady', 'Counter\ItemController@all_item_select_ready');

	// order routes
	Route::resource('/counter/order','Counter\OrderController');
	Route::get('/counter/order/retrievecustomer/{id}','Counter\OrderController@retrievecustomer');
	Route::get('/counter/order/{id}/preview','Counter\OrderController@bill');
	Route::get('/counter/order/{id}/preview/bar','Counter\OrderController@bar');

	// confirm routes
	Route::get('/counter/confirm/print/{id}','Counter\ConfirmController@printStatus');
	Route::resource('/counter/confirm','Counter\ConfirmController');
	Route::get('/counter/confirm/{id}/preview','Counter\ConfirmController@bill');
	Route::get('/counter/confirm/status/{id}', 'Counter\ConfirmController@status');

	// review routes
	Route::resource('/counter/review','Counter\ReviewController');
	Route::get('/counter/review/{id}/preview','Counter\ReviewController@bill');
	Route::get('/counter/befreview/{id}/preview','Counter\ReviewController@befbill');

	// stock routes
	Route::resource('/counter/stock','Counter\StockController');
	Route::get('/counter/stock/status/{id}/{status}', 'Counter\StockController@status');

	// package routes
	Route::resource('/counter/package','Counter\PackageController');
	Route::get('/counter/package/status/{id}/{status}', 'Counter\PackageController@status');
	Route::get('/counter/packageList', 'Counter\PackageController@all_package_select');
	Route::get('/counter/spcialuserpackage', 'Counter\PackageController@special_user_package_select');

	Route::resource('/counter/user/package','Counter\UserPackageController');

	// salary routes
	Route::resource('/counter/salary','Counter\SalaryController');
	Route::get('/counter/userSalaryList', 'Counter\UserController@all_user_salary_select');

	Route::resource('/counter/month','Counter\MonthController');

	// visitor-order routes
	Route::resource('/counter/visitor-order','Counter\VisitorOrderController');
	Route::get('/counter/visitor-order/{id}/preview','Counter\VisitorOrderController@bill');
	
	// user routes
	Route::get('/counter/customer','Counter\UserController@index');

	//checkin
	Route::resource('/counter/checkin','Counter\CheckInController');
	Route::post('/counter/checkin/checkout', 'Counter\CheckInController@checkout');
	Route::get('/counter/checkin/status/{id}/{status}', 'Counter\CheckInController@status');
	Route::get('/counter/checkout/confirm', 'Counter\CheckInController@all_customer_check');
	Route::post('/counter/checkout/savedetail', 'Counter\CheckInController@savedetail');
	Route::get('/counter/customerList', 'Counter\CheckInController@all_customer_select');

	Route::get('/counter/roomList','Counter\RoomController@all_room_select');


	// change password
	Route::post('/counter/change-password/submit','Counter\HomeController@changePassword');

	// report part
	Route::get('/counter/report/sales/export','Counter\Report\SalesController@fileExport');
	Route::resource('/counter/report/sales','Counter\Report\SalesController');

	Route::get('/counter/report/items/export','Counter\Report\ItemsController@fileExport');
	Route::resource('/counter/report/items','Counter\Report\ItemsController');

	Route::resource('/counter/report/customer/seller','Counter\Report\CustomerDetailController');
	Route::get('/counter/report/customer/pay','Counter\Report\CustomerController@pay');
	
	Route::get('/counter/report/customer/export','Counter\Report\CustomerDetailController@fileExport');
	Route::resource('/counter/report/customer','Counter\Report\CustomerController');

	Route::get('/counter/report/overall/export','Counter\Report\OverallController@fileExport');
	Route::resource('/counter/report/overall','Counter\Report\OverallController');

	// Route::get('/counter/customer/{id}','Counter\UserController@index');
	// Route::post('/counter/customer/{id}','Counter\UserController@store');
	// Route::get('/counter/customer/{id}/{sid}/edit','Counter\UserController@edit');
	// ,['parameters' => ['{sid}' => 'abc']]
});

Route::group(["middleware" => 'bar'], function(){
	// bar routes
	Route::get('/bar', 'Bar\HomeController@index')->name('bar');
	Route::get('/bar/dashboard','Bar\HomeController@loadDashboard');
	Route::get('/bar/billsetting','Kitchen\SettingController@billsetting');
	Route::post('/bar/user-type/search', 'Bar\UsertypeController@index');
	Route::post('/bar/user-type/store', 'Bar\UsertypeController@store');
	Route::post('/bar/useruser-type/{id}', 'Bar\UsertypeController@update');
	Route::get('/bar/user-type/delete/{id}', 'Bar\UsertypeController@delete');
	Route::get('/bar/user-type/status/{id}/{status}', 'Bar\UsertypeController@status');
	Route::get('/bar/user-type/salary/{id}/{status}', 'Bar\UsertypeController@salary');
	Route::get('/bar/usertypeList', 'Bar\UsertypeController@all_usertype_select');
	Route::get('/bar/sellerusertypeList', 'Bar\UsertypeController@all_sellerusertype_select');

	Route::get('/bar/userList', 'Bar\UserController@all_user_select');
	Route::get('/bar/buyerList', 'Bar\UserController@all_user_buyer_select');

	// category routes
	Route::get('/bar/category/buying','Bar\CategoryBuyingController@index');
	Route::get('/bar/category/selling','Bar\CategorySellingController@index');
	Route::resource('/bar/category','Bar\CategoryController');
	Route::resource('/bar/testcategory','Bar\TestCategoryController');
	Route::get('/bar/category/status/{id}/{status}', 'Bar\CategoryController@status');
	Route::get('/bar/categoryList', 'Bar\CategoryController@all_category_select');
	Route::get('/bar/buyercategoryList', 'Bar\CategoryController@all_categorybuyer_select');
	Route::get('/bar/buyercategoryListAll', 'Bar\CategoryController@all_categorybuyer');

	// unit routes
	Route::get('/bar/unit','Bar\UnitsController@index');
	Route::get('/bar/unitList', 'Bar\UnitsController@all_unit_select');

	// table routes
	Route::get('/bar/table','Bar\TableController@index');
	Route::get('/bar/tableList', 'Bar\TableController@all_table_select');


	// item routes
	Route::get('/bar/item/export','Bar\ItemController@fileExport');
	Route::get('/bar/item','Bar\ItemController@index');
	Route::get('/bar/item/status/{id}/{status}', 'Bar\ItemController@status');
	Route::get('/bar/itemList', 'Bar\ItemController@all_item_select');
	Route::get('/bar/itemListReady', 'Bar\ItemController@all_item_select_ready');

	// confirm routes
	Route::get('/bar/confirm/print/{id}','Bar\ConfirmController@printStatus');
	Route::resource('/bar/confirm','Bar\ConfirmController');
	Route::get('/bar/confirm/{id}/show','Bar\ConfirmController@orderbill');
	Route::get('/bar/confirm/status/{id}', 'Bar\ConfirmController@status');

	// stock routes
	Route::resource('/bar/stock','Bar\StockController');
	Route::get('/bar/stock/status/{id}/{status}', 'Bar\StockController@status');

	// package routes
	Route::resource('/bar/package','Bar\PackageController');
	Route::get('/bar/package/status/{id}/{status}', 'Bar\PackageController@status');
	Route::get('/bar/packageList', 'Bar\PackageController@all_package_select');
	Route::get('/bar/spcialuserpackage', 'Bar\PackageController@special_user_package_select');

	Route::resource('/bar/user/package','Bar\UserPackageController');
	Route::resource('/bar/user/salary','Bar\UserSalaryController');

	// salary routes
	Route::resource('/bar/salary','Bar\SalaryController');
	Route::get('/bar/userSalaryList', 'Bar\UserController@all_user_salary_select');

	Route::resource('/bar/month','Bar\MonthController');

	// visitor-order routes
	Route::resource('/bar/visitor-order','Bar\VisitorOrderController');
	Route::get('/bar/visitor-order/{id}/preview','Bar\VisitorOrderController@bill');
	
	// user routes
	Route::resource('/bar/customer','Bar\UserController');

	// change password
	Route::post('/bar/change-password/submit','Bar\HomeController@changePassword');
});

Route::group(["middleware" => 'kitchen'], function(){
	// kitchen routes
	Route::get('/kitchen', 'Kitchen\HomeController@index')->name('kitchen');
	Route::get('/kitchen/dashboard','Kitchen\HomeController@loadDashboard');
	Route::get('/kitchen/billsetting','Kitchen\SettingController@billsetting');
	Route::post('/kitchen/user-type/search', 'Kitchen\UsertypeController@index');
	Route::post('/kitchen/user-type/store', 'Kitchen\UsertypeController@store');
	Route::post('/kitchen/useruser-type/{id}', 'Kitchen\UsertypeController@update');
	Route::get('/kitchen/user-type/delete/{id}', 'Kitchen\UsertypeController@delete');
	Route::get('/kitchen/user-type/status/{id}/{status}', 'Kitchen\UsertypeController@status');
	Route::get('/kitchen/user-type/salary/{id}/{status}', 'Kitchen\UsertypeController@salary');
	Route::get('/kitchen/usertypeList', 'Kitchen\UsertypeController@all_usertype_select');
	Route::get('/kitchen/sellerusertypeList', 'Kitchen\UsertypeController@all_sellerusertype_select');

	Route::get('/kitchen/userList', 'Kitchen\UserController@all_user_select');
	Route::get('/kitchen/buyerList', 'Kitchen\UserController@all_user_buyer_select');

	// category routes
	Route::get('/kitchen/category/buying','Kitchen\CategoryBuyingController@index');
	Route::get('/kitchen/category/selling','Kitchen\CategorySellingController@index');
	Route::resource('/kitchen/category','Kitchen\CategoryController');
	Route::resource('/kitchen/testcategory','Kitchen\TestCategoryController');
	Route::get('/kitchen/category/status/{id}/{status}', 'Kitchen\CategoryController@status');
	Route::get('/kitchen/categoryList', 'Kitchen\CategoryController@all_category_select');
	Route::get('/kitchen/buyercategoryList', 'Kitchen\CategoryController@all_categorybuyer_select');
	Route::get('/kitchen/buyercategoryListAll', 'Kitchen\CategoryController@all_categorybuyer');

	// unit routes
	Route::get('/kitchen/unit','Kitchen\UnitsController@index');
	Route::get('/kitchen/unitList', 'Kitchen\UnitsController@all_unit_select');

	// table routes
	Route::get('/kitchen/table','Kitchen\TableController@index');
	Route::get('/kitchen/tableList', 'Kitchen\TableController@all_table_select');


	// item routes
	Route::get('/kitchen/item/export','Kitchen\ItemController@fileExport');
	Route::get('/kitchen/item','Kitchen\ItemController@index');
	Route::get('/kitchen/item/status/{id}/{status}', 'Kitchen\ItemController@status');
	Route::get('/kitchen/itemList', 'Kitchen\ItemController@all_item_select');
	Route::get('/kitchen/itemListReady', 'Kitchen\ItemController@all_item_select_ready');

	// confirm routes
	Route::get('/kitchen/confirm/print/{id}','Kitchen\ConfirmController@printStatus');
	Route::resource('/kitchen/confirm','Kitchen\ConfirmController');
	Route::get('/kitchen/confirm/{id}/show','Kitchen\ConfirmController@orderbill');
	Route::get('/kitchen/confirm/status/{id}', 'Kitchen\ConfirmController@status');

	// stock routes
	Route::resource('/kitchen/stock','Kitchen\StockController');
	Route::get('/kitchen/stock/status/{id}/{status}', 'Kitchen\StockController@status');

	// package routes
	Route::resource('/kitchen/package','Kitchen\PackageController');
	Route::get('/kitchen/package/status/{id}/{status}', 'Kitchen\PackageController@status');
	Route::get('/kitchen/packageList', 'Kitchen\PackageController@all_package_select');
	Route::get('/kitchen/spcialuserpackage', 'Kitchen\PackageController@special_user_package_select');

	Route::resource('/kitchen/user/package','Kitchen\UserPackageController');
	Route::resource('/kitchen/user/salary','Kitchen\UserSalaryController');

	// salary routes
	Route::resource('/kitchen/salary','Kitchen\SalaryController');
	Route::get('/kitchen/userSalaryList', 'Kitchen\UserController@all_user_salary_select');

	Route::resource('/kitchen/month','Kitchen\MonthController');

	// visitor-order routes
	Route::resource('/kitchen/visitor-order','Kitchen\VisitorOrderController');
	Route::get('/kitchen/visitor-order/{id}/preview','Kitchen\VisitorOrderController@bill');
	
	// user routes
	Route::resource('/kitchen/customer','Kitchen\UserController');

	// change password
	Route::post('/kitchen/change-password/submit','Kitchen\HomeController@changePassword');
});