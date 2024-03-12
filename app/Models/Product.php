<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'sku',
        'category_id'
    ];

    //Appending Values 
    protected $appends = ['featura_photo', 'price_text'];

    protected function featuraPhoto(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->photos()->first() ?
                    asset($this->photos()->first()->path)
                    : asset('uploads/products/th.jpg');
            }
        );
    }
    protected function priceText(): Attribute
    {
        return new Attribute(
            get: fn () => 'SAR',
        );
    }

    //Events
    protected static function booted(): void
    {
        static::created(function ($product) {
            $product->sku = rand(1000, 9999);
            $product->save();
        });
    }
    //Relationship

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }


    public function cart()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function comments()
    {
        return $this->belongsToMany(User::class)->withPivot(['rating', 'comment']);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
