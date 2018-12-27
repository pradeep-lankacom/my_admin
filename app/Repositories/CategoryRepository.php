<?php

namespace App\Repositories;


use App\Models\Category;
use App\Repositories\Contracts\CategoryInterface;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class CategoryRepository implements CategoryInterface
{


    protected $categories;

    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }




    /**Get Category list*/
    public function getCategoryList()
    {
        try {

            $allCategories =  $this->categories->tree();
            return $allCategories;

//            $categories = $this->categories
//                ->select(
//                    'categories.id',
//                    'categories.title',
//                    'categories.parent_id',
//                    'categories.description',
//                    'categories.image'
//                )
//                ->leftJoin('categories mainCat', 'categories.id', '=', 'mainCat.parent_id');
//
//            return Datatables::of($categories)
//                ->make(true);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::guard('admin')->user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    /**Get Main Category list*/
    public function getMainCategory()
    {
        try {

            $categories = $this->categories
                ->select(
                    'categories.id',
                    'categories.title'
                )
              ->where('parent_id',0)->get();
return $categories;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::guard('admin')->user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }




    /**Save category*/
    public function store($data)
    {
        try {
            if (!empty($data)) {
                $category = $this->categories;
                $category->title = $data['title'];
                $category->description = $data['description'];
                $category->parent_id = $data['parent_id'];
                $category->image = $data['image'];

                $category->save();


                return array('category' => $category, 'success' => true);
            }
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::guard('admin')->user()->id, 'msg' => "category store failed", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }




}
