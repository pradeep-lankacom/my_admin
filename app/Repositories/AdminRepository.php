<?php

namespace App\Repositories;


use App\Models\Admin;
use App\Repositories\Contracts\AdminInterface;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class AdminRepository implements AdminInterface
{


    protected $admin_user;

    public function __construct(Admin $admin_user)
    {
        $this->admin_user = $admin_user;
    }

    public function getUsersByRole($role)
    {
        try {
            $users = User::whereHas('roles', function ($q) use ($role) {
                $q->where('roles.name', $role);
            })->where('users.status_id',1)->get();

            return $users;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::guard('admin')->user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }



    /**Get user list*/
    public function getUserList()
    {
        try {
            $role = Auth::user()->roles->first();

            $users = $this->admin_user
                ->select(
                    'admins.id',
                    'admins.name',
                    'admins.email',
                    'admins.status_id',
                    'admins.created_at',
                    'admins.deleted_at',
                    'roles.name as role_name'
                )
                ->leftJoin('admin_role', 'admins.id', '=', 'admin_role.admin_id')
                ->leftJoin('roles', 'admin_role.role_id', '=', 'roles.id')
                ->where('roles.name', '!=', config('role.super_admin'))
                ->withTrashed();

            return Datatables::of($users)
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
