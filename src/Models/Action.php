<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryKit;

class Action extends Model
{
    use SoftDeletes;
    use QueryKit;

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
