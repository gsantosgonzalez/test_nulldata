<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    
    $/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['alias', 'address'];

    /**
     * Address belongs to Employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Employee()
    {
    	// belongsTo(RelatedModel, foreignKey = employee_id, keyOnRelatedModel = id)
    	return $this->belongsTo(Employee::class);
    }
}
