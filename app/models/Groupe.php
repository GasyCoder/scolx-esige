<?php

class Groupe extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'groupes';


	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}


	public function student()
	{
	    return $this->belongsTo('Etpresent', 'student_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

}