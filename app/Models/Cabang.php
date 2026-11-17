<?php

namespace App\Models;

use App\Models\Debitur\Debitur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';
    protected $primaryKey = 'id_cabang';


    public function Debitur()
    {
        return $this->hasMany(Debitur::class, 'id_cabang', 'id_cabang');
    }
}
