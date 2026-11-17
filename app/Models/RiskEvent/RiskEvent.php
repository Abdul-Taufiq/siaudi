<?php

namespace App\Models\RiskEvent;

use App\Models\LKHP\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskEvent extends Model
{
    use HasFactory;
    //
    protected $table = 'tb_event_risk';
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id_event_risk';
    protected $guarded = ['id_event_risk'];
    // protected $fillable = [
    //     'nama', 'nim', 'tmp_lahir', 'tgl_lahir'
    // ];


    public function pivot()
    {
        return $this->hasMany(Pivot::class, 'id_event_risk', 'id_event_risk');
    }
}
