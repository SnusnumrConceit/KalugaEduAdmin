<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['uuid', 'name', 'slug', 'parent_id'];

    protected $perPage = 10;

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s'
    ];

    /** проверить, работает ли связь */
    public function parent()
    {
        return $this->hasOne($this, 'id', 'parent_id');
    }
}
