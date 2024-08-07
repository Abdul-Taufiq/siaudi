<?php

namespace App\Models\Debitur;

use App\Models\Cabang;
use App\Models\KKPK\Kkpk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debitur extends Model
{
    use HasFactory;
    protected $connection = 'ksb_siaudi';
    protected $table = 'tb_debitur';
    protected $dates = ['created_at', 'updated_at', 'tgl_realisasi', 'tgl_jth_tempo'];
    protected $primaryKey = 'id_debitur';
    protected $guarded = ['id_debitur'];


    public function Cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function kkpk()
    {
        return $this->hasOne(Kkpk::class, 'id_debitur', 'id_debitur');
    }
}
