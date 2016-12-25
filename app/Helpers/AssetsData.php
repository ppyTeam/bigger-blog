<?php
namespace App\Helpers;

/**
 * 前端Assets资源映射配置类
 * Date: 2016/12/25 0025
 * Time: 22:36
 */
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class AssetsData
{
    private $jsonConfig = null;

    public function get_config($prefix_url)
    {
        if (null === $this->jsonConfig) {
            $this->jsonConfig = json_decode(Storage::get('assets-hash.json'), true);
            if (empty($this->jsonConfig)) {
                throw new FileNotFoundException('Assets file not found!');
            }
        }
        $this->jsonConfig['url'] = $prefix_url . '/';
        return $this->jsonConfig;
    }

}