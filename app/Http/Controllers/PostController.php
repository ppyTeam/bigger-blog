<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnDataHelper;
use App\Repository\PostRepository;

class PostController extends Controller
{
    protected $postRepository;
    protected $returnData;
    /**
     * @var ReturnDataHelper
     */
    protected $dataHelper;

    public function __construct(PostRepository $postRepository, ReturnDataHelper $dataHelper)
    {
        $this->postRepository = $postRepository;
        $this->dataHelper = $dataHelper;
    }

    public function index()
    {
        $is_mobile = true;
        $this->returnData['main'] = $this->postRepository->simplePaginate(5);
        return $this->dataHelper->handler($this->returnData, config('app.url'), $is_mobile, 'blog.list');
    }

    public function show($id)
    {
        $is_mobile = true;
        $show_post = $this->postRepository->findOneBy('id', $id);
        if (empty($show_post)) {
            abort(404);
        }
        $this->returnData['main'] = $show_post;
        return $this->dataHelper->handler($this->returnData, config('app.url'), $is_mobile, 'blog.show');
    }
}
