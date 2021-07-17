<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryKit;

class Group extends Model
{
    use SoftDeletes;
    use QueryKit;

    protected $table = "groups";

    /**
     * Get group's permission
     *
     * @return void
     */
    public function permissions()
    {
        return $this->hasMany(guardian('guardian.models.permissions'));
    }
}
