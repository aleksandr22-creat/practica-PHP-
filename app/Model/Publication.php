<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title', 'journal', 'publication_date', 'index_type'
    ];

    public function aspirants()
    {
        return $this->belongsToMany(Aspirants::class, 'aspirant_publication');
    }

    public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'supervisor_publication');
    }
}