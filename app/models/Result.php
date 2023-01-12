<?php

class Result extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'resultats';

	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

	public function stud()
	{
	    return $this->belongsTo('Student', 'id_student');
	}


}