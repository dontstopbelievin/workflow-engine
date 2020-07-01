<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];
    // protected $fillable = [
    //     'name', 'accept_template', 'doc_path'
    // ];
    public function processes() {
        return $this->hasMany(Process::class);
    }
}