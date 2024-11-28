<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookComment extends Model
{
    protected $table = 'facebook_comments';

    protected $fillable = ['comment_id', 'post_id', 'author_name', 'author_id', 'parent_comment_id', 'content', 'like_count', 'created_time', 'updated_time'];

    protected $primaryKey = 'id';

    public $timestamps = false;

    function facebookpost() {
        return $this->belongsTo(FacebookPost::class, 'post_id', 'post_id');
    }
}
