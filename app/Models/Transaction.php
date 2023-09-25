<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'merchant_id',
        'amount',
        'deduction',
        'merchant_balance_before',
        'merchant_balance_after',
    ];


    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
