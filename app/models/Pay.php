<?php

class Pay extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'payments';

	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}


	public function etudiant()
	{
	    return $this->belongsTo('Student', 'id_etudiant');
	}

	public function user()
	{
	    return $this->belongsTo('User', 'user_id');
	}
}