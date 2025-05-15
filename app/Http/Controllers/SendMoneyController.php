<?php

namespace App\Http\Controllers;


use App\Models\SendMoney;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendMoneyController extends Controller
{
   public function send(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'sender_id' => 'required|exists:users,id',
        'receiver_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
        'currency' => 'required|string|max:3',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Get sender and receiver users
    $sender = User::find($request->sender_id);
    $receiver = User::find($request->receiver_id);

    // Check if sender has enough balance
    if ($sender->balance < $request->amount) {
        return response()->json(['error' => 'Insufficient balance.'], 400);
    }

    // Begin transaction
    \DB::beginTransaction();

    try {
        // Decrease sender's balance
        $sender->subtractBalance($request->amount);

        // Increase receiver's balance
        $receiver->addBalance($request->amount);

        // Create SendMoney transaction
        $transaction = new SendMoney();
        $transaction->sender_id = $sender->id;
        $transaction->receiver_id = $receiver->id;
        $transaction->amount = $request->amount;
        $transaction->currency = $request->currency;
        $transaction->transaction_type = 'send'; // set as 'send' transaction
        $transaction->save();

        \DB::commit();

        return response()->json(['message' => 'Money sent successfully!', 'transaction' => $transaction], 200);
    } catch (\Exception $e) {
    \DB::rollBack();
    return response()->json([
        'error' => 'Transaction failed. Please try again later.',
        'message' => $e->getMessage(),  // show real error for debugging
    ], 500);
}

}

}
