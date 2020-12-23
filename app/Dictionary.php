<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $guarded = [];

    public function selectOptions() {
        return $this->belongsToMany(SelectOption::class, 'dictionary_select_option', 'dictionary_id', 'select_option_id' );
    }
}
