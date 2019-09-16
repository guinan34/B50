<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    public function song()
    {
        return $this->belongsTo('App\song');
    }

    public function fanclub()
    {
        return $this->belongsTo('App\fanclub');
    }
}
