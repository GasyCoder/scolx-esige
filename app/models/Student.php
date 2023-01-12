<?php

class Student extends Eloquent {
	

	protected $guarded = ['id', 'created_at'];

	protected $table = 'students';

	public function niveau()
	{
	    return $this->belongsTo('TheClass', 'class_id');
	}

	public function user()	
	{
	    return $this->belongsTo('User', 'user_id');
	}

	public function instance()	
	{
	    return $this->belongsTo('Instance', 'id');
	}

	public function fichier()	
	{
	    return $this->belongsTo('Fichier', 'id');
	}

	public function ec()	
	{
	    return $this->belongsTo('EC', 'class_id');
	}

	public function parcour()
	{
	    return $this->belongsTo('Parcour', 'parcour_id');
	}

	public function groupe()
	{
	    return $this->belongsTo('Groupe', 'groupe_id');
	}

	public function yearS()
	{
	    return $this->belongsTo('Year', 'yearsUniv');
	}

	public function absence()
	{
	    return $this->hasMany('Absence', 'id_student');
	}

	public function pay()
	{
	    return $this->belongsTo('Pay', 'id_etudiant');
	}

	public function deliber()
	{
	    return $this->belongsTo('Delibera', 'id_student');
	}
}