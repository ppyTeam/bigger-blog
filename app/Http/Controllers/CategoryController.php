<?php

namespace App\Http\Controllers;

use App\Criteria;
use App\Helpers\ReturnDataHelper;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Transformers\PostListTransformer;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var PostRepository
     */
    protected $postRepository;
    protected $returnData;

    /**
     * @var ReturnDataHelper
     */
    protected $returnHelper;

    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository, ReturnDataHelper $dataHelper)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryRepository->pushCriteria(app(Criteria\ShowInSite::class));
        $this->postRepository = $postRepository;
        $this->postRepository->pushCriteria(app(Criteria\ShowInSite::class));
        $dataHelper->initConfig(config('app.url'), false);
        $this->returnHelper = $dataHelper;
    }

    public function index()
    {
        $categories = $this->categoryRepository->all();
        $this->returnData['main'] = $this->returnHelper->transform($categories);
        return $this->returnHelper->handler($this->returnData, 'category.index');
    }

    public function show($categoryName, $page = 1)
    {
        $category = $this->categoryRepository->findOneBy('category_name', $categoryName, '=', ['id', 'category_name']);
        if (empty($category)) {
            abort(404);
        }
        $posts = $this->postRepository->findWhere(['category_id' => $category->id], null)->simplePaginate(10, $page);
        $this->returnData = [
            'category_id' => $category->id,
            'category_name' => $category->category_name,
            'main' => $this->returnHelper->transform($posts, new PostListTransformer()),
        ];
        return $this->returnHelper->handler($this->returnData, 'category.show');
    }

}
