<?php

namespace App\Traits;

trait HasPermission
{
    public function hasAnyRoleWithPermission($roles, $permission)
    {
        if (is_string($roles)) {
            $roles = explode('|', $roles);
        }  
        
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRoleWithPermission($role, $permission)) {
                    return true;
                }
            }
        } else if (is_a($roles, 'Illuminate\Database\Eloquent\Collection')) {
            foreach ($roles as $role) {
                if ($this->hasRoleWithPermission($role['name'], $permission)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRoleWithPermission($roles, $permission)) {
                return true;
            }
        }
        return false;
    }

    public function hasRoleWithPermission($role, $permission)
    {
        $role = $this->roles()->where('name', $role)->first();

        if ($role) {
            $rolePermissions = $role->permissions;
            
            if (strpos($permission, '|') !== false) {
                $permission = explode('|', $permission);
            }


            if (is_array($permission)) {
                foreach ($rolePermissions as $rolePermission) {
                    if (in_array($rolePermission->name,$permission)) {
                        return true;
                    }
                }
            }

            if (is_string($permission)) {
                foreach ($rolePermissions as $rolePermission) {
                    if ($rolePermission->name == $permission) {
                        return true;
                    }
                }
            }

            return false;
        }
        return false;
    }

    public function hasPermission($permission)
    {
        if (!empty($this->permissions()->where('name', $permission)->first())) {
            return true;
        }
        return false;

    }
}
