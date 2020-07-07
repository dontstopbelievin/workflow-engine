<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $guarded = [];
    public function fieldValues() {
        return $this->hasMany(FieldValue::class);
    }
    public function handbook() {
        return $this->belongsTo(Handbook::class);
    }
    public function accepted_template() {
        return $this->belongsTo(Template::class, 'accepted_template_id');
    }
    public function rejected_template() {
        return $this->belongsTo(Template::class, 'rejected_template_id');
    }
}
