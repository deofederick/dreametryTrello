<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function boardlist(){
        return $this->hasMany('App\BoardList');
    }
}
