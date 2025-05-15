<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMoney extends Model
{
   protected $table = 'send_money'; // Uses the same table as SendMoney

    protected $fillable = [
        'user_status_id',
        'amount',
        'currency',
        'transaction_type',
    ];

    protected $attributes = [
        'transaction_type' => 'deposit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
