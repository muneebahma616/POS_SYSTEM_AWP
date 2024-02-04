<?php

namespace App\Http\Controllers;

use App\Models\expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("AddExpenses");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'details' => 'required|string',
        ]);
        
        // Create a new Expense instance and fill it with the form data
        $expense = new expenses();
        $expense->amount = $request->input('amount');
        $expense->details = $request->input('details');

        // Save the expense to the database
        $expense->save();

        return view('adminpanel');
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, expenses $expenses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(expenses $expenses)
    {
        //
    }
}
