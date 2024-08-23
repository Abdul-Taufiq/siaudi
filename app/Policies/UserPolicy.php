<?php

namespace App\Policies;

use App\Models\KKPK\Kkpk;
use App\Models\User;
use App\Models\RiskEvent\RiskEvent;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->jabatan === 'Internal Audit' || $user->level === 'DIREKTUR'
            ? Response::allow()
            : Response::denyWithStatus(403, 'Anda tidak diizinkan mengakses halaman ini.');
    }

    public function addEvent(User $user)
    {
        return $user->sub_jabatan === 'Kabid Audit Internal'
            ? Response::allow()
            : Response::denyWithStatus(403, 'Anda Bukan Kabid!');
    }

    public function Batasan(User $user, Kkpk $kkpk)
    {
        if ($user->sub_jabatan === 'Kabid Audit Internal') {
            return Response::allow();
        } else {
            return $user->nama === $kkpk->nama_pemeriksa
                ? Response::allow()
                : Response::denyWithStatus(403, 'Anda Bukan Pembuat Data Ini!');
        }
    }
}
