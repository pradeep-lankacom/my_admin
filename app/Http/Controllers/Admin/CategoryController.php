<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\StoreUser;
use App\Repositories\Contracts\AdminInterface;
use App\Repositories\Contracts\CategoryInterface;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

    protected $admin_user;
    protected $category;

	public function __construct( AdminInterface $admin_user,
                                 CategoryInterface $category)
	{
	    $this->admin_user=$admin_user;
	    $this->category=$category;
        $this->middleware('auth:admin');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */


    public function index() {
        try {
            //  echo Auth::guard('admin')->user()->id;

            $data['page_title']="test";
            $data['page_description']="test";
            $data['categories']=$this->category->getCategoryList();

            return view('admin.category.list')->with($data);
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to list roles.", "error" => $e->getMessage()));
        }
    }

    /**
     * Retrieving user list from the database.
     */
    public function getCategoryList()
    {
        try {
            $categories=array();
            $category=$this->category->getCategoryList();
            foreach($category as $item){
                $subcategories=array();
                foreach($item['children'] as $child){
                    $subcategories[]=['name'=>$child->title,"id"=>$child->id];
                }
                $categories[]=['name'=>$item->title,"id"=>$item->id,"children"=>$subcategories];
                unset($subcategories);
            }

            return $categories;

        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to list Category.", "error" => $e->getMessage()));
        }
    }


    public function create()
    {
        try {
            $mainCategory = $this->category->getMainCategory();
          // print_r($mainCategory);
            return view('admin.category.create', ['mainCategory' => $mainCategory]);
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to redirect to the create user form.", "error" => $e->getMessage()));
        }
    }


    /**
     * Save user.
     */
    public function store(StoreCategory $request)
    {
        try {

            $validated = $request->validated();

            if (!empty($validated)) {



                $requestData = [
                    'title' => $validated['title'],
                    'description' => $request['description'],
                    'parent_id' => $request['parent_id'],
                    'image' => !empty($validated['image']) ? getFileName('category_image', $validated['image']) : null,

                ];

                $result = $this->category->store($requestData);

                if ($result['success']) {
                    return response()->json(['status' => true, 'message' => 'Category has been created successfully.']);

                } else {
                    return response()->json(['status' => false, 'message' => 'Oops.. An Error Occurred, Please Try Again.']);
                }
            }
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to store Category.", "error" => $e->getMessage()));
        }
    }


}
