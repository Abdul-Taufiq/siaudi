<?php

namespace App\Models\KKPK;

use App\Models\Cabang;
use App\Models\Debitur\Debitur;
use App\Models\LKHP\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kkpk extends Model
{
    use HasFactory;
    protected $connection = 'ksb_siaudi';
    protected $table = 'tb_kkpk';
    protected $dates = ['created_at', 'updated_at', 'tgl_pemeriksaan'];
    protected $primaryKey = 'id_kkpk';
    protected $guarded = ['id_kkpk'];

    public function Cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function debitur()
    {
        return $this->belongsTo(Debitur::class, 'id_debitur', 'id_debitur');
    }

    public function keterangan()
    {
        return $this->hasOne(KkpkKeterangan::class, 'id_kkpk', 'id_kkpk');
    }

    public function kko()
    {
        return $this->belongsTo(Kko::class, 'id_kkpk', 'id_kkpk');
    }

    public function pivot()
    {
        return $this->hasMany(Pivot::class, 'id_kkpk', 'id_kkpk');
    }
}
