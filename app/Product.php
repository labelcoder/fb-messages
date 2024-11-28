<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['name', 'sku','stock_quantity','price','description'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
