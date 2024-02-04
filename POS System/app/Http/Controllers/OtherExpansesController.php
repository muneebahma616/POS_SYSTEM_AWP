<?php

namespace App\Http\Controllers;

use App\Models\OtherExpanses;
use Illuminate\Http\Request;

class OtherExpansesController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return OtherExpanses::all();
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'itemName' => 'required|max:255',
      'Price' => 'required',
      'description' => 'nullable',
      'type' => 'required',
    ]);

    $other = OtherExpanses::create($data);
    return redirect(url('admin'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(OtherExpanses $otherExpanses)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, OtherExpanses $otherExpanses)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(OtherExpanses $otherExpanses)
  {
    //
  }
}
