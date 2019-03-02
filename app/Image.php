<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

	protected $fillable = [
		'filename', 'imageable_type', 'imageable_id', 'community_id'
	];

	public function imageable(){
		return $this->morphTo();
	}
}
