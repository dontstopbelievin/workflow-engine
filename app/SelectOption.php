<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectOption extends Model
{
    protected $guarder = [];

    public function dictionaries() {
        return $this->belongsToMany(Dictionary::class, 'dictionary_select_option', 'select_option_id', 'dictionary_id');
    }
}
