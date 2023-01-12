<?php

class Mention extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'mentions';


	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

	public function domaine()
	{
	    return $this->belongsTo('Domaine', 'domaine_id');
	}

}