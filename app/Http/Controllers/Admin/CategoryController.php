<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            return view('admin.user.list')->with($data);
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

            return $this->admin_user->getUserList();

        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to list users.", "error" => $e->getMessage()));
        }
    }


    public function create()
    {
        try {
            $roles = $this->role->getRolesToUsers();
            return view('admin.user.create', ['roles' => $roles]);
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to redirect to the create user form.", "error" => $e->getMessage()));
        }
    }


    /**
     * Save user.
     */
    public function store(StoreUser $request)
    {
        try {
            $validated = $request->validated();

            if (!empty($validated)) {
                //Generating a password
                $length = 10;
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';



                $requestData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'role_id' => $validated['role_id'],
                    'password' => bcrypt(substr(str_shuffle(str_repeat($pool, $length)), 0, $length)),
                    'image' => !empty($validated['image']) ? getFileName('profile_image', $validated['image']) : null,
                    'remember_token' => "",
                    'status_id' => 0,
                ];

                $result = $this->admin_user->store($requestData);

                if ($result['success']) {
//                    $token = app('auth.password.broker')->createToken($result['user']);
//                    $user = $result['user'];
//                    $request["token"] = $token;
//                    $data = array(
//                        'token' => $token,
//                        'name' => $user->name
//                    );
//
//                    Mail::to($user->email)->queue(new ConfirmationMail($data));
                    return response()->json(['status' => true, 'message' => 'User has been created successfully.']);

                } else {
                    return response()->json(['status' => false, 'message' => 'Oops.. An Error Occurred, Please Try Again.']);
                }
            }
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to store user.", "error" => $e->getMessage()));
        }
    }


}
