<?php

namespace App\Http\Controllers;

use App\Events\ReturnDataEvent;
use App\Repository\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
//        $return_arr = $this->postRepository->simplePaginate(5);
        $return_arr['content']='这是列表内容';
        $res = event(new ReturnDataEvent($return_arr));
        return $res[0];
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
