<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInOut extends Model
{
    use HasFactory;

    protected $table='CHECKINOUT';
    public $timestamps=false;
    protected $primarykey='USERID';
    protected $connection='sqlsrv';
}
