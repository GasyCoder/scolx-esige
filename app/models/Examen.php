
<?php

class Examen extends Eloquent {
	

	protected $guarded = ['id', 'created_at'];

	protected $table = 'examens';


	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function matiere()
	{
	    return $this->belongsTo('EC', 'element_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}
}