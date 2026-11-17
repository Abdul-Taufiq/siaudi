<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    //
    protected $table = 'tb_log_activity';
    protected $dates = ['created_at', 'updated_at'];
    protected $primaryKey = 'id_log_activity';
    protected $guarded = ['id_log_activity'];
}
