<?php
/**
 * Blog Nav Repository
 */

namespace App\Repository;

use App\Setting;
use App\Nav;

class NavRepository extends IRepository
{
    /**
     * 模型实例
     * @var \App\Nav
     */
    protected $model;

    public function model()
    {
        return Nav::class;
    }


    public function getAllNav()
    {
        $NavCollection = $this->all(['name', 'url', 'flag', 'type', 'icon']);
        $NavCollection->transform(function ($item) {
            $item['flag'] = $item['flag'] ? 'true' : 'false';
            return $item;
        });
        return [
            'nav' => $NavCollection->filter(function ($value) {
                return $value['type'] == 0;
            }),
            'socially' => $NavCollection->filter(function ($value) {
                return $value['type'] == 1;
            })
        ];
    }

    /**
     * 获取指定key的设置
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return Setting::where('key', $key)->first(['value'])->value;
    }


}