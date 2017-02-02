<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Helpers\ReturnDataHelper;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Transformers\PostListTransformer;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepo;
    /**
     * @var PostRepository
     */
    protected $postRepo;

    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository, ReturnDataHelper $dataHelper)
    {
        $ShowInSiteOjb = app(Criteria\ShowInSite::class);
        $this->categoryRepo = $categoryRepository->pushCriteria($ShowInSiteOjb);
        $this->postRepo = $postRepository->pushCriteria($ShowInSiteOjb);
        $this->returnHelper = $dataHelper;
    }

    /**
     * 所有分类列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepo->all();
        $this->returnData['main'] = $this->returnHelper->transform($categories);
        return $this->returnHelper->handler($this->returnData, 'category.index');
    }

    /**
     * 某个分类下的文章列表
     * @param string $categoryName 分类名称
     * @param int $page 分页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($categoryName, $page = 1)
    {
        $category = $this->categoryRepo->findOneBy('category_name', $categoryName, '=', ['id', 'category_name']);
        if (empty($category)) {
            abort(404);
        }
        $posts = $this->postRepo->findWhere(['category_id' => $category->id], null)->postPaginate(10, $page);
        $this->returnData = [
            'category_id' => $category->id,
            'category_name' => $category->category_name,
            'main' => $this->returnHelper->transform($posts, new PostListTransformer()),
        ];
        return $this->returnHelper->handler($this->returnData, 'category.show');
    }

}
