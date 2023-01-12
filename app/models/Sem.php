<?php

class Sem extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'semestres';


	public function year()
	{
	    return $this->belongsTo('Year', 'semestre_id');
	}

}