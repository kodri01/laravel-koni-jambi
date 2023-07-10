<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;


class InfoClubController extends Controller
{
    //

    public function index()
    {
        # code...
        $lists = DB::table('clubs')
            ->join('atlets', 'clubs.id', 'atlets.club_id')
            ->leftjoin('teams', 'atlets.club_id', 'teams.club_id')
            ->select(
                'atlets.id as atlet_id',
                'clubs.iduser as id_userclub',
                'clubs.club_name as club_name',
                'clubs.file as club_file',
                'clubs.description as club_desc',
                'teams.team_name as team_name',
                'teams.slogan as team_slogan',
                'teams.desc as team_desc',
                'teams.file as team_file',
                'teams.atlet',
                'teams.leader_team',
                'teams.id as team_id'
            )
            ->where('atlets.iduser', auth()->user()->id)
            ->whereNull('teams.deleted_at')
            ->distinct()
            ->get();


        $de = [];
        foreach ($lists as $item) {
            $de[] = $item->atlet;
        }
        $users = User::where('active_atlet', 1)->get();
        $pelatih = DB::table('users')->select('id as pelatih_id', 'name as pelatih_name', 'lastname as pelatih_lastname')->where('active', 99)->get();
        // $user = User::orderBy('id')where('active', 99)->get();
        // return dd(compact('lists','users'));
        // Club::where('club_id',auth()->user()->id)->get();
        return view('pages.infoclub.index', compact('lists', 'users',  'pelatih'));
    }
}
