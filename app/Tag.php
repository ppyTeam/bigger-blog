<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = ['tag_name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function getTagsInfoAttribute()
    {

        return ['id' => $this->id, 'tag_name' => $this->tag_name];
    }
}
