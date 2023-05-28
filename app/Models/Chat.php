<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'sender',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_customer_chat');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'user_customer_chat');
    }
}
