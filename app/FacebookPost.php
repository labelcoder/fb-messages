<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookPost extends Model
{
    protected $table = 'facebook_posts';

    protected $fillable = ['post_id', 'author_name', 'author_id', 'content', 'like_count', 'created_time', 'updated_time', 'comment_count', 'share_count'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    function facebookcomments() {
        return $this->hasMany(FacebookComment::class, 'post_id', 'post_id');
    }
}
