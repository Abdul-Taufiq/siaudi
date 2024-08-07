<?php

namespace App\Models\LKHP;

use App\Models\KKPK\Kkpk;
use App\Models\LKHP\LkhpFinal;
use App\Models\RiskEvent\RiskEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pivot extends Model
{
    use HasFactory;
    protected $connection = 'ksb_siaudi';
    protected $table = 'tb_pivot';
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id_pivot';
    protected $guarded = ['id_pivot'];

    public function kkpk()
    {
        return $this->belongsTo(Kkpk::class, 'id_kkpk', 'id_kkpk');
    }

    public function riskEvent()
    {
        return $this->belongsTo(RiskEvent::class, 'id_event_risk', 'id_event_risk');
    }

    public function lkhp()
    {
        return $this->belongsTo(Lkhp::class, 'id_lkhp', 'id_lkhp');
    }

    public function lkhpFinal()
    {
        return $this->belongsTo(LkhpFinal::class, 'id_lkhp_final', 'id_lkhp_final');
    }

    public function pivotImg()
    {
        return $this->hasMany(PivotImg::class, 'id_pivot', 'id_pivot');
    }
}
