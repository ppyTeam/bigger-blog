<?php
/**
 * Blog Setting Repository
 */

namespace App\Repository;

use App\Setting;

class SettingRepository extends IRepository
{
    /**
     * 模型实例
     * @var \App\Setting
     */
    protected $model;

    public function model()
    {
        return Setting::class;
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

    /**
     * 获取指定Tag下的所有设置项
     * @param string $tag
     * @return array
     */
    public function getTag($tag)
    {
        $settings = Setting::where('tag', $tag)->get();
        $returnArr = [];
        foreach ($settings as $setting) {
            $returnArr[$setting->key] = $setting->value;
        }
        return $returnArr;
    }

    /**
     * 设置指定key的值
     * @param string $key
     * @param string $value
     * @param string|null $tag 标签
     */
    public function set($key, $value, $tag = null)
    {
        $setting = Setting::firstOrNew(['key' => $key]);
        $setting->tag = $tag;
        $setting->value = $value;
        $setting->save();
    }

    /**
     * 删除指定key的设置项
     * @param string $key
     * @return bool|null
     */
    public function del($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting === null) return false;
        return $setting->delete();
    }

    /**
     * 删除指定Tag下的所有设置项
     * @param string $tag
     * @return bool|int
     */
    public function delTag($tag)
    {
        $settings = Setting::where('tag', $tag);
        if (!count($settings->get(['id']))) return false;
        return $settings->delete();
    }

}