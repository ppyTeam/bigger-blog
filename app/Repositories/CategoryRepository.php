<?php
/**
 * Category Repository
 */

namespace App\Repository;

use App\Category;

class CategoryRepository extends IRepository
{
    /**
     * 模型实例
     * @var \App\Category
     */
    protected $model;

    public function model()
    {
        return Category::class;
    }

}