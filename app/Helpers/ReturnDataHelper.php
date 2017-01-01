<?php
namespace App\Helpers;

/**
 * 返回数据处理类
 * Date: 2016/12/25 0025
 * Time: 22:36
 */
use App\Contracts\TransformerInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class ReturnDataHelper
{
    private $jsonConfig = null;
    private $prefix_url = null;
    private $is_mobile = null;


    public function initConfig($prefix_url, $is_mobile)
    {
        $this->prefix_url = $prefix_url;
        $this->is_mobile = $is_mobile;
    }

    /**
     * 获取前端Assets资源映射配置
     * @param string $prefix_url
     * @return array
     * @throws FileNotFoundException
     */
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

    /**
     * 返回接口数据或模板
     * @param $return_data
     * @param null $view_blade
     * @return \Illuminate\Contracts\View\Factory | \Illuminate\View\View
     */
    public function handler(&$return_data, $view_blade = null)
    {
        if (request()->headers->get('return_type') == 'api') {
            return $return_data;
        } else {
            $return_data['assets'] = $this->get_config($this->prefix_url);
            $return_data['is_mobile'] = $this->is_mobile;
            return view($view_blade, $return_data);
        }
    }

    /**
     * 返回Transformer处理后的接口数据
     * @param $source
     * @param TransformerInterface|null $transformer
     * @return mixed
     */
    public function transform($source, TransformerInterface $transformer = null)
    {
        if (request()->headers->get('return_type') == 'api' && $transformer !== null) {
            return $transformer->transform($source);
        } else {
            return $source;
        }
    }


}