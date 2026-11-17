<?php

namespace App\Models\LKHP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PivotImg extends Model
{
    use HasFactory;
    //
    protected $table = 'tb_pivot_img';
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id_img';
    // protected $guarded = ['id_img'];

    public function pivot()
    {
        return $this->belongsTo(Pivot::class, 'id_pivot', 'id_pivot');
    }
}
