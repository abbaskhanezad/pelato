<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Starrating extends Model
{
	protected $table = 'starratings';
	protected $fillable= ['center_id', 'star','nezafat','tajhizat','khadamat','ip'];



}
