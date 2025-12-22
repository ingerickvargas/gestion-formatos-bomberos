<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $fillable = [
        'user_id','event','email','ip','user_agent','guard','success','failure_reason'
    ];
	
	public function user()
	{
    return $this->belongsTo(\App\Models\User::class);
	}

}
