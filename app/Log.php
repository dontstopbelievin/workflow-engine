<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function table() {
        return $this->belongsTo(CreatedTable::class, 'table_id');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
