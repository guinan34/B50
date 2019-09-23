<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class song extends Model
{
    public function getActressAttribute($value)
    {
        return explode(',', $value);
    }

    public function setActressAttribute($value)
    {
        $this->attributes['actress'] = implode(',', $value);
    }
}
