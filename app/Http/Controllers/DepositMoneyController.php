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
        $validator = Validator::make($request->all(), [
            'user_status_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|max:3', // optional if you want to keep currency column
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::find($request->user_status_id);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        \DB::beginTransaction();

        try {
            // Update user balance
            $user->balance += $request->amount;
            $user->save();

            // Create deposit transaction (no sender_id)
            $transaction = new SendMoney();
            $transaction->sender_id = null; // or 0, or system user id if you want
            $transaction->receiver_id = $user->id;
            $transaction->amount = $request->amount;
            $transaction->currency = $request->currency;
            $transaction->transaction_type = 'deposit';
            $transaction->reference_number = uniqid('dep_'); // optional unique ref
            $transaction->save();

            \DB::commit();

            return response()->json([
                'message' => 'Deposit successful!',
                'transaction' => $transaction,
                'new_balance' => $user->balance,
            ], 200);

        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'error' => 'Deposit failed.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
