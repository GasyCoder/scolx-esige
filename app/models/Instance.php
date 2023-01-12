<?php

class Instance extends Eloquent {
	

	protected $guarded = ['id', 'created_at'];

	protected $table = 'instances';

	public function student()	
	{
	    return $this->belongsTo('Student', 'id');
	}

	public function user()	
	{
	    return $this->belongsTo('User', 'user_id');
	}

	public function pay()
	{
	    return $this->belongsTo('Pay', 'id_etudiant');
	}

}