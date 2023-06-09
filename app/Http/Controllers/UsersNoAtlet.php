<?php

namespace App\Http\Controllers;

use App\Models\Atlet;

use App\Models\Pelatih;
use App\Models\TeamModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;



class UsersNoAtlet extends Controller
{

    public function __construct()
    {
        # code...
        $this->middleware(['permission:users-list|users-create|users-edit|users-delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $atlet = DB::table('users')
            ->join('atlets', 'users.id', '=', 'atlets.iduser')
            ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
            ->select(
                'users.*',
                'atlets.*',
                'users.name as atlet_name',

                'atlets.id as atlet_id',
                'cabors.name as cabang'
            )
            ->where('users.active_atlet', 1)
            ->whereNull('atlets.deleted_at')
            ->paginate(100);

        $teams = DB::table('teams')
            ->join('clubs', 'teams.club_id', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', 'cabors.id')
            ->join('users', 'teams.leader_team', '=',  'users.id')

            ->select(
                'teams.*',
                'clubs.*',
                'cabors.*',
                'cabors.name as cabang',
                'users.name as leader_team',
                'users.name as anggota_team'
            )
            ->whereNull('teams.deleted_at')
            // ->where('teams.club_id',)
            ->paginate(100);


        return view('pages.usernoatlet.users', compact('atlet', 'teams'));
    }

    public function showAtlet()
    {
        $list = Atlet::orderBy('id')
            ->join('users', 'atlets.iduser', '=', 'users.id')
            ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
            ->select(
                'users.*',
                'users.name as atlet_name',
                'atlets.id as atlet_id',
                'cabors.name as cabang'
            )
            ->where('users.active_atlet', 1)
            ->whereNull('atlets.deleted_at')
            ->paginate(100);
        return view('pages.usernoatlet.atlet', compact('list'));
    }

    public function showTeam()
    {
        $list = TeamModel::paginate(10); // Ganti dengan model dan data yang sesuai untuk masing-masing tabel
        return view('pages.usernoatlet.users', compact('list'));
    }

    public function showPelatih()
    {
        $list = Pelatih::orderBy('id')
            ->join('users', 'pelatih.user_id', '=', 'users.id')
            ->join('clubs', 'pelatih.club_id', '=', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
            ->select(
                'users.*',
                'users.name as pelatih_name',
                'pelatih.*',
                'cabors.name as cabang'
            )
            ->whereNull('pelatih.deleted_at')
            ->paginate(100);
        return view('pages.usernoatlet.users', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
