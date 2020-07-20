<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function applications() {
        return $this->hasMany(Application::class);
    }
}
