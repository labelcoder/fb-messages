<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPromotion extends Model
{
    protected $table = 'product_promotions';

    protected $fillable = ['product_id', 'promotion_id'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function promotion() {
        return $this->belongsTo(Promotion::class);
    }
}
