<?php
/**
 * Post list json data transformer.
 */

namespace App\Transformers;

use App\Contracts\TransformerInterface;


class PostListTransformer implements TransformerInterface
{

    public function transform($posts)
    {
        foreach ($posts as $collection_key => $post) {
            $posts[$collection_key] = [
                'id' => $post->id,
                'title' => $post->title,
                'content' => str_limit($post->content, 50, '...'),
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
            ];
        }
        return $posts;
    }
}