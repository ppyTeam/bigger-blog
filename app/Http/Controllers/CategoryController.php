<?php

namespace App\Http\Controllers;

use App\Helpers\ReturnDataHelper;
use App\Repository\CategoryRepository;
use App\Transformers\PostListTransformer;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    protected $returnData;

    /**
     * @var ReturnDataHelper
     */
    protected $returnHelper;

    public function __construct(CategoryRepository $categoryRepository, ReturnDataHelper $dataHelper)
    {
        $this->categoryRepository = $categoryRepository;
        $dataHelper->initConfig(config('app.url'), false);
        $this->returnHelper = $dataHelper;
    }

    public function index()
    {
        $categories = $this->categoryRepository->all();
        $this->returnData['main'] = $this->returnHelper->transform($categories);
        return $this->returnHelper->handler($this->returnData, 'category.index');
    }

    public function show($categoryId)
    {
        $category = $this->categoryRepository->find($categoryId, ['id', 'category_name']);
        if (empty($category)) {
            abort(404);
        }
        $posts = $category->posts;
        $this->returnData = [
            'category_id' => $category->id,
            'category_name' => $category->category_name,
            'main' => $this->returnHelper->transform($posts, new PostListTransformer(), 'transformOutline'),
        ];
        return $this->returnHelper->handler($this->returnData, 'category.show');
    }

}
