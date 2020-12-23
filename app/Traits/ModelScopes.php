<?php

namespace App\Traits;

trait ModelScopes
{
    public function scopeAccepted($query)
    {
        return $query->where('accept_template', 1);
    }

    public function scopeRejected($query)
    {
        return $query->where('accept_template', 0);
    }
}
