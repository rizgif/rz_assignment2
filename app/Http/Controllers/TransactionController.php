<?php

// TransactionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Import the Transaction model

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all(); // Retrieve all transactions from the database
        return view('transactions.index', ['transactions' => $transactions]);
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Define validation rules for storing transactions here
        ]);

        // Create a new transaction record in the database
        Transaction::create($request->all());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            // Define validation rules for updating transactions here
        ]);

        // Update the transaction record in the database
        $transaction->update($request->all());

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        // Delete the transaction record from the database
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
