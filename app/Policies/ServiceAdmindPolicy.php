<?php

namespace App\Policies;

use App\ServiceAdmind;
use App\User;
use Illuminate\Auth\Access\Response;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;
class ServiceAdmindPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the service_admin can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permission = Permission::where('guard_name', 'service_admin_view')->first();
        if ($permission) {
            $id = $permission->id;
            $permissions = $user->permissions;
            $permissions = str_replace('["', '', $permissions);
            $permissions = str_replace('"]', '', $permissions);
            $permissions = explode('","', $permissions);
            if (in_array($id, $permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the service_admin can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $user
     * @return mixed
     */
    public function view(User $user)
    {
        $permission = Permission::where('guard_name', 'service_admin_view')->first();
        if ($permission) {
            $id = $permission->id;
            $permissions = $user->permissions;
            $permissions = str_replace('["', '', $permissions);
            $permissions = str_replace('"]', '', $permissions);
            $permissions = explode('","', $permissions);
            if (in_array($id, $permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the service_admin can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permission = Permission::where('guard_name', 'service_admin_add')->first();
        if ($permission) {
            $id = $permission->id;
            $permissions = $user->permissions;
            $permissions = str_replace('["', '', $permissions);
            $permissions = str_replace('"]', '', $permissions);
            $permissions = explode('","', $permissions);
            if (in_array($id, $permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the service_admin can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $user
     * @return mixed
     */
    public function update(User $user)
    {
        $permission = Permission::where('guard_name', 'service_admin_edit')->first();
        if ($permission) {
            $id = $permission->id;
            $permissions = $user->permissions;
            $permissions = str_replace('["', '', $permissions);
            $permissions = str_replace('"]', '', $permissions);
            $permissions = explode('","', $permissions);
            if (in_array($id, $permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the service_admin can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        $permission = Permission::where('guard_name', 'service_admin_delete')->first();
        if ($permission) {
            $id = $permission->id;
            $permissions = $user->permissions;
            $permissions = str_replace('["', '', $permissions);
            $permissions = str_replace('"]', '', $permissions);
            $permissions = explode('","', $permissions);
            if (in_array($id, $permissions)) {
                return true;
            }
        }
        return false;
    }
}
