<?php

namespace App\Models\KKPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kko extends Model
{
    use HasFactory;
    //
    protected $table = 'tb_kko';
    protected $dates = ['created_at', 'updated_at', 'tgl_kunjungan'];
    protected $primaryKey = 'id_kko';
    protected $guarded = ['id_kko'];

    public function kkpk()
    {
        return $this->belongsTo(kkpk::class, 'id_kkpk', 'id_kkpk');
    }
}
