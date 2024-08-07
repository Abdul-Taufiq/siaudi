<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $connection = 'ksb_siaudi';
    protected $table = 'tb_example';
    // protected $dates = ['created_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'nama', 'nim', 'tmp_lahir', 'tgl_lahir'
    // ];
}
