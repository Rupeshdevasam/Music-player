<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
	protected $fillable = [
		'name',  'places', 'songs', 'user_id','public'
	];


    //
	public function user()
	{
		
		return $this->belongsTo(User::class);
	}
}
