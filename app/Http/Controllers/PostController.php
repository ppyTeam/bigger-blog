<?php

namespace App\Http\Controllers;

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
        $posts = $this->postRepository->simplePaginate(5);
        return view('post.index', compact('posts'));
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
