<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];

    public function scopeAccepted($query) {
        return $query->where('accept_template', 1);
    }
    public function scopeRejected($query) {
        return $query->where('accept_template', 0);
    }

    public function processes() {
        return $this->hasMany(Process::class);
    }
}