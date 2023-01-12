<?php

class Note extends Eloquent {
	

	protected $guarded = ['id', 'created_at'];

	protected $table = 'notesexam';


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

	public function stud()
	{
	    return $this->belongsTo('Student', 'id_student');
	}

	public function reviews()
	{
    	return $this->belongsTo('Student');
	}

}