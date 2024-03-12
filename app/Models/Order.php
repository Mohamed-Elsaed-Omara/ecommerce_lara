<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Order extends Model
{
    use HasFactory;
//STATUS ORDER
    const STATUS_NEW = 1;

    const SATUS_IN_PROGRAEC = 2;

    const SATUS_SHIPPED = 3;

    const SATUS_PAID = 4;

    const SATUS_CANCELED = 5;
//PAYMENT_METHOD
    const PAYMENT_CASH_ON_DELVIRY = 1;

    const PAYMENT_PAYPAL = 2;

    protected $fillable = [
        'status',
        'payment_method',
        'payment_status',
        'address',
        'notes',
        'subtotal',
        'vat',
        'total',
        'user_id',
        'coupon_id'

    ];

    protected $appends = ['status_text','payment_method_text'];

    protected function statusText(): Attribute
    {
        return new Attribute(
            get: function(){
                switch($this->status){
                    case self::STATUS_NEW:
                        return 'New Order';
                    case self::SATUS_IN_PROGRAEC:
                        return 'Preparing Order';
                    case self::SATUS_SHIPPED:
                        return 'Order Shipped';
                    case self::SATUS_PAID:
                        return 'Order Paid';
                    case self::SATUS_CANCELED:
                        return 'Order Canceled';
                        
                }
            } 
        );
    
    }
    protected function paymentMethodText(): Attribute
    {
        return new Attribute(
            get: function(){
                switch($this->payment_method){
                    case self::PAYMENT_CASH_ON_DELVIRY:
                        return 'Cash On Delviry';
                    case self::PAYMENT_PAYPAL:
                        return 'PayPal';
                        
                }
            } 
        );
    
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity','price','total']);
    }
}
