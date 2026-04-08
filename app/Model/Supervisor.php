<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'full_name',
        'academic_degree',
        'position',
        'department',
        'email',
        'phone',
        'bio'
    ];

    public function aspirants()
    {
        return $this->hasMany(Aspirants::class);
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'supervisor_publication');
    }
}