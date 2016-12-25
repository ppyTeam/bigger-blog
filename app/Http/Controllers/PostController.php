<?php

namespace App\Http\Controllers;

use App\Events\ReturnDataEvent;
use App\Helpers\AssetsData;
use App\Repository\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;
    protected $returnData;

    public function __construct(PostRepository $postRepository, AssetsData $assetsData)
    {
        $this->postRepository = $postRepository;
        $this->returnData['assets'] = $assetsData->get_config(config('app.url'));
        $this->returnData['is_mobile'] = true;
    }

    public function index()
    {
//      $return_arr = $this->postRepository->simplePaginate(5);
        $this->returnData['content'] = '这是列表内容';
        $res = view('index', $this->returnData);
        return $res;

    }

    public function show($id)
    {
        $show_post = $this->postRepository->findOneBy('id', $id);
        if (empty($show_post)) {
            abort(404);
        }
        return view('post.show', compact('show_post'));
    }
}
