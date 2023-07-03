<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pelatih;
use App\Models\User;
use App\Models\TeamModel;
use App\Models\EventOrganizations;
use App\Models\Cabor;
use App\Models\Club;

class PelatihController extends Controller
{
    public function __construct()
    {
        # code...
        $this->middleware(['permission:pelatih-list|pelatih-create|pelatih-edit|pelatih-delete']);
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
            $lists = DB::table('pelatih')
                ->join('clubs', 'pelatih.club_id', 'clubs.id')
                ->join('users', 'pelatih.user_id', 'users.id')
                ->select(
                    'pelatih.id',
                    'users.id as user_id',
                    'clubs.iduser as club_iduser',
                    'users.cabang_id',
                    'users.name',
                    'users.lastname',
                    'users.address',
                    'users.no_ktp',
                    'users.profile_ktp',
                    'users.profile_pic',
                    'users.email'
                )
                ->where('pelatih.club_id', $club_id)
                ->whereNull('pelatih.deleted_at')
                ->paginate(5);
            return view('pages.clubs.pelatih.index', compact('lists', 'club_id'));
        } else {
            $lists = DB::table('pelatih')
                ->join('clubs', 'pelatih.club_id', 'clubs.id')
                ->join('users', 'pelatih.user_id', 'users.id')
                ->select(
                    'pelatih.id',
                    'users.id as user_id',
                    'clubs.iduser as club_iduser',
                    'users.cabang_id',
                    'users.name',
                    'users.lastname',
                    'users.address',
                    'users.no_ktp',
                    'users.profile_ktp',
                    'users.profile_pic',
                    'users.email'
                )
                ->where('pelatih.club_id', $club_id)
                ->where('pelatih.cabang_id', auth::user()->cabang_id)
                ->whereNull('pelatih.deleted_at')
                ->paginate(5);
            return view('pages.clubs.pelatih.index', compact('lists', 'club_id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($club_id)
    {
        # code...

        $users = DB::table('users')->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->select('users.*', 'model_has_roles.role_id', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)->paginate(5);
        $teams = TeamModel::get();
        $clubs = Club::find($club_id);
        $cabors = Cabor::get();
        return view('pages.clubs.pelatih.add', compact('users', 'teams', 'cabors', 'clubs', 'club_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $club_id)
    {
        # code...
        $rules = [
            'firstname' => 'required|min:3',
            'lastname'  => 'required|min:3',
            'email'     => 'required|email|unique:users',
            'pass'      => 'required|min:3',
            'file'      => 'required|file|mimes:jpg,jpeg,bmp,png',
            'filektp'   => 'required|file|mimes:jpg,jpeg,bmp,png'
        ];

        $messages = [
            'firstname.required'  => 'Firstname wajib diisi',
            'firstname.min'       => 'Firstname minimal 3 karakter',
            'lastname.required'  => 'Lastname wajib diisi',
            'lastname.min'       => 'Lastname minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'pass.required'  => 'Password wajib diisi',
            'pass.min'       => 'Password minimal 3 karakter',
            'file.required'  => 'Foto profile wajib diupload',
            'filektp.required'  => 'Foto KTP wajib diupload'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $namefile = str_replace(' ', '_', pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $filename);

        $namefile1 = str_replace(' ', '_', pathinfo($request->filektp->getClientOriginalName(), PATHINFO_FILENAME));
        $filename1  = $namefile1 . '_' . time() . '.' . $request->filektp->extension();
        $request->filektp->move(public_path('uploads'), $filename1);

        $role = Role::find(3);
        $user = User::create([
            'name' => $request->firstname,
            'lastname' => $request->lastname,
            'tgl_lahir' => $request->tgl_lahir,
            'no_telp' => $request->no_telp,
            'no_ktp' => $request->ktp,
            'no_kk' => $request->no_kk,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'cabang_id' => $request->cabor,
            'profile_pic' => $filename,
            'profile_ktp' => $filename1,
            'active' => 99,
            'active_atlet' => 0
        ]);
        $user->assignRole($role->name);

        // $teams = json_encode($request->listeam);
        Pelatih::create([
            'club_id' => $club_id,
            'user_id' => $user->id,
            'cabang_id' => $request->cabor
        ]);

        return redirect()->to('clubs/' . $club_id . '/pelatih')
            ->with('success', 'Pelatih create successfully');
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
        # code...
        $pelatih = Pelatih::find($id);
        $user = User::find($pelatih->user_id);
        // $teams = TeamModel::get();
        // $memberarr = [];
        // $de = json_decode($pelatih->team_name);
        // foreach($de as $member){$memberarr[] = $member;} 
        $cabors = Cabor::get();
        return view('pages.clubs.pelatih.edit', compact('pelatih', 'user', 'cabors', 'club_id'));
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
        # code...
        $rules = [
            'firstname' => 'required|min:3',
            'lastname'  => 'required|min:3',
        ];

        $messages = [
            'firstname.required'  => 'Firstname wajib diisi',
            'firstname.min'       => 'Firstname minimal 3 karakter',
            'lastname.required'  => 'Lastname wajib diisi',
            'lastname.min'       => 'Lastname minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // $teams = json_encode($request->listeam);
        $pelatih = Pelatih::find($id);
        $user = User::find($pelatih->user_id);

        $filename = $user->profile_pic;
        $filename1 = $user->profile_ktp;

        if (!empty($request->file)) {
            File::delete(public_path("uploads/" . $user->profile_pic));
            $namefile = str_replace(' ', '_', pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $filename);
        }

        if (!empty($request->filektp)) {
            File::delete(public_path("uploads/" . $user->profile_ktp));
            $namefile1 = str_replace(' ', '_', pathinfo($request->filektp->getClientOriginalName(), PATHINFO_FILENAME));
            $filename1  = $namefile1 . '_' . time() . '.' . $request->filektp->extension();
            $request->filektp->move(public_path('uploads'), $filename1);
        }

        if (empty($request->pass)) {
            $pass = $user->password;
        } else {
            $pass = Hash::make($request->pass);
        }

        $user->update([
            'name' => $request->firstname,
            'lastname' => $request->lastname,
            'tgl_lahir' => $request->tgl_lahir,
            'no_telp' => $request->no_telp,
            'no_ktp' => $request->ktp,
            'no_kk' => $request->no_kk,
            'address' => $request->address,
            'email' => $request->email,
            'password' => $pass,
            'cabang_id' => $request->cabor,
            'profile_pic' => $filename,
            'profile_ktp' => $filename1,
            'active' => 99,
            'active_atlet' => 0
        ]);

        $pelatih->update([
            'club_id' => $club_id,
            'user_id' => $user->id,
            'cabang_id' => $request->cabor
        ]);

        return redirect()->to('clubs/' . $club_id . '/pelatih')
            ->with('success', 'pelatihs updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($club_id, $id)
    {
        # code...
        // $event = EventOrganizations::where('idorganization',$id)->get();
        // if(!empty($event)){
        //     EventOrganizations::where('idorganization',$id)->delete();
        // }

        $org = Pelatih::find($id);
        $user = User::find($org->user_id);
        DB::table('model_has_roles')->where('model_id', $org->user_id)->delete();
        $user->delete();
        $org->delete();

        return redirect()->to('clubs/' . $club_id . '/pelatih')
            ->with('success', 'pelatih deleted successfully');
    }

    public function eventcreate($idorg)
    {
        # code...
        return view('pages.organizations.event.add', compact('idorg'));
    }
}
