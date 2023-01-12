<?php

class Delibera extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'activations';

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