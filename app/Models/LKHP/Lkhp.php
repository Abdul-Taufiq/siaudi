<?php

namespace App\Models\LKHP;

use App\Models\Cabang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lkhp extends Model
{
    use HasFactory;
    //
    protected $table = 'tb_lkhp';
    protected $dates = ['created_at', 'updated_at', 'tgl_awal', 'tgl_akhir'];
    protected $primaryKey = 'id_lkhp';
    protected $guarded = ['id_lkhp'];

    public function Cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
    }

    public function pivot()
    {
        return $this->hasMany(Pivot::class, 'id_lkhp', 'id_lkhp');
    }
}
