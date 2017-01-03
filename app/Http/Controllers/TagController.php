<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Helpers\ReturnDataHelper;
use App\Repository\TagRepository;
use App\Transformers\PostListTransformer;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * @var TagRepository
     */
    protected $tagRepository;
    protected $returnData;

    /**
     * @var ReturnDataHelper
     */
    protected $returnHelper;

    public function __construct(TagRepository $tagRepository, ReturnDataHelper $dataHelper)
    {
        $this->tagRepository = $tagRepository;
        $this->tagRepository->pushCriteria(app(Criteria\ShowInSite::class));
        $dataHelper->initConfig(config('app.url'), false);
        $this->returnHelper = $dataHelper;
    }

    public function index()
    {
        $tags = $this->tagRepository->all();
        $this->returnData['main'] = $tags;
        return $this->returnHelper->handler($this->returnData, 'tag.index');
    }

    public function show($tagName, $page = 1)
    {

        $tag = $this->tagRepository->findOneBy('tag_name', $tagName, '=', ['id', 'tag_name']);
        if (empty($tag)) {
            abort(404);
        }
        $posts = $this->tagRepository->getTagPosts($tag)->paginate(10, ['*'], $page);

        $this->returnData = [
            'tag_id' => $tag->id,
            'tag_name' => $tag->tag_name,
            'main' => $this->returnHelper->transform($posts, new PostListTransformer()),
        ];
        return $this->returnHelper->handler($this->returnData, 'tag.show');

    }


}
