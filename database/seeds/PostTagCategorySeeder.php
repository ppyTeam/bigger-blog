<?php

use App\Post;
use App\Tag;
use Illuminate\Database\Seeder;

class PostTagCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::orderBy('id', 'desc')->limit(10)->get();
        $tagsIdArr = Tag::orderBy('id', 'desc')->limit(5)->pluck('id');
        $categoryIdArr = Tag::orderBy('id', 'desc')->limit(5)->pluck('id');
        if (empty($posts) || empty($tagsIdArr) || empty($categoryIdArr)) {
            return;
        }
        foreach ($posts as $post) {
            //has tag
            if (!$post->tags->count()) {
                //how many tags would be create
                $newTagCount = mt_rand(0, count($tagsIdArr) - 1);
                $tagIdArr = [];
                for ($i = 0; $i < $newTagCount; $i++) {
                    $tagId = $tagsIdArr[mt_rand(0, count($tagsIdArr) - 1)];
                    $tagIdArr[$tagId] = $tagId;
                }
                $post->tags()->attach(array_keys($tagIdArr), ['created_at' => date_create()]);
            }
            //has category
            if (empty($post->category()->first())) {
                $newCategoryId = mt_rand(0, count($categoryIdArr) - 1);
                $post->category_id = $newCategoryId;
                $post->save();
            }
        }
    }
}
