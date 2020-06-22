<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    protected $fillable = [
        'field_name'
    ];

    public function process () {
        return $this->belongsTo(Process::class);
    }
}
