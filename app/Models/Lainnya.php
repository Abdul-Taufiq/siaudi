<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lainnya extends Model
{
    use HasFactory;
    protected $connection = 'ksb_siaudi';
    protected $table = 'tb_lainnya';
    // protected $dates = ['created_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
