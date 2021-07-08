<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = "roles";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id'
    ];

    /**
     * Get the owning roleable model.
     */
    public function roleable()
    {
        return $this->morphTo();
    }

    /**
     * Get permissions
     */
    public function permissions()
    {
        return $this->hasMany('App\Models\Permission', 'group_id');
    }
}
