<?php

namespace App\Policies;

use App\Models\PemDeposito;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PemDepositoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->jabatan === 'Kasi Operasional' || $user->jabatan === 'Pembukuan' || $user->jabatan === 'TSI'
            || $user->jabatan === 'Pimpinan Cabang' || $user->jabatan === 'Kasi Komersial' || $user->jabatan === 'Direktur Operasional'
                ? Response::allow()
                : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }


    public function view(User $user, PemDeposito $pemDeposito)
    {
        //
    }


    public function create(User $user)
    {
        return $user->jabatan === 'Kasi Operasional' || $user->jabatan === 'Kasi Komersial'
                ? Response::allow()
                : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }


    public function update(User $user)
    {
        return $user->jabatan === 'Pembukuan' || $user->jabatan === 'TSI'
            || $user->jabatan === 'Pimpinan Cabang' || $user->jabatan === 'Direktur Operasional'
            ? Response::allow()
            : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }

    public function updateAdmin(User $user)
    {
        return $user->jabatan === 'Pembukuan' || $user->jabatan === 'TSI'
            || $user->jabatan === 'Direktur Operasional'
            ? Response::allow()
            : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }


    public function delete(User $user, PemDeposito $pemDeposito)
    {
        //
    }


    public function restore(User $user, PemDeposito $pemDeposito)
    {
        //
    }


    public function forceDelete(User $user, PemDeposito $pemDeposito)
    {
        //
    }
}
