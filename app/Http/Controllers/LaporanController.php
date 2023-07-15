<?php

namespace App\Http\Controllers;

use App\Models\Atlet;
use App\Models\Cabor;
use App\Models\Club;
use App\Models\Pelatih;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\at;

class LaporanController extends Controller
{

    public function __construct()
    {
        # code...
        $this->middleware(['permission:laporan-list|laporan-create|laporan-edit|laporan-delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchQuery = $request->input('search', '');

        $atlet = DB::table('users')
            ->join('atlets', 'users.id', '=', 'atlets.iduser')
            ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
            ->select(
                'users.*',
                'atlets.*',
                'users.name as atlet_name',
                'clubs.club_name',
                'atlets.id as atlet_id',
                'cabors.name as cabang',
                'atlets.created_at as tahun'
            )
            ->where('users.active_atlet', 1)
            ->whereNull('atlets.deleted_at')
            ->orderBy('name', 'asc');
        if (!empty($searchQuery)) {
            $atlet->where(function ($query) use ($searchQuery) {
                $query->where('users.name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('users.lastname', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('cabors.name', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $atlet = $atlet->paginate(100);


        $teams = DB::table('teams')
            ->join('clubs', 'teams.club_id', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', 'cabors.id')
            ->join('users as leaders', 'teams.leader_team', '=', 'leaders.id')
            ->select(
                'teams.*',
                'teams.file as file_team',
                'clubs.*',
                'cabors.*',
                'cabors.name as cabang',
                'leaders.name as leader_team',
                'leaders.lastname as leader_lastname',
            )
            ->whereNull('teams.deleted_at')
            ->orderBy('team_name', 'asc')
            ->paginate(100);

        foreach ($teams as $team) {
            $atletIds = json_decode($team->atlet);
            $atletUsers = User::whereIn('id', $atletIds)->get();
            $team->anggota_team = $atletUsers;
        }


        $pelatih = DB::table('users')
            ->join('pelatih', 'users.id', '=', 'pelatih.user_id')
            ->join('clubs', 'pelatih.club_id', '=', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', '=', 'cabors.id')
            ->select(
                'users.*',
                'pelatih.*',
                'users.name as pelatih_name',
                'clubs.club_name',
                'pelatih.id as pelatih_id',
                'cabors.name as cabang',
                'pelatih.created_at as tahun'
            )
            ->where('users.active', 99)
            ->whereNull('pelatih.deleted_at')
            ->orderBy('name', 'asc');

        if (!empty($searchQuery)) {
            $pelatih->where(function ($query) use ($searchQuery) {
                $query->where('users.name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('users.lastname', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $pelatih = $pelatih->paginate(100);

        $tahunAtlet = Atlet::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->pluck('year')
            ->sort()
            ->toArray();

        $tahunPelatih = Pelatih::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->pluck('year')
            ->sort()
            ->toArray();

        return view('pages.laporan.laporan', compact('atlet', 'teams', 'pelatih', 'tahunAtlet', 'tahunPelatih'));
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
    public function card_atlet($id)
    {
        $atlet = Atlet::find($id);
        $user = User::find($atlet->iduser);
        $cabors = Cabor::get();
        $clubs = Club::get();
        return view('pages.laporan.card_atlet', compact('user', 'cabors', 'atlet', 'clubs'));
    }

    public function card_pelatih($id)
    {
        $pelatih = Pelatih::find($id);
        $user = User::find($pelatih->user_id);
        $cabors = Cabor::get();
        $clubs = Club::get();
        return view('pages.laporan.card_pelatih', compact('user', 'cabors', 'pelatih', 'clubs'));
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
