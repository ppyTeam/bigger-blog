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
        $return_arr['assets-getter'] = Storage::get('assets-mobile-getter.html'); // assets mobile getter html

        // TODO 返回数据为object，要格式为字符串。如以下格式：{ type: 'frontend', host: '', assets: { appjs: { hash: 'xxxx', url: '能直接和host拼接的部分'}, commonjs: { hash: 'xxxxx', url: 'xx.js'}, {...} } }
        $assets_hash = json_decode(Storage::get('assets-hash.json'));
        $assets_hash = "{" .
            "host: '" . config('app.url') . "/'," .
            "type: 'frontend'," .
            "assets: {" .
                "appjs: { hash: '" . $assets_hash -> frontend -> appjs -> hash ."', url: '" . $assets_hash -> frontend -> appjs -> filename . "' }," .
                "commonjs: { hash: '" . $assets_hash -> frontend -> commonjs -> hash ."', url: '" . $assets_hash -> frontend -> commonjs -> filename . "' }," .
                "appcss: { hash: '" . $assets_hash -> frontend -> appcss -> hash ."', url: '" . $assets_hash -> frontend -> appcss -> filename . "' }," .
            "}" .
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
