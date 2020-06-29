<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{

    protected $fillable = [
        'name', 'deadline', 'deadline_until', 'accepted_template_id', 'rejected_template_id',
    ];
    public function fieldValues() {
        return $this->hasMany(FieldValue::class);
    }
    public function accepted_template() {
        return $this->belongsTo(Template::class, 'accepted_template_id');
    }
    public function rejected_template() {
        return $this->belongsTo(Template::class, 'rejected_template_id');
    }
}
