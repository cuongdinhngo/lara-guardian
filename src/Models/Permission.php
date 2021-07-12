<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $table = "permissions";

    /**
     * Get group
     *
     * @return void
     */
    public function group()
    {
        return $this->belongsTo(guardian('guardian.models.groups'));
    }

    /**
     * Get page
     *
     * @return void
     */
    public function page()
    {
        return $this->belongsTo(guardian('guardian.models.pages'));
    }
}
