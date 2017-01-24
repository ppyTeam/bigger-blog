<?php

namespace App\Repository;


use App\Post;

class PostRepository extends IRepository
{
    /**
     * 模型实例
     * @var \App\Post
     */
    protected $model;

    public function model()
    {
        return Post::class;
    }

    /**
     * 文章分页
     * @param int $limit
     * @param int $page
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function postPaginate($limit = 10, $page = 1, $columns = ['*'])
    {
        //$this->applyCriteria();
        //查询文章并分页
        //$posts = Post::where('updated_at', '<=', Carbon::now())
        $posts = $this->orderBy('id', 'desc')->paginate($limit, $columns, $page);
        $posts = $this->getPostOtherInfo($posts);
        return $posts;
    }

    /**
     * 文章简单分页
     * @param int $limit
     * @param int $page
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function postSimplePaginate($limit = 10, $page = 1, $columns = ['*'])
    {

        return $this->orderBy('id', 'desc')->simplePaginate($limit, $columns, $page);
    }

    /**
     * 获取文章的分类和标签信息
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Pagination\LengthAwarePaginator $collection
     * @return mixed
     */
    public function getPostOtherInfo($collection)
    {
        //懒惰渴求式加载
        $collection->load([
            'category' => function ($query) {
                $query->where('status', 0);
            },
            'tags' => function ($query) {
                $query->where('status', 0);
            },
        ]);
        return $collection;
    }

}