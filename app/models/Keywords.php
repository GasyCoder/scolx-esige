<?php

class Keywords extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'site_keywords';
	
}