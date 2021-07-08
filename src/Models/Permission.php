<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $table = "permissions";

    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}
