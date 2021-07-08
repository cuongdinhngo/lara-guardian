<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;

    protected $table = "actions";

    /**
     * Find action by alias
     *
     * @param string $alias
     *
     * @return Action
     */
    public static function findByAlias(string $alias)
    {
        $object = new static;
        return $object->firstWhere('alias', $alias);
    }
}
