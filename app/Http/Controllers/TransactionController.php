<?php

namespace App\Http\Controllers;

use App\Models\SendMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
{
  public function getAllTransactions()
{
    $transactions = SendMoney::with(['sender', 'receiver'])->get();

    return response()->json($transactions);
}


    public function update(Request $request, $id)
{
    // Validate input (adjust fields as needed)
    $validator = Validator::make($request->all(), [
        'amount' => 'sometimes|numeric|min:1',
        'currency' => 'sometimes|string|max:3',
        'transaction_type' => 'sometimes|string',
        // Add any other updatable fields here
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Find the transaction
    $transaction = SendMoney::find($id);
    if (!$transaction) {
        return response()->json(['error' => 'Transaction not found'], 404);
    }

    // Update fields if provided
    if ($request->has('amount')) {
        $transaction->amount = $request->amount;
    }
    if ($request->has('currency')) {
        $transaction->currency = $request->currency;
    }
    if ($request->has('transaction_type')) {
        $transaction->transaction_type = $request->transaction_type;
    }

    // Save the updated transaction
    $transaction->save();

    return response()->json(['message' => 'Transaction updated successfully', 'transaction' => $transaction]);
}

public function destroy($id)
{
    $transaction = SendMoney::find($id);

    if (!$transaction) {
        return response()->json(['error' => 'Transaction not found'], 404);
    }

    $transaction->delete();

    return response()->json(['message' => 'Transaction deleted successfully']);
}


}

