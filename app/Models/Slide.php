<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'photo',
        'active',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
