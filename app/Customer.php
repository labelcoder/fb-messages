<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['first_name', 'last_name', 'email','phone','address','facebook_id', 'line_id'];

    protected $primaryKey = 'id';

    public $timestamps = false;


    public static function getItems() {
        $customers = self::all();
        if ($customers && count($customers) > 0) {
            foreach ($customers as $item) {
                $item->fullname = $item->first_name ?? '';
                $item->fullname .= ' ' . $item->last_name ?? '';
            }
        }
        return $customers;
    }

    function orders() {
        return $this->hasMany(Order::class);
    }
}
