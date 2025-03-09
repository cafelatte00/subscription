<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'price',
        'frequency',
        'first_payment_day',
        'next_payment_day',
        'cancel_day',
        'number_of_payments',
        'url',
        'memo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
