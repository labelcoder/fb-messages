<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = ['name', 'description', 'discount_percentage','start_date','end_date','qty','qty_free'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function productPromotions() {
        return $this->hasMany(ProductPromotion::class);
    }
}
