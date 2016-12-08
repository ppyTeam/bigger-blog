<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];
    protected $fillable = [
        'title',
        'content',
        'slug',
        'user_id',
        'category_id',
        'view_count',
        'vote_count',
        'status',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        //generate slug if not set
        if (!$this->exists) {
            $this->attributes['slug'] = str_slug($value);
        }
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
