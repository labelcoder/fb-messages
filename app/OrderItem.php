<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = ['order_id', 'product_id', 'quantity','price_at_order','total_price'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    function order() {
        return $this->belongsTo(Order::class);
    }
}
