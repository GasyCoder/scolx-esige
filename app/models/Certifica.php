<?php

class Certifica extends Eloquent {

	protected $guarded = ['id', 'created_at'];

	protected $table = 'certificates';

	public function std()
	{
	    return $this->belongsTo('Student', 'id_student');
	}

	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

	/*public function domaine()
	{
	    return $this->belongsTo('Domaine', 'parcour_id');
	}*/
}