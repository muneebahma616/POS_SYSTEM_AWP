<?php

namespace App\Http\Controllers;

use App\Models\salesman;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\OtherExpansesController;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\sales;
use Illuminate\Support\Facades\Hash;


class SalesmanController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function login(Request $request)
  {
    $salesman = Salesman::where('name', '=', $request->username)->first();

    if ($salesman && Hash::check($request->password, $salesman->password)) {
      // Password is correct
      session(['salesman' => $salesman->name]);
      return redirect(url('show'));
    } else {
      // Invalid credentials
      return redirect()->back()->withInput()->withErrors(['password' => 'Invalid username or password']);
    }
  }
  public function editsave(Request $request)
  {
    // Retrieve the ID from the request
    $id = $request->id;

    // Find the salesman record by ID
    $salesman = salesman::find($id);

    // Update the properties of the salesman model with form data
    $salesman->name = $request->input('name'); // Use 'name' instead of 'salesman'
    $salesman->salary = $request->input('salary'); // Use 'salary' instead of 'Salary'
    $salesman->password = $request->input('password');
    $salesman->privilege = $request->input('privilege');


    // Save the updated record to the database
    $salesman->save();

    // You may want to redirect to a different page after the update
    return $this->index();
  }
  private function generateRandomSixDigitNumber()
  {
    return mt_rand(100000, 999999);
  }
  // echo $randomNumber;
  public function invoice()
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
      $invoice = sales::where('uuid', $randomNumber)->first();
    } while ($invoice);

    $inventory = Inventory::all();
    $storedGrams = $inventory[0]->conversionGrams;

    return view('Invoice', compact('salesman', 'randomNumber', 'storedGrams'));
  }
  public function edit($uuid, Request $request)
  {
    $data = $request->validate([
      'name' => 'required|max:255',
      'phoneNumber' => 'required',
      'salary' => 'required',
      'privilege' => 'required'
    ]);
    salesman::where('uuid', $uuid)->update($data);
    return redirect(url('admin'));
  }
  public function index()
  {
    return redirect(url('admin'));
    // $_SERVER['HTTP_REFERER'];
    //dd($salesman);
    // $salesman = salesman::all();
    // return view("AdminPanel", compact('salesman'));
  }

  /**
   * Show the form for creating a new resource.
   */
  private function updatesalary()
  {
    // Get all Salesmen whose salarypaiddate is a month or more old
    $outdatedSalesmen = Salesman::where('salarypaiddate', '<=', now()->subMonth())->get();

    // Update each outdated Salesman's salarystatus and salarypaiddate
    foreach ($outdatedSalesmen as $salesman) {
      $salesman->salarystatus = 'unpaid';
      $salesman->salarypaiddate = null;
      $salesman->save();
    }
  }

  public function create()
  {
    // $this->updatesalary(); // Call the updatesalary function

    // $data = Salesman::all();
    // return view("signinpage", compact('data'));
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $salesman = Salesman::where('name', '=', $request->name)->first();
    if (!$salesman) {
      $data = $request->validate([
        'name' => 'required|max:255',
        'password' => 'required',
        'salary' => 'required',
        'phoneNumber' => 'required'
      ]);

      // Hash the password before storing it
      $data['password'] = bcrypt($data['password']);

      Salesman::create($data);
      return redirect(url('admin'))->with('success', 'Record added successfully!');
    } else
      return redirect(url('admin'))->with('err', 'Username Already exist!!!');

    // $data =  $request->validate([
    //   'salesman' => 'required|max:255',
    //   'Salary' => 'required',
    //   'password' => 'required|max:255',
    //   'phoneNumber' => 'required'
    // ]);

    // salesman::create($data);
    // return $this->index();
  }
  public function paid($uuid)
  {
    // Fetch salesman data
    $salesman = Salesman::where('uuid', $uuid)->first();
    if ($salesman->salarystatus == 'paid') {
      return redirect(url('admin'))->with('unautherr', 'Unauthorized Attempt');
    }

    // Update salary status and date
    Salesman::where('uuid', $uuid)->update([
      'salarystatus' => 'paid',
      'salarypaiddate' => Carbon::now()->toDateString(),
    ]);

    // Create data array for the OtherExpansesController
    $data = [
      'itemName' => $salesman->name,
      'Price' => $salesman->salary,
      'description' => null, // You can set a default value or adjust this as needed
      'type' => 'Salary',
    ];

    // Create an instance of OtherExpansesController
    $otherExpensesController = new OtherExpansesController();

    // Call the store method of OtherExpansesController and pass the data
    $otherExpensesController->store(new Request($data));

    return redirect(url('admin'));
  }

  /**
   * Display the specified resource.
   */
  /*public function show(salesman $salesman)
    {
        //
    }*/

  /**
   * Show the form for editing the specified resource.
   */


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, salesman $salesman)
  {
    //
  }
  public function resetPassword($uuid)
  {
    $salesman = salesman::where('uuid', $uuid)->first();
    if (!$salesman) {
      return redirect()->back()->with('err', 'User not found');
    }
    $salesman->update(['password' => Hash::make('12345678')]);
    return redirect()->back()->with('successChange', 'Password reset! New password is <u>12345678</u>');
  }

  public function changePassword(Request $request, $uuid)
  {
    if ($request->oldPassword == $request->newPassword) {
      return redirect()->back()->with('err', 'New password must be different from old password!');
    }
    $request->validate([
      'oldPassword' => 'required',
      'newPassword' => 'required|different:oldPassword',
    ]);

    // echo $request;

    $salesman = salesman::where('uuid', $uuid)->first();
    if (!$salesman) {
      return redirect()->back()->with('err', 'User not found');
    }
    // Check if the old password matches the user's current password
    if (!Hash::check($request->oldPassword, $salesman->password)) {
      return redirect()->back()->with('err', 'Old password is incorrect');
    }

    // Hash the new password and update the user's password
    $salesman->update(['password' => Hash::make($request->newPassword)]);

    return redirect()->back()->with('success', 'Password changed successfully');
  }
  /**
   * Remove the specified resource from storage.
   */

  public function destroy($uuid)
  {
    $salesman = Salesman::where('uuid', $uuid)->first();
    if ($salesman) {
      $salesman->delete();
    }
    return $this->index();
  }
}
