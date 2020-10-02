<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function ScopeSearch($query,$q) {
        return $query->where('name','LIKE','%'.$q.'%');
    }

    public function cityManagement() {
        return $this->belongsTo(CityManagement::class);
    }


}
