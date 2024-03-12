<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    const TYPE_FIXED = 1;
    const TYPE_PERCENT = 2;

    protected $fillable = [
        'code',
        'type',
        'discount',
        'redeems',
        'active'
    ];
}
