<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['customer_id', 'order_date', 'status','total_amount','code','price_amount','discount_amount','note','address'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    function customer() {
        return $this->belongsTo(Customer::class);
    }

    function orderitems() {
        return $this->hasMany(OrderItem::class);
    }
}
