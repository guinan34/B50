<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obsolete extends Model
{
    public function project()
    {
        return $this->belongsTo('App\project');
    }
    
    public function song()
    {
        return $this->belongsTo('App\song');
    }

    public function fanclub()
    {
        return $this->belongsTo('App\fanclub');
    }
}
