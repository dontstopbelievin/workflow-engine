<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handbook extends Model
{
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function process() {
        return $this->belongsTo(Process::class);
    }

}
