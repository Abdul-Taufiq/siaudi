<?php

namespace App\Policies;

use App\Models\BantuanTSI;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BantuanTSIPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return $user->jabatan === 'Kasi Operasional' || $user->jabatan === 'TSI' || $user->nama === 'Andri Bagus S'
                ? Response::allow()
                : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }


    public function view(User $user, BantuanTSI $bantuanTSI)
    {
        //
    }


    public function create(User $user)
    {
        return $user->jabatan === 'Kasi Operasional'
                ? Response::allow()
                : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }



    public function updateTSI(User $user)
    {
        return $user->jabatan === 'TSI'
                ? Response::allow()
                : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }




    public function delete(User $user, BantuanTSI $bantuanTSI)
    {
        //
    }

    

    public function restore(User $user, BantuanTSI $bantuanTSI)
    {
        //
    }



    public function forceDelete(User $user, BantuanTSI $bantuanTSI)
    {
        //
    }
}
