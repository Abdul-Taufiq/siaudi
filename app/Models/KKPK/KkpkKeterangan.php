<?php

namespace App\Models\KKPK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KkpkKeterangan extends Model
{
    use HasFactory;
    //
    protected $table = 'tb_kkpk_keterangan';
    protected $dates = ['created_at', 'updated_at', 'tgl_pemeriksaan'];
    protected $primaryKey = 'id_kkpk_keterangan';
    protected $guarded = ['id_kkpk_keterangan'];

    public function kkpk()
    {
        return $this->belongsTo(Kkpk::class, 'id_kkpk', 'id_kkpk');
    }
}
