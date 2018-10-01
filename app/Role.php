<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = [
	    'name', 'status'
	];

	public function users()
	{
		$this->hasMany('App\User');
	}
}
