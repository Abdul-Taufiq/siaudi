<?php

namespace App\Models\LKHP;

use App\Models\Cabang;
use App\Models\LKHP\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkhpFinal extends Model
{
    use HasFactory;
    protected $connection = 'ksb_siaudi';
    protected $table = 'tb_lkhp_final';
    protected $dates = ['created_at', 'updated_at', 'tgl_awal', 'tgl_akhir', 'komitmen_tgl'];
    protected $primaryKey = 'id_lkhp_final';
    protected $guarded = ['id_lkhp_final'];

    public function Cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function pivot()
    {
        return $this->hasMany(Pivot::class, 'id_lkhp_final', 'id_lkhp_final');
    }
}
