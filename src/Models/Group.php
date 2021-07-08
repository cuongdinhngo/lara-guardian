<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $table = "groups";

    public function permissions()
    {
        return $this->hasMany('App\Models\Permissions');
    }
}
