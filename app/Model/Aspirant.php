<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'supervisor_id', 'full_name', 'specialty'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function dissertations()
    {
        return $this->hasMany(Dissertation::class);
    }

    public function publications()
    {
        return $this->belongsToMany(Publication::class, 'aspirant_publication');
    }
}