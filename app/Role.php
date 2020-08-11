<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'name'
    ];
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

    public function processes() {
        return $this->belongsToMany(Application::class)->withPivot('parent_role_id');;
    }

    public function children()
    {
        return $this->hasMany(Role::class,'parent_id');   
    }
}
