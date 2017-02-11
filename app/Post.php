<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Facades\MarkDown;

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

    public function getContentAttribute($value)
    {
        return MarkDown::parse($value);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getSummaryAttribute()
    {
        $index = mb_strpos($this->content, '<!--more-->');
        if ($index !== false) {
            return mb_substr($this->content, 0, $index) . '...';
        } elseif (mb_strlen($this->content) >= 1000) {
            return mb_substr($this->content, 0, 1000) . '...';
        } else {
            return $this->content;
        }
    }

    /**
     * 获取相邻的文章数据
     * @return array
     */
    public function getNeighbourAttribute()
    {
        $prev_post = Post::where('id', '<', $this->id)->orderBy('id', 'desc')->first(['id', 'title']);
        $next_post = Post::where('id', '>', $this->id)->orderBy('id', 'asc')->first(['id', 'title']);
        return [
            'prev' => $prev_post ? $prev_post->toArray() : null,
            'next' => $next_post ? $next_post->toArray() : null,
        ];
    }
}
