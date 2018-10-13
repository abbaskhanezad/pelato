<?php

namespace App\Policies;

use App\User;
use App\OrderRoom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ordersList
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the orderRoom.
     *
     * @param  \App\User  $user
     * @param  \App\OrderRoom  $orderRoom
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->type == '3';
    }

    /**
     * Determine whether the user can create orderRooms.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the orderRoom.
     *
     * @param  \App\User  $user
     * @param  \App\OrderRoom  $orderRoom
     * @return mixed
     */
    public function update(User $user, OrderRoom $orderRoom)
    {
        //
    }

    /**
     * Determine whether the user can delete the orderRoom.
     *
     * @param  \App\User  $user
     * @param  \App\OrderRoom  $orderRoom
     * @return mixed
     */
    public function delete(User $user, OrderRoom $orderRoom)
    {
        //
    }
}
