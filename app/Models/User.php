<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'email_verified_at',
    'password',
    'remember_token',
    'balance',  // Add this line
    'created_at',
    'updated_at',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function userStatus(){
        return $this->belongsTo(UserStatus::class);
    }

    public function addBalance($amount)
{
    $this->balance += $amount;
    $this->save();
}

    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->decimal('balance', 10, 2)->default(0.00); // Example of a balance field with default value 0
    });
}

public function subtractBalance($amount)
{
    if ($this->balance >= $amount) {
        $this->balance -= $amount;
        $this->save();
        return true;
    }

    return false; // Insufficient balance
}


}
