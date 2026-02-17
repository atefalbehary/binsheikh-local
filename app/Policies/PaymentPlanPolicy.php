<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create payment plans.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_payment_plan');
    }

    /**
     * Determine whether the user can update the payment plan.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        // Add specific logic: Sales Manager can edit, etc.
        // Assuming 'edit_all_clients' covers payment plan editing or similar
        return $user->hasPermission('create_payment_plan'); 
    }

    /**
     * Determine whether the user can delete the payment plan.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete_payment_plan');
    }

    /**
     * Determine whether the user can approve the payment plan.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function approve(User $user)
    {
        // Accountant Manager or Super Admin
        return $user->hasPermission('approve_payment_plan');
    }
}
