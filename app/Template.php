<?php

namespace App;

use App\Traits\ModelScopes;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use ModelScopes;
    protected $guarded = [];

    public function processes() {
        return $this->hasMany(Process::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function doc() {
        return $this->belongsTo(TemplateDoc::class, 'template_doc_id');
    }
}
