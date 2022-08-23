<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $table='USERINFO';
    public $timestamps=false;
    protected $primarykey='USERID';
    protected $connection='sqlsrv';

}