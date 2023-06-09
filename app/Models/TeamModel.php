<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teams';
    protected $fillable = ['team_id', 'team_name', 'slogan', 'desc', 'file', 'cover', 'games', 'atlet', 'leader_team', 'club_id', 'cabang_id'];
}
