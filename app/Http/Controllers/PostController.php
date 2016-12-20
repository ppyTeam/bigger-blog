<?php

namespace App\Http\Controllers;

use App\Events\ReturnDataEvent;
use App\Repository\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // TODO
        $return_arr['assets-getter'] = Storage::get('assets-getter.js'); // assets getter js

        // TODO 返回数据为object，要格式为字符串。如：{ type: 'frontend', cdn: '', assets: [ { name: 'appjs', hash: 'xxxx'}, { name: 'commonjs', hash: 'xxxxx'}, {...}] }
        $assets_hash = json_decode(Storage::get('assets-hash.json'));
        $assets_hash = "{" .
            "cdn: ''," .
            "type: 'frontend'," .
            "assets: [" .
                "{ name: 'appjs', hash: '" . $assets_hash -> frontend -> appjs -> hash ."' }," .
                "{ name: 'commonjs', hash: '" . $assets_hash -> frontend -> commonjs -> hash ."' }," .
                "{ name: 'appcss', hash: '" . $assets_hash -> frontend -> appcss -> hash ."' }" .
            "]" .
        "}";
        $return_arr['assets-hash'] = $assets_hash;

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
