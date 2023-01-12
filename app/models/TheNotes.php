<?php

class TheNotes extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'thenotes';

	public function user()	
	{
	    return $this->belongsTo('User', 'id_user');
	}

}