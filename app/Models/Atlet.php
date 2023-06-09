<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atlet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['iduser', 'club_id'];
}
