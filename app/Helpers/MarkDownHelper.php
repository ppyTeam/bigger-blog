<?php
/**
 * MarkDown处理类
 * 扩展方法: https://github.com/erusev/parsedown/wiki/Tutorial:-Create-Extensions
 * Date: 2017/2/2 0002
 * Time: 17:04
 */

namespace App\Helpers;


class MarkDownHelper extends \Parsedown
{
    //TODO: Extend for parsedown

    public function __construct()
    {
        $this->setBreaksEnabled(true);
    }
}