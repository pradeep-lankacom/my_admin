<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Contracts\RoleInterface;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class RoleRepository implements RoleInterface
{
    protected $role;

    public function __construct(
    Role $role
  ) {
        $this->role = $role;
    }

    public function store($request)
    {
        try {
            if (!empty($request)) {
                $role= Role::create($request->all())->permissions()->sync($request->permission_id, false);
                return array('success' => true);
            }
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "Role store failed", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function getRoleList()
    {
        try {
            $roles = $this->getRoles();

            return Datatables::of($roles)
        ->addColumn('action', function ($roles) {
           // $roleName = Auth::user()->roles->first()->name;
            $roleName = "SuperAdmin";

            $action = null;

            $action .='<a title="View" style="display: block;float: left;margin-right: 3px;" href="/roles/'.$roles->id.'"><button type="button"  class="btn btn-success btn-xs dt-view"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button></a>';

            if (\Auth::guard('admin')->user()->hasAnyRoleWithPermission($roleName, 'roles.edit')) {
                $action .='<a title="Edit" style="display: block;float: left;margin-right: 3px;" href="/roles/'.$roles->id.'/edit"><button type="button"  class="btn btn-primary btn-xs dt-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>';
            }

            return $action;
        })
        ->rawColumns(['action'])
        ->make(true);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function show($id)
    {
        try {
            return $this->getRoleById($id);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function edit($id)
    {
        try {
            return $this->getRoleById($id);
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    private function getRoleById($id)
    {
        try {
            $role = $this->role;
            $roles = $role
        ->select(['id', 'name', 'description'])
        ->where('id', $id)
        ->first();
            return $roles;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }

    public function update($data, $id)
    {
        try {
            $role = Role::findOrFail($id);
            //$role->name = $data["name"];
            $role->description = $data["description"];
            $role->save();

            if ($data["permission_id"]) {
                $role->permissions()->sync($data["permission_id"], true);
            }
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "Role permission update has been failed", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
        return array('success' => true);
    }

    private function getRoles()
    {
      try {
        $roles = $this->role;
        $roles = $roles->select([
            'id',
            'name',
            'description',
            'created_at',
          ])
          ->get();

        return $roles;

      } catch (\Exception $e) {
        \Log::error(array('user_id'=>Auth::user()->id, 'msg' => "No roles.", 'error' => $e->getMessage()));
      }
    }

    public function getRolesToUsers()
    {
      try {
        $roles = $this->getRoles()->where('name', '!=', config('role.super_admin'));

        return $roles;
      } catch (\Exception $e) {
        \Log::error(array('user_id'=>Auth::user()->id, 'msg' => "No roles.", 'error' => $e->getMessage()));
      }
    }

    public function getRolesDetails()
    {
      try {
        $roles = $this->getRoles();

        return $roles;
      } catch (\Exception $e) {
        \Log::error(array('user_id'=>Auth::user()->id, 'msg' => "No roles.", 'error' => $e->getMessage()));
      }
    }
}
