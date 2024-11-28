<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    function products() {
        return $this->hasMany(Product::class);
    }
}
