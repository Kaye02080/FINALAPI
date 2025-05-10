<?php

namespace App\Http\Controllers;

use App\Models\SendMoney;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositMoneyController extends Controller
{
    public function deposit(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|max:3', // Assuming a 3-character currency code
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Get the user
        $user = User::find($request->user_id);

        // Begin transaction
        \DB::beginTransaction();

        try {
            // Increase user's balance
            $user->balance += $request->amount;
            $user->save();

            // Create SendMoney transaction for deposit
            $transaction = new SendMoney();
            $transaction->user_id = $user->id;
            $transaction->amount = $request->amount;
            $transaction->currency = $request->currency;
            $transaction->transaction_type = 'deposit'; // set as 'deposit' transaction
            $transaction->save();

            \DB::commit();

            return response()->json(['message' => 'Deposit successful!', 'transaction' => $transaction], 200);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Deposit failed. Please try again later.'], 500);
        }
    }
}
