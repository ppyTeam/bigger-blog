<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Helpers\ReturnDataHelper;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Transformers\PostListTransformer;

class TagController extends Controller
{
    /**
     * @var TagRepository
     */
    protected $tagRepo;
    /**
     * @var PostRepository
     */
    protected $postRepo;

    public function __construct(TagRepository $tagRepository, PostRepository $postRepository, ReturnDataHelper $dataHelper)
    {
        $this->tagRepo = $tagRepository->pushCriteria(app(Criteria\ShowInSite::class));
        $this->postRepo = $postRepository->pushCriteria(app(Criteria\ShowInSite::class));
        $this->returnHelper = $dataHelper;
    }

    /**
     * 所有tag列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $tags = $this->tagRepo->all();
        $this->returnData['main'] = $tags;
        return $this->returnHelper->handler($this->returnData, 'tag.index');
    }

    /**
     * 指定tag下的文章列表
     * @param string $tagName tag名称
     * @param int $page 分页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($tagName, $page = 1)
    {

        $tag = $this->tagRepo->findOneBy('tag_name', $tagName, '=', ['id', 'tag_name']);
        if (empty($tag)) {
            abort(404);
        }
        $posts = $this->postRepo->getPostOtherInfo($this->tagRepo->getTagPosts($tag)->Paginate(10, ['*'], $page));
        $this->returnData = [
            'tag_id' => $tag->id,
            'tag_name' => $tag->tag_name,
            'main' => $this->returnHelper->transform($posts, new PostListTransformer()),
        ];
        return $this->returnHelper->handler($this->returnData, 'tag.show');

    }


}
