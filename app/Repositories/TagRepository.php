<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 2017/1/3 0003
 * Time: 22:25
 */

namespace App\Repository;


use App\Tag;

class TagRepository extends IRepository
{
    /**
     * 模型实例
     * @var \App\Tag
     */
    protected $model;

    public function model()
    {
        return Tag::class;
    }


    /**
     * 获取一个标签下的所有文章
     * @param $tag
     * @return mixed
     */
    public function getTagPosts($tag)
    {
        return $tag->posts();
    }

}