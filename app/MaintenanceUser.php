<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaintenanceUser extends Model
{
    protected $fillable = ['name', 'number', 'city'];

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function complains()
    {
        return $this->hasMany('App\Complain');
    }
}
