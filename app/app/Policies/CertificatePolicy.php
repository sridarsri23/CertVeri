<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a certificate.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
       // dd($user->role);
        return $user->role === 'admin' || $user->role === 'editor';
      }

    /**
     * Determine whether the user can view the certificate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Certificate  $certificate
     * @return bool
     */
    public function view(User $user, Certificate $certificate)
    {
        // Logic to determine if the user can view the certificate
        // Example: Only admins and the certificate's owner can view
        return $user->role === 'admin' || $user->role === 'editor';
    }

    /**
     * Determine whether the user can update the certificate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Certificate  $certificate
     * @return bool
     */
    public function update(User $user, Certificate $certificate)
    {
        // Logic to determine if the user can update the certificate
        // Example: Only admins and the certificate's owner can update
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the certificate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Certificate  $certificate
     * @return bool
     */
    public function delete(User $user, Certificate $certificate)
    {
        // Logic to determine if the user can delete the certificate
        // Example: Only admins and the certificate's owner can delete
        return $user->role === 'admin';
    }
}
