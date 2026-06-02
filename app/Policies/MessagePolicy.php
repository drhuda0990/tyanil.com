<?php

namespace App\Policies;

use App\Definition;
use App\User;
use App\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
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
       $permission=Permission::where('guard_name','message_add')->first();
if($permission){$id=$permission->id;
      $permissions=$user->permissions;
       $permissions = str_replace('["', '', $permissions);
                   $permissions = str_replace('"]', '', $permissions);
                 $permissions = explode('","', $permissions );
      if (in_array($id, $permissions)) {
    return true;
}
        } return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $message
     * @return mixed
     */
    public function view(User $user)
    {
        $permission=Permission::where('guard_name','message_add')->first();
if($permission){$id=$permission->id;
      $permissions=$user->permissions;
       $permissions = str_replace('["', '', $permissions);
                   $permissions = str_replace('"]', '', $permissions);
                 $permissions = explode('","', $permissions );
      if (in_array($id, $permissions)) {
    return true;
}
        } return false;
    }

 
}
