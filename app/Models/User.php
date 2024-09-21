<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table  = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    protected $timesstamps = true;
    protected $inrementing = true;

    protected $fillable = [
        'username', 'password', 'name'
    ];
}
