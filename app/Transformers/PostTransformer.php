<?php
/**
 * Post show page json data transformer.
 */
namespace App\Transformers;

use App\Contracts\TransformerInterface;

class PostTransformer implements TransformerInterface
{

    public function transform($post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'slug' => $post->slug,
            'user_id' => $post->user_id,
            'category_id' => $post->category_id,
            'category_name' => $post->category->category_name,
            'view_count' => $post->view_count,
            'vote_count' => $post->vote_count,
            'created_at' => $post->created_at->toDateTimeString(),
            'updated_at' => empty($post->updated_at) ? null : $post->updated_at->toDateTimeString(),
            'tags' => $post->tags->map(function ($tag) {
                return $tag->TagsInfo;
            }),
            'neighbour' => $post->Neighbour,
        ];
    }

}