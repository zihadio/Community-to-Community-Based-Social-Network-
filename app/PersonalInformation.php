<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{

    public function communitiy(){
        return $this->belongsTo('Communities')->select(array('community_id'));
    }
}
