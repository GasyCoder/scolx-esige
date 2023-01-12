<?php

class Ecolage extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'ecolages';


	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}


}