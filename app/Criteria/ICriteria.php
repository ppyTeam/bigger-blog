<?php
/**
 * Created by PhpStorm.
 * User: chenyi
 * Date: 2016/12/8 0008
 * Time: 23:11
 */

namespace App\Criteria;

use App\Contracts\RepositoryInterface;

abstract class ICriteria
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public abstract function apply($model, RepositoryInterface $repository);
}