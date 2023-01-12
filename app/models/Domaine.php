<?php

class Domaine extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'domaines';


	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

}