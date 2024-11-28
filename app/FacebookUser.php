<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    protected $table = 'facebook_users';

    protected $fillable = ['user_id', 'name', 'profile_url'];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
