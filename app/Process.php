<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{

    protected $fillable = [
        'name', 'deadline'
    ];
    public function fieldValues() {
        return $this->hasMany(FieldValue::class);
    }
    public function templates() {
        return $this->hasMany(Template::class);
    }
}
