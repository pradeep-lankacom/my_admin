<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionInterface;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PermissionRepository implements PermissionInterface
{
    protected $permission;

    public function __construct(
        Permission $permission
    ) {
        $this->permission = $permission;
    }

    /**Get permission list*/
    public function getPermissionList()
    {
        try {
            $permissions = \DB::table('permissions')
            ->select(['id', 'name', 'description', 'slug', 'breadcrumb', 'title']);

            return Datatables::of($permissions)
            ->make(true);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function show($id)
    {
        try {
            return $this->getPermissionById($id);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function edit($id)
    {
        try {
            return $this->getPermissionById($id);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    private function getPermissionById($id)
    {
        try {
            return \DB::table('permissions')
            ->select(['id', 'name', 'description', 'slug', 'breadcrumb', 'title'])
            ->where('id', $id)
            ->first();
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }


    public function getAllPermissions()
    {
        try {
            $permission=Permission::all();
            return $permission;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function getAllPermissionsByRoleId($roleId)
    {
        try {
            $permissions =  \DB::table('permission_role')
            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
            ->select(
                [
                    'permissions.id',
                    'permissions.name',
                    'permissions.description'
                ]
            )
            ->where('permission_role.role_id', '=', $roleId)
            ->get();
            return $permissions;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function store($data)
    {
        try {
            if (!empty($data)) {
                $permission = $this->permission;
                $permission->name = $data['name'];
                $permission->description = $data['description'];
                $permission->slug = $data['slug'];
                $permission->breadcrumb = $data['breadcrumb'];
                $permission->title = $data['title'];
                $permissionId = $data['permission_id'];

                if ($permissionId != 0) {
                    $existingPermission = $this->permission
                                    ->where('name', $data['name'])
                                    ->where('description', $data['description'])
                                    ->where('slug', $data['slug'])
                                    ->where('breadcrumb', $data['breadcrumb'])
                                    ->where('title', $data['title'])
                                    ->where('id', $permissionId)
                                    ->first();

                    if (empty($existingPermission)) {
                        $permission = $this->permission->find($permissionId);
                        $permission->description = $data['description'];
                        $permission->slug = $data['slug'];
                        $permission->breadcrumb = $data['breadcrumb'];
                        $permission->title = $data['title'];
                    } else {
                        return array('permission_id' => $existingPermission->id, 'success' => true, 'message'=>'Permission Already Exists');
                    }
                }
                $permission->save();
                return array('permission_id' => $permission->id, 'success' => true, 'message'=>'Permission Added Successfully');
            }
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "Faild to store Permission", 'error' => $e->getMessage());
            \Log::error($errorArr);
            return array('permission_id' => "", 'success' => false, 'message'=>'Failed to Add Permission');
        }

    }

    /**Get permission list for WB Admin*/
    public function getPermissionListWB()
    {
        try {
            $permissions = \DB::table('permissions')
            ->select(['id', 'name', 'description'])
            ->where('name','like', '% Menu');

            return Datatables::of($permissions)
            ->make(true);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function getPermissionBySlug($slug){
        try {

            $num = array(0,1,2,3,4,5,6,7,8,9);
            $slug=str_replace($num, null, $slug);
            $permission = \DB::table('permissions')
                            ->where('slug',$slug)
                            ->first();

            return $permission;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }
}
