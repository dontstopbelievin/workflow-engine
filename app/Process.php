<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $guarded = [];


    public function accepted_template() {
        return $this->belongsTo(Template::class, 'accepted_template_id');
    }
    public function rejected_template() {
        return $this->belongsTo(Template::class, 'rejected_template_id');
    }

    public function routes() {
        return $this->hasMany(Route::class);
    }
    public function roles() {
        return $this->belongsToMany(Role::Class)->withPivot('parent_role_id');
    }
}
