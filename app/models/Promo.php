<?php

class Promo extends Eloquent {
	
	protected $guarded = ['id', 'created_at'];

	protected $table = 'promos';

}