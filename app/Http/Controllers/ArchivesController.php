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
    protected $postRepository;
    protected $returnData;

    /**
     * @var ReturnDataHelper
     */
    protected $returnHelper;

    public function __construct(PostRepository $postRepository, ReturnDataHelper $dataHelper)
    {
        $this->postRepository = $postRepository;
        $this->postRepository->pushCriteria(app(Criteria\ShowInSite::class));
        $this->returnHelper = $dataHelper;
    }

    /**
     * Archives Page
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1)
    {
        $posts = $this->postRepository->postSimplePaginate(50, $page, ['id', 'title', 'created_at']);
        $this->returnData['main'] = $this->returnHelper->transform($posts, new PostListTransformer(),'transformOutline');
        return $this->returnHelper->handler($this->returnData, 'archives.index');
    }


}
