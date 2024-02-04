<?php

namespace App\Http\Controllers;

use App\Models\sales;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesmanController;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\leger;
use App\Models\purchases;
use App\Models\salesman;
use Error;

class SalesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $admin = session('admin');
    $previousPageUrl = url()->previous();
    if ($previousPageUrl == "http://127.0.0.1:8000/signin") {
      if ($admin === "admin") {
        $data = sales::all();
        return view('allsales', compact('data'));
      }
      echo "no admin access for youuuuu";
    }
    $name = session('name');
    //dd($name);
    $priv = salesman::where('name', '=', $name)->value('privilege'); // Assuming 'privilege' is the correct field name
    //dd($priv);
    if ($priv === "employee") {
      $data = sales::where('Salesman', '=', $name)->get();
      return view('allsales', compact('data'));
    } else if ($priv === "all") {
      $data = sales::all();
      return view('allsales', compact('data'));
    }
    echo "NO login found";
    //return view('allsales', compact('data'));
  }


  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $data = salesman::all();
    return view("AddSales", compact('data'));
  }
  public function return(Request $request, $id)
  {
    $sales = Sales::where('uuid', $id)->first();
    if ($sales) {
      if (($sales->Grams < $request->returnedGold) || ($sales->DownPayment < $request->returnedAmount)) {
        return redirect(url('admin?page=1'))->with('err', 'Invalid Input.');
      }
    }
    if ($sales->returned) {
      return redirect(url('admin?page=1'));
    }

    if ($sales) {
      $cust = Customer::where('uuid', $sales->customer_id)->first();
      Customer::where('uuid', $sales->customer_id)->update(['totalSalesAmount' => $cust->totalSalesAmount - $request->returnedAmount]);

      Customer::where('uuid', $sales->customer_id)->update(['totalSalesGrams' => $cust->totalSalesGrams - $request->returnedGold]);

      if ($sales->DownPayment == $request->returnedAmount) {
        $sales->update(
          ['returned' => true],
        );
      } else {
        $sales->update([
          'TotalPrice' => $sales->TotalPrice - $request->returnedAmount,
          'DownPayment' => $sales->DownPayment - $request->returnedAmount,
          'Grams' => $sales->Grams - $request->returnedGold,
        ]);
      }

      $temp = Inventory::all();
      $inventory = Inventory::where('uuid', $temp[0]->uuid);
      $inventory->update([
        'conversionGrams' => $temp[0]->conversionGrams + round(($sales->GoldKarat * $request->returnedGold / 21), 2),
      ]);

      $legerData = [
        'name' => $sales->CustomerName,
        'phone' => $sales->CustomerPhone,
        'goldKarat' => $sales->GoldKarat,
        'grams' => $request->returnedGold,
        'returnAmount' => $request->returnedAmount,
        'Tax' => $sales->Tax,
        'Discount' => $sales->Discount,
      ];
      $leger = leger::create($legerData);

      return redirect(url('admin?page=1'))->with('success', 'Record updated Successfully.');
    } else {
      return redirect(url('admin?page=1'))->with('err', 'Error while saving the record.');
    }
  }

  public function print(Request $request)
  {
    // $data = salesman::all();
    $salesman = session('salesman');
    if (!$salesman) {
      $salesman = session('admin');
      if (!$salesman) {
        $salesman = 'Unknown';
      }
    }
    $randomNumber = $request->uuid;
    $data = '';
    if ($request->record == 'sales') {
      $data = sales::where('uuid', $randomNumber)->first();
    } else {
      $data = purchases::where('uuid', $randomNumber)->first();
    }
    return view("PrintPage", compact('salesman', 'randomNumber', 'data'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $customer = Customer::where('customerPhone', 'like', '%' . $request->CustomerPhone . '%')->first();
    if (!$customer) {
      $custData = [
        'customerName' => $request->CustomerName,
        'customerPhone' => $request->CustomerPhone,
        'totalSalesAmount' => $request->total_price,
        'totalSalesGrams' => $request->grams,
      ];
      Customer::create($custData);
      $customer = Customer::where('customerPhone', 'like', '%' . $request->CustomerPhone . '%')->first();
    } else {
      $cust = Customer::where('uuid', $customer->uuid);
      $cust->update([
        'totalSalesAmount' => $cust->totalSalesAmount + $request->total_price,
        'totalSalesGrams' => $cust->totalSalesGrams + $request->grams,
      ]);
    }
    $data = $request->validate([
      'uuid' => 'required',
      'CustomerName' => 'required|max:255',
      'CustomerPhone' => 'required',
      'Salesman' => 'required',
      'payment_method' => 'required',
      'DownPayment' => 'required',
      'RemainingPayment' => 'required',
      'GoldKarat' => 'required',
      'Price' => 'required',
      'Grams' => 'required',
      'Tax' => 'required',
      'Discount' => 'required',
      'TotalPrice' => 'required',
      'deliverydate' => 'required',
    ]);
    $data['customer_id'] = $customer->uuid;

    $legerData = [
      'name' => $request->CustomerName,
      'phone' => $request->CustomerPhone,
      'salesAmount' => $request->DownPayment,
      'remainingAmount' => $request->RemainingPayment,
      'goldKarat' => $request->GoldKarat,
      'grams' => $request->Grams,
      'Tax' => $request->Tax,
      'Discount' => $request->Discount,
      'deliverydate' => $request->deliverydate,
      'TotalPrice' => $request->TotalPrice,
    ];
    $leger = leger::create($legerData);

    $inventoryID = Inventory::all();
    $inventory = Inventory::where('uuid', $inventoryID[0]->uuid)
      ->update(['conversionGrams' => $inventoryID[0]->conversionGrams - round(($request->GoldKarat * ($request->Grams / 21)), 2)]);

    if ($inventory && $leger) {
      $sales = Sales::create($data);
      if ($sales) {
        return redirect(url('invoice'))->with('success', 'Record Added Successfully.');
      } else {
        return redirect(url('invoice'))->with('err', 'Error while saving the record.');
      }
    } else {
      return redirect(url('invoice'))->with('err', 'Error while saving the record.');
    }
  }
  /**
   * Display the specified resource.
   */
  public function showw(Request $request)
  {
    $salesman = session('salesman');
    $perPage = 10;

    $inventory = Inventory::all();
    $storedGrams = $inventory[0]->conversionGrams;

    if ($salesman) {
      $saleman = salesman::where('name', $salesman)->first();
      $sales = [];
      if ($saleman->privilege == 'all') {
        $sales = sales::where('RemainingPayment', '>=', 0)->simplePaginate($perPage);
      } else
        $sales = sales::where('Salesman', $salesman)->simplePaginate($perPage);
      return view("EmployeeScreen", compact('saleman', 'sales', 'storedGrams'));
    } else {
      // Handle the case where 'salesman' session is null
      return redirect()->route('login'); // Adjust the route as needed
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function editsalesdone($id)
  {
    $sales = Sales::find($id);

    if (!$sales) {
      // Handle the case where the Sales record with the given $id is not found
      return redirect()->back()->with('error', 'Sales record not found.');
    }

    // Get the current values
    $currentDownPayment = $sales->DownPayment;
    $currentRemainingPayment = $sales->RemainingPayment;

    // Check if RemainingPayment is in a negative value
    if ($currentRemainingPayment < 0) {
      // Make it positive
      $positiveRemainingPayment = abs($currentRemainingPayment);
      // Add the positiveRemainingPayment to DownPayment
      $updatedDownPayment = $currentDownPayment + $positiveRemainingPayment;

      $legerData = [
        'name' => $sales->CustomerName,
        'phone' => $sales->CustomerPhone,
        'salesAmount' => $positiveRemainingPayment,
        // 'goldKarat' => $sales->GoldKarat,
        // 'grams' => $sales->Grams,
        // 'Tax' => $sales->Tax,
        // 'Discount' => $sales->Discount,
        'TotalPrice' =>  $positiveRemainingPayment,
      ];
      $leger = leger::create($legerData);

      if ($leger) {
        // Update the database
        $sales->update([
          'DownPayment' => $updatedDownPayment,
          'RemainingPayment' => 0, // Set RemainingPayment to zero after adding to DownPayment
        ]);

        // Redirect with a success message
        return redirect(url('admin?page=1'));
      } else {
        return redirect()->back()->with('error', 'Sales record not found.');
      }
    }
  }

  public function edit($id, Request $request)
  {
    $request->validate([
      'add-balance' => 'required',
    ]);

    $additionalBalance = $request->input('add-balance');

    $sales = Sales::find($id);

    if ($sales) {
      // Get the current values
      $currentDownPayment = $sales->DownPayment;
      $currentRemainingPayment = $sales->RemainingPayment;

      // Calculate new values by adding the additional balance
      $updatedDownPayment = $currentDownPayment + $additionalBalance;
      $updatedRemainingPayment = $currentRemainingPayment + $additionalBalance;

      $legerData = [
        'name' => $sales->CustomerName,
        'phone' => $sales->CustomerPhone,
        'salesAmount' => $additionalBalance,
        'remainingAmount' => $updatedRemainingPayment,
        // 'goldKarat' => $sales->GoldKarat,
        // 'grams' => $sales->Grams,
        // 'Tax' => $sales->Tax,
        // 'Discount' => $sales->Discount,
        'TotalPrice' =>  abs($currentRemainingPayment),
      ];
      $leger = leger::create($legerData);

      if ($leger) {
        // Update the database
        $sales->update([
          'DownPayment' => $updatedDownPayment,
          'RemainingPayment' => $updatedRemainingPayment,
        ]);
        return redirect(url('admin?page=1'))->with('success', 'Sales updated successfully.');
      } else {
        return redirect()->back()->with('error', 'Sales record not found.');
      }
    } else {
      // Handle the case where the Sales record with the given $id is not found
      return redirect()->back()->with('error', 'Sales record not found.');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, sales $sales)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(sales $sales)
  {
    //
  }
}
