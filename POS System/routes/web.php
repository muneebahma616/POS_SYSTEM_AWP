<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesmanController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchasesController;
// use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\OtherExpansesController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CommonActivityMiddleware;
use App\Http\Middleware\SalesmanMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Controller::class, 'loginpage']);

Route::post('login', [SalesmanController::class, 'login']);

Route::post('/signin', [Controller::class, 'signin']);

Route::middleware([SalesmanMiddleware::class])->group(function () {
  Route::get('/show', [SalesController::class, 'showw']);
  Route::get('/changepassword/{id}', [SalesmanController::class, 'changePassword']);
});

Route::middleware([AdminMiddleware::class])->group(function () {
  Route::get('/returnPurchase/{id}', [PurchasesController::class, 'return']);
  Route::get('/return/{id}', [SalesController::class, 'return']);
  Route::get('/delete/{uuid}', [SalesmanController::class, 'destroy']);
  Route::get('/purchase', [PurchasesController::class, 'index']);
  Route::get('/paid/{uuid}', [SalesmanController::class, 'paid']);
  Route::get('/editsalesdone/{id}', [SalesController::class, 'editsalesdone']);
  Route::get("/submitpurchase", [PurchasesController::class, 'store']);
  Route::get('otherexpenses', [OtherExpansesController::class, 'store']);
  Route::get('addsalesman', [SalesmanController::class, 'store']);
  Route::get('/edit/{uuid}', [SalesmanController::class, 'edit']);
  Route::get('/editsales/{id}', [SalesController::class, 'edit']);
  Route::get('/resetPassword/{uuid}', [SalesmanController::class, 'resetPassword']);
  Route::get('/admin', [Controller::class, 'showadmin']);
});

Route::middleware([CommonActivityMiddleware::class])->group(function () {
  Route::get('/invoice', [SalesmanController::class, 'invoice']);
  Route::get("/submitsales", [SalesController::class, 'store']);
  Route::get("/printInvoice/{uuid?}/{record?}", [SalesController::class, 'print']);
});

// Route::get('/addEmptyRecord', [InventoryController::class, 'store']);
