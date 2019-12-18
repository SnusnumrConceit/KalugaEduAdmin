<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['uuid', 'name', 'slug', 'parent_id'];

    protected $perPage = 10;

    /** проверить, работает ли связь */
    public function parent()
    {
        return $this->hasOne($this, 'parent_id', 'id');
    }
}
