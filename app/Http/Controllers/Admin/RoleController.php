<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\Contracts\RoleInterface;
use App\Repositories\Contracts\PermissionInterface;
use App\Http\Requests\StoreRole;
use App\Http\Controllers\Controller;
use \Crypt;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    protected $role;
    protected $permission;

    public function __construct(
        RoleInterface $role,
        PermissionInterface $permission
      ) {
        $this->role = $role;
        $this->permission = $permission;
      }

    public function index()
    {
      try {
        //  echo Auth::guard('admin')->user()->id;

          $data['page_title']="test";
          $data['page_description']="test";
          return view('admin.role.list')->with($data);
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to list roles.", "error" => $e->getMessage()));
      }
    }

    public function getRoleList()
    {
        try {
          return $this->role->getRoleList();
        } catch (\Exception $e) {
          \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to list roles.", "error" => $e->getMessage()));
        }
    }

    public function create()
    {
      try {
        $permissions = $this->permission->getAllPermissions();
        $userPermission = [];
        $id = null;
        $show = true;
        return view('admin.role.create',
            [
               'permissions' => $permissions,
               'userPermission' => $userPermission,
                'id' => $id,
                'show' => $show,
            ]
        );
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to create role.", "error" => $e->getMessage()));
      }
    }

    public function store(StoreRole $request)
    {
      try {
        $validated = $request->validated();

        if ($request->is('admin/roles/store')) {

            $result = $this->role->store($request);

            if ($result['success']) {
              return response()->json(['status' => true, 'message' => 'Role has been successfully Created.']);
            } else {
              return response()->json(['status' => false, 'message' => 'Oops.. An Error Occurred, Please Try Again.']);
            }
          }else{
            return response()->json(['status' => false, 'message' => 'Oops.. An Error Occurred, Please Try Again.']);
        }

      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to store role.", "error" => $e->getMessage()));
      }
    }

    public function show($id)
    {
      try {
        $role = $this->role->show($id);
        $permissions = $this->permission->getAllPermissions();
        $userPermission = $role->permissions->pluck('id','id')->toArray();
        $show = false;
        return view('role.create',
            [
               'permissions' => $permissions,
               'role' => $role,
               'userPermission' => $userPermission,
               'show' => $show
            ]
        );
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to show role.", "error" => $e->getMessage()));
      }
    }

    public function edit($id)
    {
      try {
        $role = $this->role->edit($id);
        $permissions = $this->permission->getAllPermissions();
        $userPermission = $role->permissions->pluck('id','id')->toArray();
        $id = Crypt::encrypt($id);
        $show = true;
        return view('role.create',
            [
               'permissions' => $permissions,
               'role' => $role,
               'id' => $id,
               'userPermission' => $userPermission,
               'show' => $show
            ]
        );
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to edit role.", "error" => $e->getMessage()));
      }
    }

    public function update(StoreRole $request)
    {
      try {
        $validated = $request->validated();
        $id = Crypt::decrypt($request->input('id'));

        if ($request->is('roles/update')) {

            $data = [
              //  'name' => $request->name,
                'description' => $request->description,
                'permission_id' => $request->permission_id
            ];

            if($id != 1){
                $result = $this->role->update($data,$id);

            }else{
                return response()->json(['status' => false, 'message' => "Sorry You Can't Update Super administrator Role"]);
            }

            if ($result['success']) {
              return response()->json(['status' => true, 'message' => 'Role has been successfully Created.']);
            } else {
              return response()->json(['status' => false, 'message' => 'Oops.. An Error Occurred, Please Try Again.']);
            }
          }
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to update role.", "error" => $e->getMessage()));
      }
    }

    //Role response time list
    public function responseTime()
    {
      try {
        return view('response_time.list');
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to get response time list.", "error" => $e->getMessage()));
      }
    }

    //Get role response time list
    public function getResponseTimeList()
    {
      try {
        return $this->roleResponseTime->getResponseTimeList();
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to get response time list.", "error" => $e->getMessage()));
      }
    }

    //Create role response time
    public function createResponseTime()
    {
      try {
        $roles = $this->role->getRolesDetails();

        return view('response_time.form', ['roles' => $roles]);
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to create response time.", "error" => $e->getMessage()));
      }
    }

    //Store response time
    public function storeResponseTime(StoreResponseTime $request)
    {
      try {
        $validated = $request->validated();

        $requestData = [
          'id' => $request['response_time_id'],
          'role_id' => $validated['role_id'],
          'no_of_days' => $validated['no_of_days']
        ];

        $result = $this->roleResponseTime->storeResponseTime($requestData);

        if ($result['success']) {
          return response()->json(['status' => $result['success'], 'message' => $result['message']]);
        } else {
          return response()->json(['status' => $result['success'], 'message' => $result['message']]);
        }
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to store response time.", "error" => $e->getMessage()));
      }
    }

    //Edit response time
    public function editResponseTime($id)
    {
      try {
        $roles = $this->role->getRolesDetails();

        $roleResponseTime = $this->roleResponseTime->showRoleResponseTime($id);

        return view('response_time.form', ['roles' => $roles, 'roleResponseTime' => $roleResponseTime]);
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to redirect to edit response time.", "error" => $e->getMessage()));
      }
    }
}
