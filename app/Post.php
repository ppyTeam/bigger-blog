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
    protected $appends = ['neighbour'];

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

    /**
     * 获取相邻的文章数据
     * @return array
     */
    public function getNeighbourAttribute()
    {
        $neighbour_posts = Post::whereIn('id', [$this->id - 1, $this->id + 1])->get(['id', 'title']);
        $return_posts = [
            'prev' => null,
            'next' => null,
        ];
        foreach ($neighbour_posts as $each_post) {
            if ($this->id - 1 === $each_post->id) {
                $return_posts['prev'] = [
                    'id' => $each_post->id,
                    'title' => $each_post->title,
                ];
            } elseif ($this->id + 1 === $each_post->id) {
                $return_posts['next'] = [
                    'id' => $each_post->id,
                    'title' => $each_post->title,
                ];
            }
        }
        return $return_posts;
    }
}
