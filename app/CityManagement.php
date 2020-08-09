<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CityManagement extends Model
{

    protected $table = 'city_managements';
    protected $gruarded = [];

    public function roles() {
        return $this->hasMany(Role::class);
    }
}
