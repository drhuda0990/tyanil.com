<?php

namespace App\Policies;

use App\User;
use App\advertisement;
use Illuminate\Auth\Access\Response;
use App\Permission;

class AdvertisementPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
      $permission = Permission::where('guard_name', 'advertisement_view')->first();
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
     * @param  \App\Product  $user
     * @return mixed
     */
    public function view(User $user)
    {
      $permission = Permission::where('guard_name', 'advertisement_view')->first();
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
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      $permission = Permission::where('guard_name', 'advertisement_add')->first();
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
     * @param  \App\Product  $user
     * @return mixed
     */
    public function update(User $user)
    {
      $permission = Permission::where('guard_name', 'advertisement_edit')->first();
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
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $user
     * @return mixed
     */
    public function delete(User $user)
    {
      $permission = Permission::where('guard_name', 'advertisement_delete')->first();
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
