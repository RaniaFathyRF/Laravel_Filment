<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function parent(){
       return $this->belongsTo(Category::class, 'parent_id');
}
    public function post()
    {
       return $this->belongsToMany(Post::class,'post_categories',  'category_id','post_id')
            ->withTimestamps();
    }

}
