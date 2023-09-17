<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TeamModel;
use App\Models\GamesModel;
use App\Models\Cabor;
use App\Models\Club;
use Spatie\Permission\Models\Role;

class TeamsController extends Controller
{
    public function __construct()
    {
        # code...
        $this->middleware(['permission:teams-list|teams-create|teams-edit|teams-delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($club_id)
    {
        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        if ($role->name == 'superadmin') {

            $teams = TeamModel::orderBy('id', 'ASC')->where('club_id', $club_id)->paginate(10);
            return view('pages.clubs.teams.index', compact('teams', 'club_id'));
        } else {
            $teams = TeamModel::where('cabang_id', auth::user()->cabang_id)->where('club_id', $club_id)->paginate(10);
            return view('pages.clubs.teams.index', compact('teams', 'club_id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($club_id)
    {

        $atlets = DB::table('users')
            ->join('atlets', 'users.id', 'atlets.iduser')
            ->join('clubs', 'atlets.club_id', 'clubs.id')
            ->join('cabors', 'clubs.cabang_id', 'cabors.id')
            ->select('users.*', 'atlets.iduser as atlet_user', 'cabors.name as nama_cabang')
            ->where('clubs.id', $club_id)
            ->where('users.active', 1)
            ->where('users.active_atlet', 1)
            ->where('atlets.deleted_at', null)
            ->get();
        $games = GamesModel::get();
        $clubs = Club::find($club_id);
        $cabors = Cabor::get();
        return view('pages.clubs.teams.add', compact('atlets', 'games', 'cabors', 'clubs', 'club_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $club_id)
    {

        $rules = [
            'nameteam'  => 'required|min:3',
            'slogan'    => 'required|min:3',
            'listgame'  => 'required|integer',
            'leader'    => 'required|integer',
            'listeam'   => 'required|array',
            'file'      => 'required|file|mimes:jpg,jpeg,bmp,png',
            'cover'     => 'required|file|mimes:jpg,jpeg,bmp,png',
        ];

        $messages = [
            'nameteam.required'  => 'Nama Tim wajib diisi',
            'nameteam.min'       => 'Nama Tim minimal 3 karakter',
            'slogan.required'    => 'Slogan wajib diisi',
            'slogan.min'         => 'Slogan minimal 3 karakter',
            'listgame'           => 'Game wajib dipilih',
            'leader'             => 'Leader Tim wajib dipilih',
            'listeam'            => 'Tim pemain wajib dipilih',
            'file.required'      => 'Logo Tim wajib diupload',
            'cover.required'     => 'Cover Tim wajib diupload',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $namefile = str_replace(' ', '_', $request->file->getClientOriginalName());
        $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $filename);

        $namefile1 = str_replace(' ', '_', $request->cover->getClientOriginalName());
        $filename1  = $namefile1 . '_' . time() . '.' . $request->cover->extension();
        $request->cover->move(public_path('uploads'), $filename1);


        $random = '';
        for ($i = 0; $i < 12; $i++) {
            $random .= mt_rand(0, 9);
        }

        $getRand = $random;
        $encode = json_encode($request->listeam);

        TeamModel::create([
            'team_id' => $getRand,
            'team_name' => $request->nameteam,
            'slogan' => $request->slogan,
            'desc' => $request->desc,
            'file' => $filename,
            'cover' => $filename1,
            'games' => $request->listgame,
            'atlet' => $encode,
            'leader_team' => $request->leader,
            'club_id' => $club_id,
            'cabang_id' => $request->cabor
        ]);

        return redirect()->to('clubs/' . $club_id . '/teams')
            ->with('success', 'Team created successfully');
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
    public function edit($club_id, $id)
    {
        //
        $team = TeamModel::find($id);
        $games = GamesModel::get();
        $atlets = DB::table('users')
            ->join('atlets', 'users.id', 'atlets.iduser')
            ->join('clubs', 'atlets.club_id', 'clubs.id')
            ->select('users.*', 'atlets.iduser as atlet_user')
            ->where('users.active', 1)
            ->where('clubs.id', $club_id)
            ->where('atlets.deleted_at', null)
            ->get();
        $atletarr = [];
        $de = json_decode($team->atlet);
        foreach ($de as $atlet) {
            $atletarr[] = $atlet;
        }
        $cabors = Cabor::get();

        return view('pages.clubs.teams.edit', compact('team', 'games', 'atlets', 'atletarr', 'cabors', 'club_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $club_id, $id)
    {
        $rules = [
            'nameteam'  => 'required|min:3',
            'slogan'    => 'required|min:3',
            'listgame'  => 'required|integer',
            'leader'    => 'required|integer',
            'listeam'   => 'required|array',
        ];

        $messages = [
            'nameteam.required'  => 'Nama Tim wajib diisi',
            'nameteam.min'       => 'Nama Tim minimal 3 karakter',
            'slogan.required'    => 'Slogan wajib diisi',
            'slogan.min'         => 'Slogan minimal 3 karakter',
            'listgame'           => 'Game wajib dipilih',
            'leader'             => 'Leader Tim wajib dipilih',
            'listeam'            => 'Tim pemain wajib dipilih',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $team = TeamModel::find($id);

        $filename = $team->file;
        $filename1 = $team->cover;

        if (!empty($request->file)) {
            File::delete(public_path("uploads/" . $team->file));
            $namefile = str_replace(' ', '_', $request->file->getClientOriginalName());
            $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $filename);
        }

        if (!empty($request->cover)) {
            File::delete(public_path("uploads/" . $team->cover));
            $namefile1 = str_replace(' ', '_', $request->cover->getClientOriginalName());
            $filename1  = $namefile1 . '_' . time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('uploads'), $filename1);
        }

        $encode = json_encode($request->listeam);

        $team->update([
            'team_name' => $request->nameteam,
            'slogan' => $request->slogan,
            'desc' => $request->desc,
            'file' => $filename,
            'cover' => $filename1,
            'games' => $request->listgame,
            'atlet' => $encode,
            'leader_team' => $request->leader,
            'club_id' => $club_id,
            'cabang_id' => $request->cabor
        ]);

        return redirect()->to('clubs/' . $club_id . '/teams')
            ->with('success', 'Team created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($club_id, $id)
    {
        //
        TeamModel::find($id)->delete();
        return redirect()->to('clubs/' . $club_id . '/teams')
            ->with('success', 'Team deleted successfully');
    }
}
