<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookFetchHistory extends Model
{
    protected $table = 'facebook_fetch_history';

    protected $fillable = ['fetch_time', 'post_id', 'comments_fetched', 'status'];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
