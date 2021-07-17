<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\QueryKit;

class Page extends Model
{
    use SoftDeletes;
    use QueryKit;

    protected $table = "pages";
}
