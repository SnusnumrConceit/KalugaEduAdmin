<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'url', 'category_id'];

    protected $perPage = 10;

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
