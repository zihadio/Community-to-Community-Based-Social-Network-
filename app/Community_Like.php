<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community_Like extends Model
{

    protected $table = 'community_likes';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function community_post(){
        return $this->belongsTo('App\Community_Post');
    }

}
