<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Aspirants extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'enrollment_year',
        'specialty',
        'supervisor_id'
    ];
    public function setSupervisorIdAttribute($value)
    {
        $this->attributes['supervisor_id'] = empty($value) ? null : $value;
    }


    // Связь с научным руководителем
    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    // Связь с публикациями
    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'aspirant_publication');
    }

    // Связь с диссертациями
    public function dissertations()
    {
        return $this->hasMany(Dissertation::class);
    }
}