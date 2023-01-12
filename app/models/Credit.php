<?php

class Credit extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'credits';

	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

	public function mat()
	{
	    return $this->belongsTo('EC', 'element_id');
	}

	public function unite()
	{
	    return $this->belongsTo('UE', 'id_unite');
	}

	public function note()
	{
	    return $this->belongsTo('Note', 'id_student');
	}

	public function stud()
	{
	    return $this->belongsTo('Student', 'id_student');
	}

}