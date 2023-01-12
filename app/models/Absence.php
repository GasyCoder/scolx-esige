<?php

class Absence extends Eloquent {
	

	protected $guarded = ['id', 'created_at'];

	protected $table = 'absences';


	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function element()
	{
	    return $this->belongsTo('EC', 'class_id', 'parcour_id');
	}

	public function student()
	{
	    return $this->belongsTo('Student', 'id_student');
	}
}