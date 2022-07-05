<?php


use Illuminate\Support\Facades\Artisan;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/logout', "Auth\AuthenticationController@logout")->name("auth.logout");
Route::get('/login', "Auth\AuthenticationController@showLogin")->name("auth.login");
Route::post('/login', "Auth\AuthenticationController@login")->name("auth.login.post");

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    return back();
});
Route::prefix('/backup')->group(function(){
   Route::get('/db', function(){
       Artisan::call('backup:run --only-db');
//       Artisan::call('backup:run --only-files');
       return back();
   });
});

Route::middleware(['auth:web'])->group(function(){
    Route::prefix('/')->group(function () {
        //welcome page
//        Route::get('/', function(){ return view('welcome'); })->name("welcome");
        Route::get('/', 'DashboardController@index')->name("welcome");
        Route::get('/back', function(){
            return back();
        })->name("back");
        Route::get('/afasfasdfad', function(){ return view('asss'); })->name("forms.dashboard");

        Route::prefix('/forms')->group(function(){
            Route::get('/dashboard', 'DashboardController@forms')->name('dashboard');

            Route::get('/meal-allowances', 'FormMealAllowanceController@index')->name('forms.meal_allowances.index');
            Route::post('/meal-allowances', 'FormMealAllowanceController@store')->name('forms.meal_allowances.store');
            Route::get('/meal-allowances/create', 'FormMealAllowanceController@create')->name('forms.meal_allowances.create');
            Route::get('/meal-allowances/{mealAllowance}', 'FormMealAllowanceController@show')->name('forms.meal_allowances.show');
            Route::delete('/meal-allowances/{mealAllowance}', 'FormMealAllowanceController@destroy')->name('forms.meal_allowances.destroy');

            Route::get('/housing-allowances', 'FormHousingAllowanceController@index')->name('forms.housing_allowances.index');
            Route::post('/housing-allowances', 'FormHousingAllowanceController@store')->name('forms.housing_allowances.store');
            Route::get('/housing-allowances/create', 'FormHousingAllowanceController@create')->name('forms.housing_allowances.create');
            Route::get('/housing-allowances/{mealAllowance}', 'FormHousingAllowanceController@show')->name('forms.housing_allowances.show');
            Route::delete('/housing-allowances/{mealAllowance}', 'FormHousingAllowanceController@destroy')->name('forms.housing_allowances.destroy');

            Route::get('/meal-allowances', 'FormMealAllowanceController@index')->name('forms.meal_allowances.index');
            Route::post('/meal-allowances', 'FormMealAllowanceController@store')->name('forms.meal_allowances.store');
            Route::get('/meal-allowances/create', 'FormMealAllowanceController@create')->name('forms.meal_allowances.create');
            Route::get('/meal-allowances/{mealAllowance}', 'FormMealAllowanceController@show')->name('forms.meal_allowances.show');
            Route::delete('/meal-allowances/{mealAllowance}', 'FormMealAllowanceController@destroy')->name('forms.meal_allowances.destroy');

            Route::get('/meal-allowances', 'FormMealAllowanceController@index')->name('forms.meal_allowances.index');
            Route::post('/meal-allowances', 'FormMealAllowanceController@store')->name('forms.meal_allowances.store');
            Route::get('/meal-allowances/create', 'FormMealAllowanceController@create')->name('forms.meal_allowances.create');
            Route::get('/meal-allowances/{mealAllowance}', 'FormMealAllowanceController@show')->name('forms.meal_allowances.show');
            Route::delete('/meal-allowances/{mealAllowance}', 'FormMealAllowanceController@destroy')->name('forms.meal_allowances.destroy');

        });

        Route::get('/sync/local', 'SyncTableController@local')->name('sync.local');
        Route::get('/dashboard','DashboardController@index')->name('dashboard');
        Route::get('/branches','BranchController@index')->name('branch.index');
//    Route::prefix('/branches')->group(function () {
//
//    });
        Route::prefix('/branch')->group(function () {
            Route::get('/show/{id}', "UserController@show")->name("branch.single");
            Route::post('/destroy/{id}', "BranchController@destroy")->name("branch.destroy");
            Route::post('/store', "BranchController@store")->name("branch.store");
            Route::get('/d', "BranchController@departments")->name("branch.departments");
            Route::get('/', "UserController@index")->name("branch.department");
        });
        Route::prefix('/group')->group(function () {
            Route::get('/show/{id}', "GroupController@show")->name("group.single");
            Route::post('/destroy/{id}', "GroupController@destroy")->name("group.destroy");
            Route::post('/store', "GroupController@store")->name("group.store");
            Route::post('/user/destroy/{user_id}/{group_id}', "GroupController@userDestroy")->name("group.user.destroy");
            Route::post('/user/add/', "GroupController@addUser")->name("group.user.add");
            Route::get('/', "GroupController@index")->name("group.index");
        });
        Route::prefix('/role')->group(function () {
            Route::get('/permissions/{id}', "RoleController@permissions")->name("role.permissions");
            Route::post('/permission/assign', "RoleController@permissionsAssign")->name("role.permission.assign");
            Route::get('/show/{id}', "RoleController@show")->name("role.show");
            Route::post('/destroy/{id}', "RoleController@destroy")->name("role.destroy");
            Route::post('/store', "RoleController@store")->name("role.store");
            Route::get('/list/{user}', "RoleController@lister")->name("role.list");
            Route::get('/assign/{action}/{role}/{user}', "RoleController@assign")->name("role.assign");
            Route::get('/', "RoleController@index")->name("role.index");
        });

        Route::prefix('postition')->group(function () {
            Route::get('/show/{id}', "PositionController@show")->name("position.show");
            Route::post('/destroy/{id}', "PositionController@destroy")->name("position.destroy");
            Route::post('/store', "PositionController@store")->name("position.store");
            Route::get('/', "PositionController@index")->name("position.index");
        });

        Route::prefix('department')->group(function () {
            Route::get('/show/{id}', "DepartmentController@show")->name("department.show");
            Route::post('/destroy/{id}', "DepartmentController@destroy")->name("department.destroy");
            Route::post('/store', "DepartmentController@store")->name("department.store");
            Route::get('/', "DepartmentController@index")->name("department.index");
        });

        Route::prefix('messages')->group(function(){
            Route::get('/', 'MessageController@index')->name('messages.index');
            Route::post('/', 'MessageController@store')->name('messages.store');
            Route::delete('/{message}', 'MessageController@destroy')->name('messages.destroy');
        });

        Route::prefix('expenditure_codes')->group(function(){
            Route::get('/', 'ExpenditureCodeController@index')->name('expenditure_codes.index');
            Route::post('/', 'ExpenditureCodeController@store')->name('expenditure_codes.store');
            Route::get('/select2Ajax', 'ExpenditureCodeController@select2Ajax')->name('expenditure_codes.select2Ajax');
        });

        Route::prefix('newsfeed')->group(function(){
            Route::get('/', 'NewsfeedController@index')->name('newsfeed.index');
            Route::post('/', 'NewsfeedController@store')->name('newsfeed.store');
        });

        Route::prefix('backup')->group(function(){
            Route::get('/', 'BackupController@index')->name('backup.index');
//            Route::post('/', 'NewsfeedController@store')->name('backup.store');
        });

        Route::prefix('memos')->group(function () {
            Route::get('/show/{id}', "MemoController@show")->name("memos.show");
            Route::post('/store', "MemoController@store")->name("memos.store");
            Route::get('/create', "MemoController@create")->name("memos.create");
            Route::get('/destroy/{id}', "MemoController@create")->name("memos.destroy");
            Route::get('/', "MemoController@index")->name("memos.index");
            Route::post('/minute', 'MinuteController@store')->name('memos.minute.store');
            Route::get('/minute/cancel/{minute}', 'MinuteController@cancel')->name('memos.minute.cancel');
            Route::get('/print/{id}', 'MemoController@memoPrint')->name('memos.print');
            Route::get('/ringing', 'MemoController@ringing')->name('memos.ringing');
            Route::get('/archive/{memo}', 'MemoController@archive')->name('memos.archive');
            Route::get('/archived', 'MemoController@archived')->name('memos.archived');
            Route::post('/draft', 'MemoController@deleteDraft')->name('memos.draft.destroy');

            //approvals
            Route::get('/approvals', 'MemoController@approvals')->name('memos.approvals');

            Route::get('/all/{param}', 'MemoController@all')->name('memos.all');
	        Route::get('/search/{param}', 'MemoController@search')->name('memos.search');
	        Route::get('/filter', 'MemoController@memoFilter')->name('memos.filter.index');
	        Route::post('/filter', 'MemoController@memoFilterSearch')->name('memos.filter.search');

            //payment process
	        Route::get('/approve-status', 'MemoController@approveStatus')->name('memos.approve-status');
            Route::post('/payment-process', 'MemoController@paymentProcess')->name('memos.payment_process');
            Route::get('/payment-process/{memo}', 'MemoController@cancelPaymentProcess')->name('memos.cancel_payment_process');
            Route::post('/payment-auditor', 'MemoController@paymentProcess')->name('memos.payment-auditor');

            Route::get('/new', 'MemoController@newMemos')->name('memos.new');
            Route::get('/sent', 'MemoController@sentMemos')->name('memos.sent');
            Route::get('/received', 'MemoController@receivedMemos')->name('memos.received');
            Route::get('/test', 'MemoController@testMemos')->name('memos.test');
            Route::get('/kiv/{memo}', 'MemoController@kiv')->name('memos.kiv');
        });

	    Route::prefix('vehicles')->group(function () {
	        Route::get('/', 'VehicleController@index')->name('vehicles.index');
	        Route::post('/', 'VehicleController@store')->name('vehicles.store');
	        Route::get('/show/{vehicle}', 'VehicleController@show')->name('vehicles.show');
	        Route::delete('/{vehicle}', 'VehicleController@delete')->name('vehicles.delete');
	    });

        Route::prefix('activities')->group(function(){
            Route::get('/', 'ActivityLogController@index')->name('activities.index');
        });

        Route::prefix('forms')->group(function(){
            Route::get('/create', 'FormsController@create')->name('forms.create');
            Route::post('/retirement', 'MemoController@storeRetirementForm')->name('forms.store_retirements');
        });

        Route::prefix('reports')->group(function(){
           Route::get('/', 'ReportController@index')->name('reports.index');
           Route::post('/', 'ReportController@loadReports')->name('reports.load');
        });

        Route::prefix('manage')->group(function(){
            Route::get('/','ManageController@index')->name('manage');

            Route::prefix('/users')->group(function () {
                Route::get('/', "UserController@index")->name("users.index");
                Route::get('/show/{id}', "UserController@show")->name("users.show");
                Route::get('/create', "UserController@create")->name("users.create");
                Route::post('/store', "UserController@store")->name("users.store");
                Route::get('/edit/{id}', "UserController@edit")->name("users.edit");
                Route::put('/update/{user}', "UserController@update")->name("users.update");
                Route::post('/signature/store', "UserController@signature")->name("users.signature.store");
                Route::post('/password/reset', "UserController@passwordReset")->name("users.password.reset");
                Route::post('/delete/{id}', "UserController@destroy")->name("users.destroy");
                Route::get('/profile/image/{id}', "UserController@profileImg")->name("users.profile.img");
                Route::get('/search/{type}', "UserController@search")->name("users.search");
                Route::get('/search/{type}/user', "UserController@searchAll")->name("users.search.user");
                Route::get('/status/{user}', "UserController@userStatus")->name("users.status");

            });

        });

        Route::prefix('vehicles')->group(function () {
            Route::get('/', 'VehicleController@index')->name('vehicles.index');
            Route::get('/create', 'VehicleController@create')->name('vehicles.create');
            Route::post('/', 'VehicleController@store')->name('vehicles.store');
            Route::get('/profile/{vehicle}', 'VehicleController@show')->name('vehicles.show');
            Route::delete('/{vehicle}', 'VehicleController@destroy')->name('vehicles.destroy');
            Route::get('/select2/search', 'VehicleController@select2Search')->name('vehicles.select2.search');
            Route::get('/forms/{vehicle}', 'VehicleController@forms')->name('vehicles.forms.create');

            Route::prefix('dispatches')->group(function(){
               Route::get('/', 'DispatchController@index')->name('vehicles.dispatch.index');
               Route::get('/', 'DispatchController@show')->name('vehicles.dispatch.show');
            });

            //configuration
            Route::prefix('configurations')->group(function(){
                Route::get('/', 'VehicleConfigurationController@index')->name('vehicles.configurations.index');
                Route::post('/', 'VehicleConfigurationController@store')->name('vehicles.configurations.store');
                Route::delete('/{configuration}', 'VehicleConfigurationController@destroy')->name('vehicles.configurations.destroy');
            });

            //dispatch
            Route::get('/dispatch/close/{dispatch}', 'VehicleController@closeDispatch')->name('vehicles.dispatches.close');

            Route::prefix('drivers')->group(function(){
                Route::post('/{vehicle}', 'VehicleController@changeDriver')->name('vehicles.driver.change');
            });

            Route::prefix('/locations')->group(function(){
                Route::get('/','LocationController@index')->name('vehicles.location.index');
                Route::post('/','LocationController@store')->name('vehicles.location.store');
                Route::delete('/{location}','LocationController@destroy')->name('vehicles.location.destroy');
            });

            Route::prefix('/routes')->group(function(){
                Route::get('/','RouteController@index')->name('vehicles.route.index');
                Route::post('/','RouteController@store')->name('vehicles.route.store');
                Route::delete('/{route}','RouteController@destroy')->name('vehicles.route.destroy');
            });

            Route::prefix('/location-route')->group(function(){
                Route::get('/','LocationRouteController@index')->name('vehicles.location_route.index');
                Route::post('/','LocationRouteController@store')->name('vehicles.location_route.store');
                Route::delete('/{locationRoute}','LocationRouteController@destroy')->name('vehicles.location_route.destroy');
            });

            Route::prefix('/fuel-price')->group(function(){
                Route::get('/','FuelPriceController@index')->name('vehicles.fuel_price.index');
                Route::post('/','FuelPriceController@store')->name('vehicles.fuel_price.store');
                Route::delete('/{fuelPrice}','FuelPriceController@destroy')->name('vehicles.fuel_price.destroy');
            });
        });

        Route::prefix('inventory')->group(function(){
            Route::prefix('/purchases')->group(function(){
                Route::get('/', 'InventoryPurchaseController@index')->name('inventory.purchases.index');
                Route::post('/', 'InventoryPurchaseController@store')->name('inventory.purchases.store');
                Route::delete('/{purchase}', 'InventoryPurchaseController@destroy')->name('inventory.purchases.destroy');
            });

            Route::prefix('/customers')->group(function(){
                Route::get('/', 'InventoryCustomerController@index')->name('inventory.customers.index');
                Route::post('/', 'InventoryCustomerController@store')->name('inventory.customers.store');
                Route::delete('/{customer}', 'InventoryCustomerController@destroy')->name('inventory.customers.destroy');
            });

            Route::prefix('/suppliers')->group(function(){
                Route::get('/', 'InventorySupplierController@index')->name('inventory.suppliers.index');
                Route::post('/', 'InventorySupplierController@store')->name('inventory.suppliers.store');
                Route::delete('/{supplier}', 'InventorySupplierController@destroy')->name('inventory.suppliers.destroy');
            });

            Route::prefix('/configurations')->group(function(){
               Route::prefix('items')->group(function(){
                   Route::get('/', 'InventoryItemController@index')->name('inventory.configurations.items.index');
                   Route::post('/', 'InventoryItemController@store')->name('inventory.configurations.items.store');
                   Route::get('/create', 'InventoryItemController@create')->name('inventory.configurations.items.create');
                   Route::delete('/{item}', 'InventoryItemController@destroy')->name('inventory.configurations.items.destroy');
               });

                Route::prefix('/categories')->group(function(){
                    Route::get('/', 'InventoryCategoryController@index')->name('inventory.configurations.categories.index');
                    Route::post('/', 'InventoryCategoryController@store')->name('inventory.configurations.categories.store');
                    Route::delete('/{category}', 'InventoryCategoryController@destroy')->name('inventory.configurations.categories.destroy');
                });

                Route::prefix('/units')->group(function(){
                    Route::get('/', 'InventoryUnitController@index')->name('inventory.configurations.units.index');
                    Route::post('/', 'InventoryUnitController@store')->name('inventory.configurations.units.store');
                    Route::delete('/{unit}', 'InventoryUnitController@destroy')->name('inventory.configurations.units.destroy');
                });
            });
        });

        Route::prefix('hr')->group(function(){
           Route::prefix('/tasks')->group(function(){

               //task repository
               Route::get('/', 'HRTaskController@index')->name('hr.tasks.index');
               Route::get('/create', 'HRTaskController@create')->name('hr.tasks.create');
               Route::post('/', 'HRTaskController@store')->name('hr.tasks.store');
               Route::delete('/{task}', 'HRTaskController@destroy')->name('hr.tasks.destroy');

               //scheduling task to a particular staff
               Route::prefix('/schedules')->group(function(){
                   Route::get('/', 'HRTaskScheduleController@index')->name('hr.tasks.schedules.index');
                   Route::post('/', 'HRTaskScheduleController@store')->name('hr.tasks.schedules.store');
               });

               //mapping task with various units
               Route::prefix('mappings')->group(function(){
                   Route::get('/', 'HRTaskMappingController@index')->name('hr.tasks.mappings.index');
                   Route::post('/', 'HRTaskMappingController@store')->name('hr.tasks.mappings.store');
                   Route::get('/{unit}', 'HRTaskMappingController@unit')->name('hr.tasks.mappings.unit');
               });
           });
        });

        Route::prefix('accounting')->group(function(){

            Route::prefix('business-partners')->group(function(){
                Route::get('/', 'BusinessPartnerController@index')->name('accounting.business_partners.index');
                Route::post('/', 'BusinessPartnerController@store')->name('accounting.business_partners.store');
                Route::post('/create', 'BusinessPartnerController@create')->name('accounting.business_partners.create');
                Route::get('/{businessPartner}', 'BusinessPartnerController@show')->name('accounting.business_partners.show');
                Route::delete('/destroy/{businessPartner}', 'BusinessPartnerController@destroy')->name('accounting.business_partners.destroy');
            });

            Route::prefix('general-ledger')->group(function(){
                Route::get('/', 'GeneralLedgerController@index')->name('accounting.general_ledger.index');
                Route::post('/', 'GeneralLedgerController@store')->name('accounting.general_ledger.store');
                Route::get('/create', 'GeneralLedgerController@create')->name('accounting.general_ledger.create');
                Route::get('/{generalLedger}', 'GeneralLedgerController@show')->name('accounting.general_ledger.show');
                Route::delete('/destroy/{generalLedger}', 'GeneralLedgerController@destroy')->name('accounting.general_ledger.destroy');
            });

            Route::prefix('accounts')->group(function(){

            });

            Route::prefix('/receipts')->group(function(){
                Route::get('/', 'ReceiptController@index')->name('accounting.receipts.index');
                Route::get('/create', 'ReceiptController@create')->name('accounting.receipts.create');
            });

            Route::prefix('/invoices')->group(function(){
              Route::get('/', 'InvoiceController@index')->name('accounting.invoices.index');
                Route::get('/create', 'InvoiceController@create')->name('accounting.invoices.create');
                Route::post('/', 'InvoiceController@store')->name('accounting.invoices.store');
                Route::get('/configuration', 'InvoiceController@configuration')->name('accounting.invoices.configuration');
           });

            Route::prefix('/payments')->group(function(){
                Route::get('/', 'PaymentController@index')->name('accounting.payments.index');
                Route::get('/create', 'PaymentController@index')->name('accounting.receipts.create');
            });

            Route::prefix('/transactions')->group(function(){
                Route::post('/', 'TransactionController@store')->name('accounting.transactions.store');
                Route::post('/opening-balance', 'TransactionController@openingBalance')->name('accounting.transactions.opening-balance');
            });


            Route::get('/accounting.search-gl', 'AccountLedgerController@searchGl')->name('accounting.search-gl');
        });

        Route::prefix('payroll')->group(function(){

            Route::prefix('payment')->group(function(){
                Route::get('/', 'PayrollPaymentController@index')->name('payroll.payments.index');
                Route::post('/make-payment', 'PayrollPaymentController@makePayment')->name('payroll.payments.make-payment');

            });

            Route::prefix('salary')->group(function(){
                Route::prefix('sheet')->group(function(){
                    Route::get('/', 'PayrollController@salarySheet')->name('payroll.salary.sheet.index');
                    Route::post('/', 'PayrollController@branchSalarySheet')->name('payroll.salary.sheet.branch-salary-sheet');
                    Route::get('/bank', 'PayrollController@bankSheet')->name('payroll.salary.bank.index');
                    Route::post('/bank', 'PayrollController@bankSalarySheet')->name('payroll.salary.bank.branch-salary-bank');
                });

                Route::prefix('structure')->group(function(){
                    Route::get('/', 'PayrollSalaryStructureController@index')->name('payroll.salary.structure.index');
                    Route::post('/', 'PayrollSalaryStructureController@store')->name('payroll.salary.structure.store');
                    Route::delete('/{structure}', 'PayrollSalaryStructureController@destroy')->name('payroll.salary.structure.destroy');
                });

            });

            Route::prefix('allowances')->group(function(){
                Route::get('/', 'PayrollAllowanceController@index')->name('payroll.allowances.index');
                Route::post('/', 'PayrollAllowanceController@store')->name('payroll.allowances.store');
                Route::delete('/{allowance}', 'PayrollAllowanceController@destroy')->name('payroll.allowances.destroy');
            });
            Route::prefix('deductions')->group(function(){
                Route::get('/', 'PayrollDeductionController@index')->name('payroll.deductions.index');
                Route::post('/', 'PayrollDeductionController@store')->name('payroll.deductions.store');
                Route::delete('/{deduction}', 'PayrollDeductionController@destroy')->name('payroll.deductions.destroy');
            });
            Route::prefix('bonus')->group(function(){
                Route::get('/', 'PayrollSalaryStructureController@index')->name('payroll.bonus.index');
            });
            Route::prefix('loans')->group(function(){
                Route::get('/', 'PayrollSalaryStructureController@index')->name('payroll.loans.index');
            });

            Route::prefix('payslip')->group(function(){
                Route::get('/', 'PayrollPayslipController@index')->name('payroll.payslip.index');
                Route::get('/{month}/{user}', 'PayrollPayslipController@show')->name('payroll.payslip.show');
            });

            Route::prefix('paystub')->group(function(){
                Route::get('/', 'PayrollPaystubController@index')->name('payroll.paystub.index');
            });

            Route::prefix('staff')->group(function(){
                Route::get('/', 'PayrollController@payrollIndex')->name('payroll.staff.index');
                Route::post('/', 'PayrollController@addPayroll')->name('payroll.staff.store');
                Route::get('/show/{user}', 'PayrollController@showStaff')->name('payroll.staff.show');
                Route::delete('/{staff}', 'PayrollController@destroy')->name('payroll.staff.destroy');

                Route::get('/my-payslip', 'PayrollPayslipController@myPayrollShow')->name('payroll.staff.my-payslip');
                Route::get('/payslip/{month}/{user}', 'PayrollPayslipController@showPayslip')->name('payroll.staff.show-payslip');
            });

            Route::prefix('reports')->group(function(){
                Route::get('/', 'PayrollReportController@index')->name('payroll.reports.index');
                Route::match(['GET','POST'],'/items-summary', 'PayrollReportController@itemsSummary')->name('payroll.reports.items-summary');
                Route::match(['GET','POST'],'/items-per-staff', 'PayrollReportController@itemsPerStaff')->name('payroll.reports.items-per-staff');
                Route::match(['GET','POST'],'/staff-per-item', 'PayrollReportController@staffPerItem')->name('payroll.reports.staff-per-item');
            });

            Route::prefix('configurations')->group(function(){
                Route::get('items', 'PayrollConfigurationController@items')->name('payroll.configurations.items');
                Route::post('items', 'PayrollConfigurationController@itemsStore')->name('payroll.configurations.items.store');
            });

        });

        Route::prefix('staff')->group(function(){
           Route::get('/my-payslips', 'UserController@myPayslips')->name('staff.my-payslips.index');
        });

    });
});


