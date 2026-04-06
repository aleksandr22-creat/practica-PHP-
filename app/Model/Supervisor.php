<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    public $timestamps = false;
    protected $fillable = ['full_name', 'department'];

    public function aspirants()
    {
        return $this->hasMany(Aspirant::class);
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'supervisor_publication');
    }
}