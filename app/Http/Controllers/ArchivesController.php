<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnDataHelper;
use App\Repository\PostRepository;
use App\Criteria;
use App\Transformers\PostListTransformer;

class ArchivesController extends Controller
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
     * Archives Page
     * @param int $page 分页
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1)
    {
        $posts = $this->postRepo->postSimplePaginate(50, $page, ['id', 'title', 'created_at']);
        $this->returnData['main'] = $this->returnHelper->transform($posts, new PostListTransformer(),'transformOutline');
        return $this->returnHelper->handler($this->returnData, 'archives.index');
    }


}
