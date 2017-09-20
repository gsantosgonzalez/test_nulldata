<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employees';

	/**
	 * Fields that can be mass assigned.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'birthdate'];

	/**
	 * Employee has many Adresses.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function Addresses()
	{
		// hasMany(RelatedModel, foreignKeyOnRelatedModel = employee_id, localKey = id)
		return $this->hasMany(Address::class);
	}

}
