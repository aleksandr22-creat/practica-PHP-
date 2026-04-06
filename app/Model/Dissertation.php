<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Dissertation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'aspirant_id', 'topic', 'approval_date',
        'status', 'vak_specialty'
    ];

    public function aspirant()
    {
        return $this->belongsTo(Aspirant::class);
    }
}