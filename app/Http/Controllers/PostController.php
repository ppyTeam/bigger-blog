<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnDataHelper;
use App\Repository\PostRepository;
use App\Transformers;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepository;
    protected $returnData;

    /**
     * @var ReturnDataHelper
     */
    protected $returnHelper;

    public function __construct(PostRepository $postRepository, ReturnDataHelper $dataHelper)
    {
        $this->postRepository = $postRepository;
        $dataHelper->initConfig(config('app.url'), false);
        $this->returnHelper = $dataHelper;
    }

    /**
     * 文章列表
     */
    public function index()
    {
        $posts = $this->postRepository->simplePaginate(5);
        $this->returnData['main'] = $this->returnHelper->transform($posts, new Transformers\PostListTransformer());
        return $this->returnHelper->handler($this->returnData, 'blog.list');
    }

    /**
     * 文章详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $show_post = $this->postRepository->findOneBy('id', $id);
        if (empty($show_post)) {
            abort(404);
        }
        $this->returnData['main'] = $this->returnHelper->transform($show_post, new Transformers\PostTransformer());
        return $this->returnHelper->handler($this->returnData, 'blog.show');
    }
}
