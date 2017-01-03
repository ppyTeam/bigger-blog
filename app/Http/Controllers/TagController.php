<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Helpers\ReturnDataHelper;
use App\Repository\TagRepository;
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


}
