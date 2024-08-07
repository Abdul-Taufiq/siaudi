<?php

namespace App\Models\LKHP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsolidasi extends Model
{
    use HasFactory;
    protected $connection = 'ksb_siaudi';
    protected $table = 'tb_konsolidasi';
    protected $dates = ['created_at', 'updated_at', 'periode_pemeriksaan'];
    protected $primaryKey = 'id_konsolidasi';
    protected $guarded = ['id_konsolidasi'];
}
