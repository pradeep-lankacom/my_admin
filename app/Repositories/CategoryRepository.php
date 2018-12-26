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




    /**Get user list*/
    public function getCategoryList()
    {
        try {

            $categories = $this->categories
                ->select(
                    'categories.id',
                    'categories.title',
                    'mainCat.title as mainCategory',
                    'categories.description',
                    'categories.image'
                )
                ->leftJoin('categories mainCat', 'categories.id', '=', 'mainCat.parent_id');

            return Datatables::of($categories)
                ->make(true);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::guard('admin')->user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }


    /**Save user*/
    public function store($data)
    {
        try {
            if (!empty($data)) {
                $user = $this->admin_user;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = $data['password'];
                $user->image = $data['image'];
                $user->remember_token = $data['remember_token'];
                $user->status_id = $data['status_id'];

                $user->save();

                $user->roles()->sync($data['role_id'], false);

                return array('user' => $user, 'success' => true);
            }
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::guard('admin')->user()->id, 'msg' => "User store failed", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }




}
