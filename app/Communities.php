<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Communities extends Model
{
    protected $table = 'community';

    public function getRouteKey()
    {
        $user = Auth::user();
        $communityid = PersonalInformation::where('user_id', $user)->value('community_id');
        return $this->$communityid;
    }


}
