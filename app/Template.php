<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    protected $fillable = [
        'name', 'accept_template', 'doc_path'
    ];
    public function process() {
        return $this->belongsTo(Process::class);
    }
}