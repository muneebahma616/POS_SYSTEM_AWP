<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\leger;
use App\Models\purchases;
use App\Models\vender;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  private function generateRandomSixDigitNumber()
  {
    return mt_rand(100000, 999999);
  }
  public function index()
  {
    $salesman = session('salesman');
    if (!$salesman) {
      $salesman = session('admin');
      if (!$salesman) {
        $salesman = 'Unknown';
      }
    }
    $randomNumber = 0;
    do {
      $randomNumber = $this->generateRandomSixDigitNumber();
      $invoice = purchases::where('uuid', $randomNumber)->first();
    } while ($invoice);
    return view('AdminPurchase', compact('salesman', 'randomNumber'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('AddPurchase');
  }
  public function return(Request $request, $id)
  {
    $purchase = purchases::where('uuid', $id)->first();
    if ($purchase) {
      if (($purchase->grams < $request->returnedGold) || ($purchase->total_price < $request->returnedAmount)) {
        return redirect(url('admin?page=1'))->with('err', 'Invalid Input.');
      }
    }
    if ($purchase->returned) {
      return redirect(url('admin?page=1'));
    }

    if ($purchase) {
      $vend = vender::where('uuid', $purchase->vender_id)->first();
      vender::where('uuid', $purchase->vender_id)->update(['totalPurchasesAmount' => $vend->totalPurchasesAmount - $request->returnedAmount]);

      vender::where('uuid', $purchase->vender_id)->update(['totalPurchasesGrams' => $vend->totalPurchasesGrams - $request->returnedGold]);

      $legerData = [
        'name' => $purchase->vendor_name,
        'phone' => $purchase->vendor_phone,
        'goldKarat' => $purchase->goldKarat,
        'grams' => $request->returnedGold,
        'returnAmount' => $request->returnedAmount,
        'Tax' => $purchase->Tax,
        'Discount' => $purchase->Discount,
      ];
      $leger = leger::create($legerData);

      if ($purchase->total_price == $request->returnedAmount) {
        $purchase->update(
          ['returned' => true],
        );
      } else {
        $purchase->update([
          'total_price' => $purchase->total_price - $request->returnedAmount,
          'grams' => $purchase->grams - $request->returnedGold,
        ]);
      }

      $temp = Inventory::all();
      $inventory = Inventory::where('uuid', $temp[0]->uuid);
      $inventory->update([
        'conversionGrams' => $temp[0]->conversionGrams - round(($purchase->GoldKarat * $request->returnedGold / 21), 2),
      ]);

      return redirect(url('admin?page=1'))->with('success', 'Record updated Successfully.');
    } else {
      return redirect(url('admin?page=1'))->with('err', 'Error while saving the record.');
    }
  }
  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $vender = vender::where('venderPhone', 'like', '%' . $request->vendor_phone . '%')->first();
    if (!$vender) {
      $venderData = [
        'venderName' => $request->vendor_name,
        'venderPhone' => $request->vendor_phone,
        'totalPurchasesAmount' => $request->total_price,
        'totalPurchasesGrams' => $request->grams,
      ];
      vender::create($venderData);
      $vender = vender::where('venderPhone', 'like', '%' . $request->vendor_phone . '%')->first();
    } else {
      $vend = vender::where('uuid', $vender->uuid);
      $vend->update([
        'totalPurchasesAmount' => $vend->totalPurchasesAmount + $request->total_price,
        'totalPurchasesGrams' => $vend->totalPurchasesGrams + $request->grams,
      ]);
    }
    $data = $request->validate([
      'uuid' => 'required',
      'vendor_name' => 'required|max:255',
      'vendor_phone' => 'required',
      'payment_method' => 'required',
      'goldKarat' => 'required',
      'price' => 'required',
      'grams' => 'required',
      'Tax' => 'required',
      'Discount' => 'required',
      'total_price' => 'required',
    ]);
    $data['vender_id'] = $vender->uuid;
    $inventoryID = Inventory::all();
    Inventory::where('uuid', $inventoryID[0]->uuid)
      ->update(['conversionGrams' => $inventoryID[0]->conversionGrams + round(($request->goldKarat * ($request->grams / 21)), 2)]);

    $legerData = [
      'name' => $request->vendor_name,
      'phone' => $request->vendor_phone,
      'purchaseAmount' => $request->total_price,
      'goldKarat' => $request->goldKarat,
      'grams' => $request->grams,
      'Tax' => $request->Tax,
      'Discount' => $request->Discount,
      'TotalPrice' => $request->total_price,
    ];
    leger::create($legerData);

    $purchase = purchases::create($data);
    if ($purchase) {
      return redirect(url('purchase'))->with('success', 'Record Added Successfully.');
    } else {
      return redirect(url('purchase'))->with('err', 'Error while saving the record.');
    }
  }

  /**
   * Display the specified resource.
   */

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy()
  {
    //
  }
}
