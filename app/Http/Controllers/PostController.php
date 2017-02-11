<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnDataHelper;
use App\Repository\PostRepository;
use App\Transformers;
use App\Criteria;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepo;

    public function __construct(PostRepository $postRepository, ReturnDataHelper $dataHelper)
    {
        $this->postRepo = $postRepository->pushCriteria(app(Criteria\ShowInSite::class));
        $this->returnHelper = $dataHelper;
    }

    /**
     * 文章列表
     * @param int $page 分页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($page = 1)
    {
        $posts = $this->postRepo->postPaginate(5, $page);
        $this->returnData['main'] = $this->returnHelper->transform($posts, new Transformers\PostListTransformer());
        return $this->returnHelper->handler($this->returnData, 'blog.list');
    }

    /**
     * 文章详情
     * @param int $id 文章id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $show_post = $this->postRepo->findOneBy('id', $id);
        if (empty($show_post)) {
            abort(404);
        }
        $this->returnData['main'] = $this->returnHelper->transform($show_post, new Transformers\PostTransformer());
        return $this->returnHelper->handler($this->returnData, 'blog.show');
    }
}
