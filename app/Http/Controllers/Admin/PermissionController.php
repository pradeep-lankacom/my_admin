<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePermission;
use App\Repositories\Contracts\PermissionInterface;
use App\Http\Controllers\Controller;
use \Crypt;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $permission;

    public function __construct(
        PermissionInterface $permission
    ) {
        $this->permission = $permission;
        $this->middleware('auth:admin');
    }

    /**
     * Show the permission list.
     **/
    public function listPermissions()
    {
        try {
            return view('admin.permission.list');
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to list permissions.", "error" => $e->getMessage()));
        }
    }

    public function getPermissionList()
    {
        try {
            return $this->permission->getPermissionList();
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to list permissions.", "error" => $e->getMessage()));
        }
    }

    public function show($id)
    {
        try {
            $permission = $this->permission->show($id);
            return view('permission.show', ['permission' => $permission]);
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to show permission.", "error" => $e->getMessage()));
        }
    }

    public function edit($id)
    {
        try {
            $permission = $this->permission->edit($id);
            return view('permission.form', ['permission' => $permission]);
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to edit permission.", "error" => $e->getMessage()));
        }
    }

    public function destroy()
    {
        try {
            var_dump("tt");
            exit;
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to destroy permission.", "error" => $e->getMessage()));
        }
    }

    //Create permission
    public function create()
    {
      try {
        return view('admin.permission.create');
      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to create permission.", "error" => $e->getMessage()));
      }
    }

    //Store permission
    public function store(StorePermission $request)
    {
      try {
        $validated = $request->validated();
        if (empty($request['permission_id'])) {
            $permissionId = 0;
        } else {
            $permissionId = $request['permission_id'];
        }
        $requestData = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'permission_id' => $permissionId,
            'slug' => $request['slug'],
            'breadcrumb' => $request['breadcrumb'],
            'title' => $request['title']
        ];
        $result = $this->permission->store($requestData);
        if ($result['success']) {
            return response()->json(['status' => true, 'message' => 'Permission added successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to add permission.']);
        }

      } catch (\Exception $e) {
        \Log::error(array('user_id' => Auth::guard('admin')->user()->id, 'msg' => "Failed to store permission.", "error" => $e->getMessage()));
      }
    }




}
