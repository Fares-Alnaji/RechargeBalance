<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory , HasApiTokens;

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    protected $appends = ['active_key'];

    public function getActiveKeyAttribute(){
        return $this->active ? 'Active' : 'In-Active';
    }
}
