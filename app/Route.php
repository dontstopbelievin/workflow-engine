<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $guarded = [];

    public function process() {
        return $this->belongsTo(Process::class);
    }
}
