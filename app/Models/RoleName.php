<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleName extends Model
{
    use HasFactory;
    protected $table = 'rolenames';
    protected $fillable=["role_name"];
}
