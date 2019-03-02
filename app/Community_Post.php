<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community_Post extends Model
{

    protected $table = 'community_post';
    protected $post_image_path = 'img/community_posts/';

    protected $fillable = [
        'body', 'user_id', 'community_id'
    ];

    public function imagePath(Image $img){
        return $this->post_image_path . $img->filename;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function images(){
        return $this->morphMany('App\Image', 'imageable');
    }

    public function community_likes(){
        return $this->belongsTo('App\Community_Like');
    }

    public function likes(){
        return $this->morphMany('App\Like', 'likable');
    }

    public function infoStatus(){
        return $this->likes()->count() . ' ' .str_plural('Like', $this->likes()->count()) . ' | '. $this->comments()->count() . ' ' .str_plural('Comment', $this->comments()->count());
    }



}
