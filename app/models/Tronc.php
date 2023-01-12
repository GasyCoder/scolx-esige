<?php

class Tronc extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'matieres_tronc';

	/*public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}
	*/
 	public function parcour()
    {
        return $this->belongsTo('Parcour', 'parcour_id');
    }

    public function matiere()
    {
        return $this->belongsTo('EC', 'element_id');
    }

}