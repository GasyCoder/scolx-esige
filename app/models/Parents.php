<?php

class Parents extends Eloquent {
	

	protected $guarded = ['id', 'created_at'];

	protected $table = 'infosparents';

	public function student()	
	{
	    return $this->belongsTo('Student', 'id');
	}

	public function user()	
	{
	    return $this->belongsTo('User', 'user_id');
	}

}