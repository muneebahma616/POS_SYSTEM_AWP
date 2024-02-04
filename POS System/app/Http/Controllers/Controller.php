<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SalesmanController;
use App\Http\Controllers\SalesController; // Correct the use statement
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\leger;
use App\Models\OtherExpanses;
use App\Models\purchases;
use App\Models\sales;
use App\Models\salesman;
use App\Models\vender;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request; // Add this line
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  public function logout()
  {
    $previousPageUrl = url()->previous();
    if ($previousPageUrl == "http://127.0.0.1:8000/signin") {
      session()->forget('admin');
    } else if ($previousPageUrl == "http://127.0.0.1:8000/ControlPanel") {
      session()->forget('name');
    }
    return redirect("/");
  }

  public function loginpage(Request $request)
  {
    $request->session()->forget('admin');
    $request->session()->forget('salesman');
    return view('loginpage');
  }
  public function show(Request $request)
  {
    $salesman = session('salesman');

    return view("EmployeeScreen", compact('salesman'));
  }
  function updateSalaries()
  {
    $salesmen = Salesman::whereNotNull('salarypaiddate')->get();

    foreach ($salesmen as $salesman) {
      $daysDifference = Carbon::now()->diffInDays(Carbon::parse($salesman->salarypaiddate));

      if ($daysDifference >= 30) {
        // Update salary status and reset salarypaiddate
        $salesman->update([
          'salarystatus' => 'unpaid',
          'salarypaiddate' => null,
        ]);
        $salesman->save();
      }
    }
  }
  public function getVenders($uuid, $search, $startTime, $endTime)
  {
    $perPage = 10;
    $venderQuery = vender::query();

    // Add date constraints to OtherExpenses query
    if ($startTime && ($startTime == $endTime)) {
      $venderQuery->whereDate('created_at', '=', $startTime);
    } elseif ($startTime != $endTime) {
      $venderQuery->whereBetween('created_at', [$startTime . ' 00:00:00', $endTime . ' 23:59:59']);
    }

    // Add type constraint if filter is provided
    if ($search) {
      $venderQuery->where(function ($query) use ($search) {
        $query->where('venderName', 'like', '%' . $search . '%')
          ->orWhere('venderPhone', 'like', '%' . $search . '%');
      });
    }
    if ($uuid) {
      $venderQuery->where('uuid', $uuid);
    }

    $venders = $venderQuery->simplePaginate($perPage);
    return $venders;
  }
  public function getCustomers($uuid, $search, $startTime, $endTime)
  {
    $perPage = 10;
    $customerQuery = Customer::query();

    // Add date constraints to OtherExpenses query
    if ($startTime && ($startTime == $endTime)) {
      $customerQuery->whereDate('created_at', '=', $startTime);
    } elseif ($startTime != $endTime) {
      $customerQuery->whereBetween('created_at', [$startTime . ' 00:00:00', $endTime . ' 23:59:59']);
    }

    // Add type constraint if filter is provided
    if ($search) {
      $customerQuery->where(function ($query) use ($search) {
        $query->where('customerName', 'like', '%' . $search . '%')
          ->orWhere('customerPhone', 'like', '%' . $search . '%');
      });
    }
    if ($uuid) {
      $customerQuery->where('uuid', $uuid);
    }

    $customers = $customerQuery->simplePaginate($perPage);
    return $customers;
  }

  public function getTotalPurchaseAmount($startTime, $endTime, $payment_method = '')
  {
    $query = DB::table('purchases')
      ->where('returned', 0);

    if ($payment_method !== '') {
      $query->where('payment_method', 'like', '%' . $payment_method . '%');
    }

    if ($startTime && ($startTime == $endTime)) {
      $TotalPurchaseAmount = round(
        $query->whereDate('created_at', '=', $startTime)
          ->sum(DB::raw('total_price')),
        2
      );
    } else if ($startTime != $endTime) {
      $TotalPurchaseAmount = round(
        $query->whereBetween('created_at', [$startTime . ' 00:00:00', $endTime . ' 23:59:59'])
          ->sum(DB::raw('total_price')),
        2
      );
    } else {
      $TotalPurchaseAmount = round(
        $query->sum(DB::raw('total_price')),
        2
      );
    }

    return $TotalPurchaseAmount;
  }

  public function getTotalSalesAmount($startTime, $endTime, $payment_method = '')
  {
    $query = DB::table('sales')
      ->where('returned', 0);

    if ($payment_method !== '') {
      $query->where('payment_method', 'like', '%' . $payment_method . '%');
    }

    if ($startTime && ($startTime == $endTime)) {
      $TotalSalesAmount = round(
        $query->whereDate('created_at', '=', $startTime)
          ->sum('DownPayment'), // removed DB::raw
        2
      );
    } else if ($startTime != $endTime) {
      $TotalSalesAmount = round(
        $query->whereBetween('created_at', [$startTime . ' 00:00:00', $endTime . ' 23:59:59'])
          ->sum('DownPayment'), // removed DB::raw
        2
      );
    } else {
      $TotalSalesAmount = round(
        $query->sum('DownPayment'), // removed DB::raw
        2
      );
    }

    return $TotalSalesAmount;
  }

  public function getLedger($uuid, $search, $startTime, $endTime)
  {
    $perPage = 10;
    $ledgerQuery = leger::query();

    // Add date constraints to Ledger query
    if ($startTime && ($startTime == $endTime)) {
      $ledgerQuery->whereDate('created_at', '=', $startTime);
    } elseif ($startTime != $endTime) {
      $ledgerQuery->whereBetween('created_at', [$startTime . ' 00:00:00', $endTime . ' 23:59:59']);
    }

    // Add type constraint if filter is provided
    if ($search) {
      $ledgerQuery->where(function ($query) use ($search) {
        $query->where('Name', 'like', '%' . $search . '%')
          ->orWhere('Phone', 'like', '%' . $search . '%');
      });
    }
    if ($uuid) {
      $ledgerQuery->where('uuid', $uuid);
    }

    // Order the results by created_at in descending order
    $ledgerQuery->orderBy('created_at', 'desc');

    $ledger = $ledgerQuery->simplePaginate($perPage);
    return $ledger;
  }

  public function showadmin(Request $request)
  {
    $this->updateSalaries();

    $perPage = 10;
    $payment_method = $request->payment_method;
    $search = $request->search;
    // Sales and Pending Sales
    $salesQuery = Sales::where('RemainingPayment', '>=', 0);
    if (!$search)
      $salesQuery->where('returned', 0);

    $pendingSalesQuery = Sales::where('RemainingPayment', '<', 0);

    if ($payment_method) {
      $salesQuery->where('payment_method', $payment_method);
      $pendingSalesQuery->where('payment_method', $payment_method);
    }
    if ($search) {
      $salesQuery->where('CustomerPhone', $search);
    }
    // Add date constraints to sales and pendingSales queries
    if ($request->startTime && ($request->startTime == $request->endTime)) {
      $salesQuery->whereDate('created_at', '=', $request->startTime);
      $pendingSalesQuery->whereDate('created_at', '=', $request->startTime);
    } elseif ($request->startTime != $request->endTime) {
      $salesQuery->whereBetween('created_at', [$request->startTime . ' 00:00:00', $request->endTime . ' 23:59:59']);
      $pendingSalesQuery->whereBetween('created_at', [$request->startTime . ' 00:00:00', $request->endTime . ' 23:59:59']);
    }

    $sales = $salesQuery->simplePaginate($perPage);
    $pendingSales = $pendingSalesQuery->simplePaginate($perPage);
    // ->fragment('purchase')
    // ->fragment('other')
    $salesman = salesman::simplePaginate($perPage);

    // Purchases
    $purchasesQuery = Purchases::query();
    if ($payment_method) {
      $purchasesQuery->where('payment_method', $payment_method);
    }

    // Add date constraints to purchases query
    if ($request->startTime && ($request->startTime == $request->endTime)) {
      $purchasesQuery->whereDate('created_at', '=', $request->startTime);
    } elseif ($request->startTime != $request->endTime) {
      $purchasesQuery->whereBetween('created_at', [$request->startTime . ' 00:00:00', $request->endTime . ' 23:59:59']);
    }

    if (!$search)
      $purchasesQuery->where('returned', 0);
    else if ($search) {
      $purchasesQuery->where('vendor_phone', $search);
    }
    $purchases = $purchasesQuery->simplePaginate($perPage);

    $filter = $request->filter;
    $otherExpansesQuery = OtherExpanses::query();

    // Add date constraints to OtherExpanses query
    if ($request->startTime && ($request->startTime == $request->endTime)) {
      $otherExpansesQuery->whereDate('created_at', '=', $request->startTime);
    } elseif ($request->startTime != $request->endTime) {
      $otherExpansesQuery->whereBetween('created_at', [$request->startTime . ' 00:00:00', $request->endTime . ' 23:59:59']);
    }

    // Add type constraint if filter is provided
    if ($filter) {
      $otherExpansesQuery->where('type', $filter);
    }

    $otherExpanses = $otherExpansesQuery->simplePaginate($perPage);

    $TotalPrice = 0;
    $storedGrams = 0.00;
    $inventory = Inventory::all();
    if (!$inventory) {
      $data = [
        'conversionGrams' => 0.0,
      ];

      $inventory = Inventory::create($data);
    } else
      $storedGrams = $inventory[0]->conversionGrams;

    $TotalPurchaseGrams = 0;
    $totalSalesGrams = 0;

    $TotalPurchaseAmount = $this->getTotalPurchaseAmount($request->startTime, $request->endTime, $request->payment_method);
    $TotalSalesAmount = $this->getTotalSalesAmount($request->startTime, $request->endTime, $request->payment_method);

    // echo $TotalPurchaseAmount . '<br />' . $totalSalesAmount;

    if ($request->startTime && ($request->startTime == $request->endTime)) {
      $TotalPurchaseGrams = round(DB::table('purchases')
        ->whereDate('created_at', '=', $request->startTime)
        ->where('returned', 0)
        ->sum(DB::raw('(goldKarat * grams/21)')), 2);

      $totalSalesGrams = round(DB::table('sales')
        ->whereDate('created_at', '=', $request->startTime)
        ->where('returned', 0)
        ->sum(DB::raw('(goldKarat * grams/21)')), 2);
    } else if ($request->startTime != $request->endTime) {
      $TotalPurchaseGrams = round(DB::table('purchases')
        ->whereBetween('created_at', [$request->startTime . ' 00:00:00', $request->endTime . ' 23:59:59'])
        ->where('returned', 0)
        ->sum(DB::raw('(goldKarat * grams/21)')), 2);

      $totalSalesGrams = round(DB::table('sales')
        ->whereBetween('created_at', [$request->startTime . ' 00:00:00', $request->endTime . ' 23:59:59'])
        ->where('returned', 0)
        ->sum(DB::raw('(goldKarat * grams/21)')), 2);
    } else {
      $TotalPurchaseGrams = round(DB::table('purchases')
        ->where('returned', 0)
        ->sum(DB::raw('(goldKarat * grams/21)')), 2);
      $totalSalesGrams = round(DB::table('sales')
        ->where('returned', 0)
        ->sum(DB::raw('(goldKarat * grams/21)')), 2);
    }

    $customers = $this->getCustomers($request->customer_id ?? false, $request->search ?? false, $request->startTime ?? false, $request->endTime ?? false);

    $venders = $this->getVenders($request->vender_id ?? false, $request->search ?? false, $request->startTime ?? false, $request->endTime ?? false);

    $ledger = $this->getLedger($request->leger_id ?? false, $request->search ?? false, $request->startTime ?? false, $request->endTime ?? false);

    return view("AdminPanel", compact('salesman', 'sales', 'pendingSales', 'otherExpanses', 'purchases', 'TotalPrice', 'storedGrams', 'TotalPurchaseGrams', 'totalSalesGrams', 'customers', 'venders', 'TotalPurchaseAmount', 'TotalSalesAmount', 'ledger'));
  }
  public function signin(Request $request)
  {
    // $previousPageUrl = url()->previous();
    //dd($previousPageUrl);
    // if ($previousPageUrl == "http://127.0.0.1:8000/salemanmanager" || $previousPageUrl == "http://127.0.0.1:8000/AddSales") {
    //   $salesController = app(SalesmanController::class);
    //   return $salesController->index();
    // }
    if ($request->username == 'admin' && $request->password == "123321") {
      session(['admin' => 'admin']);
      // $_SERVER['HTTP_REFERER'];
      $sales = new SalesmanController();
      return $sales->index();
    } else {
      return redirect('/');
    }
  }
  public function ControlPanel()
  {
    // return view('ControlPanel');
  }
  public function AddSales()
  {
    $sales = new SalesController();
    return $sales->create();
  }
}
