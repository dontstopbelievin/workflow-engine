<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    public function fieldValues() {
        return $this->hasMany(FieldValue::class);
    }
}
