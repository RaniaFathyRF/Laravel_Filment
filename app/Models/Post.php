<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
       return $this->belongsToMany(Category::class, 'post_categories', 'post_id','category_id' )
            ->withTimestamps();
    }

}
