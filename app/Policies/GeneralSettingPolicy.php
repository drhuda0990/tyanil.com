<?php

namespace App\Policies;

use App\Product;
use App\User;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeneralSettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permission = Permission::where('guard_name', 'rating_view')->first();
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
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $bag
     * @return mixed
     */
    public function view(User $user)
    {
        $permission = Permission::where('guard_name', 'rating_view')->first();
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
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $bag
     * @return mixed
     */
    public function update(User $user)
    {
        $permission = Permission::where('guard_name', 'rating_edit')->first();
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

 public function delete(User $user)
    {
      $permission = Permission::where('guard_name', 'rating_delete')->first();
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
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $bag
     * @return mixed
     */
    public function restore(User $user, Product $bag)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $bag
     * @return mixed
     */
    public function forceDelete(User $user, Product $bag)
    {
        //
    }
}
