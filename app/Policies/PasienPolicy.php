<?php

namespace App\Policies;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PasienPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pasien $pasien): bool
    {
        if(auth()->user()->user_category_id == 1){
            return  true;
        }
        return $pasien->company_id == $user->company_id;
    }

}
