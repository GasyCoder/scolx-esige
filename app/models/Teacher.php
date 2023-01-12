<?php

class Teacher extends Eloquent {
	

	protected $guarded = ['id', 'created_at'];

	protected $table = 'teachers';


	public function user()	
	{
	    return $this->belongsTo('User', 'user_id');
	}

	public function ec()	
	{
	    return $this->belongsTo('EC', 'class_id');
	}

	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

	public function yearS()
	{
	    return $this->belongsTo('Year', 'yearsUniv');
	}


}