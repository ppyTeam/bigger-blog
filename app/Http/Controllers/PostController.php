<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnDataHelper;
use App\Repository\PostRepository;
use App\Transformers;

class PostController extends Controller
{
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
     * 文章列表控制器
     */
    public function index()
    {
        $posts = $this->postRepository->simplePaginate(5);
        $this->returnData['main'] = $posts;
        return $this->returnHelper->handlerItem($this->returnData, new Transformers\PostListTransformer(), 'blog.list');
    }

    /**
     * @param $id
     * @return
     */
    public function show($id)
    {
        $show_post = $this->postRepository->findOneBy('id', $id);
        if (empty($show_post)) {
            abort(404);
        }
        $this->returnData['main'] = $show_post;
        return $this->returnHelper->handlerItem($this->returnData, new Transformers\PostTransformer(), 'blog.show');
    }
}
