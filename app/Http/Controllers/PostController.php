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
        $return_arr['content'] = '这是列表内容';


        // TODO 返回数据为object，要格式为字符串。如以下格式：{ type: 'frontend', host: '', assets: { appjs: { hash: 'xxxx', url: '能直接和host拼接的部分'}, commonjs: { hash: 'xxxxx', url: 'xx.js'}, {...} } }
        $assets_hash = json_decode(Storage::get('assets-hash.json'));


        $return_arr['assets-hash'] = [
            'host' => config('app.url'),
            'type' => 'frontend',
            'assets' => [
                'appjs' => [
                    'hash' => $assets_hash->frontend->appjs->hash,
                    'url' => $assets_hash->frontend->appjs->filename,
                ],
                'commonjs' => [
                    'hash' => $assets_hash->frontend->commonjs->hash,
                    'url' => $assets_hash->frontend->commonjs->filename,
                ],
                'appcss' => [
                    'hash' => $assets_hash->frontend->appcss->hash,
                    'url' => $assets_hash->frontend->appcss->filename,
                ],
            ],
        ];

        // TODO <?php 希望能传入参数自动获取
        $return_arr['assets-appcss'] = config('app.url') . '/' . $assets_hash->frontend->appcss->filename;
        $return_arr['assets-commonjs'] = config('app.url') . '/' . $assets_hash->frontend->commonjs->filename;
        $return_arr['assets-appjs'] = config('app.url') . '/' . $assets_hash->frontend->appjs->filename;

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
