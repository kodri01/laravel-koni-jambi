<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Atlet;
use App\Models\Cabor;
use App\Models\Club;
use App\Models\RequestAtlets;

class AtletsController extends Controller
{

    public function __construct()
    {
        # code...
        $this->middleware(['permission:atlets-list|atlets-create|atlets-edit|atlets-delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($club_id)
    {
        //
        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        if ($role->name == 'superadmin') {
            $lists = DB::table('users')
                ->join('atlets', 'users.id', '=', 'atlets.iduser')
                ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
                ->select('users.*', 'atlets.*', 'atlets.id as atlet_id')
                ->where('users.active_atlet', 1)
                ->whereNull('atlets.deleted_at')
                ->where('clubs.id', $club_id)
                ->paginate(10);
            return view('pages.clubs.atlets.index', compact('lists', 'club_id'));
        } else {
            $lists = DB::table('users')
                ->join('atlets', 'users.id', '=', 'atlets.iduser')
                ->join('clubs', 'atlets.club_id', '=', 'clubs.id')
                ->select('users.*', 'atlets.*', 'atlets.id as atlet_id')
                ->where('users.active_atlet', 1)
                ->whereNull('atlets.deleted_at')
                ->where('clubs.id', $club_id)
                ->where('clubs.cabang_id', auth::user()->cabang_id)
                ->paginate(10);
            return view('pages.clubs.atlets.index', compact('lists', 'club_id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($club_id)
    {
        //
        $cabors = Cabor::get();
        $clubs = Club::find($club_id);
        $role = Role::get();
        return view('pages.clubs.atlets.add', compact('cabors', 'clubs', 'club_id', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $club_id)
    {
        //
        // return dd($club_id);
        $rules = [
            'firstname' => 'required|min:3',
            'lastname'  => 'required|min:3',
            'email'     => 'required|email|unique:users',
            'pass'      => 'required|min:3',
            'file'      => 'required|file|mimes:jpg,jpeg,bmp,png',
            'filektp'   => 'required|file|mimes:jpg,jpeg,bmp,png',
        ];

        $messages = [
            'firstname.required'  => 'Firstname wajib diisi',
            'firstname.min'       => 'Firstname minimal 3 karakter',
            'lastname.required'   => 'Lastname wajib diisi',
            'lastname.min'        => 'Lastname minimal 3 karakter',
            'email.required'      => 'Email wajib diisi',
            'pass.required'       => 'Password wajib diisi',
            'pass.min'            => 'Password minimal 3 karakter',
            'file.required'       => 'Foto profile wajib diupload',
            'filektp.required'    => 'Foto KTP wajib diupload',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $namefile = str_replace(' ', '_', $request->file->getClientOriginalName());
        $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $filename);

        $namefile1 = str_replace(' ', '_', $request->filektp->getClientOriginalName());
        $filename1  = $namefile1 . '_' . time() . '.' . $request->filektp->extension();
        $request->filektp->move(public_path('uploads'), $filename1);

        $role = Role::find(4);
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
            'active' => 1,
            'active_atlet' => 1
        ]);
        $insertid = $user->id;
        Atlet::create([
            'iduser' => $insertid,
            'club_id' => $club_id,
        ]);
        $user->assignRole($role->name);

        return redirect()->to('clubs/' . $club_id . '/atlets')
            ->with('success', 'atlet created successfully');
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
        $atlet = Atlet::find($id);
        $user = User::find($atlet->iduser);
        $cabors = Cabor::get();
        return view('pages.clubs.atlets.edit', compact('user', 'cabors', 'club_id'));
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
        // return dd($id);
        $rules = [
            'firstname' => 'required|min:3',
            'lastname'  => 'required|min:3',
            'email'     => 'required|email|unique:users,email,' . $id,
        ];

        $messages = [
            'firstname.required'  => 'Firstname wajib diisi',
            'firstname.min'       => 'Firstname minimal 3 karakter',
            'lastname.required'   => 'Lastname wajib diisi',
            'lastname.min'        => 'Lastname minimal 3 karakter',
            'email.required'      => 'Email wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);

        $filename = $user->profile_pic;
        $filename1 = $user->profile_ktp;

        if (!empty($request->file)) {
            File::delete(public_path("uploads/" . $user->profile_pic));

            $namefile = str_replace(' ', '_', $request->file->getClientOriginalName());
            $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $filename);
        }

        if (!empty($request->filektp)) {
            File::delete(public_path("uploads/" . $user->profile_ktp));

            $namefile1 = str_replace(' ', '_', $request->filektp->getClientOriginalName());
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
            'active' => 1
        ]);

        return redirect()->to('clubs/' . $club_id . '/atlets')
            ->with('success', 'atlet updated successfully');
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
        $atlet = Atlet::find($id);
        $user = User::find($atlet->iduser);
        DB::table('model_has_roles')->where('model_id', $atlet->iduser)->delete();
        $role = Role::find(2);
        $user->assignRole($role->name);
        $user->update(['active_atlet' => 0]);
        $atlet->delete();

        return redirect()->to('clubs/' . $club_id . '/atlets')
            ->with('success', 'atlet deleted successfully');
    }

    public function mail()
    {
        # code...
        return view('pages.clubs.atlets.sendmail');
    }

    // public function sendmail(Request $request)
    // {
    //     # code...
    //     $details = [
    //         'title' => 'Hallo Calon atlet',
    //         'body' => $request->message
    //     ];

    //     try {
    //         \mail::to($request->mail)->send(new \App\Mail\EsportMail($details));
    //     } catch (\Exception $e) {
    //         echo "Email gagal dikirim karena $e.";
    //     }

    //     return redirect()->route('atlets.index')
    //         ->with('success', 'atlets send successfully');
    // }

    public function selectatlet($club_id)
    {
        # code...
        // $lists = User::join('atlets','users.id')
        $lists = User::where('active', 1)->where('active_atlet', 0)->get();
        $cabors = Cabor::get();
        $clubs = Club::find($club_id);
        return view('pages.clubs.atlets.select', compact('lists', 'cabors', 'clubs', 'club_id'));
    }

    public function directjoin(Request $request, $club_id)
    {
        # code...
        Atlet::create([
            'iduser' => $request->selectuser,
            'club_id' => $club_id,
        ]);

        $role = Role::find(4);
        $user = User::find($request->selectuser);
        $user->update(['active_atlet' => 1, 'cabang_id' => $request->cabor]);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($role->name);

        return redirect()->to('clubs/' . $club_id . '/atlets')
            ->with('success', 'atlets has been join to atlet');
    }

    public function requestatlet($club_id)
    {
        # code...
        // $lists = Requestatlets::where('club_id',$club_id)
        //         ->where('approve',0)
        //         ->whereNull('deleted_at')->paginate(5);
        $lists = DB::table('request_atlets')
            ->join('users', 'request_atlets.user_id', 'users.id')
            ->select('users.*', 'users.id as user_id', 'request_atlets.*')
            ->where('request_atlets.approve', 0)
            ->whereNull('request_atlets.deleted_at')->paginate(5);
        // return dd($lists);
        return view('pages.clubs.atlets.request', compact('lists', 'club_id'));
    }

    public function requestatletapprove($club_id, $id)
    {
        # code...
        // return dd($club_id);
        $requestatlets = RequestAtlets::find($id);
        $user_id = $requestatlets->user_id;

        Atlet::create([
            'iduser' => $user_id,
            'club_id' => $club_id,
        ]);

        $role = Role::find(4);
        $user = User::find($user_id);
        $user->update(['active_atlet' => 1]);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($role->name);

        $requestatlets->update(['approve' => 1]);

        return redirect()->to('clubs/' . $club_id . '/atlets/request')
            ->with('success', 'Approve atlet request successfully');
    }

    public function requestatletdelete($club_id, $id)
    {
        # code...
        RequestAtlets::find($id)->delete();
        return redirect()->to('clubs/' . $club_id . '/atlets/request')
            ->with('success', 'Rejected atlet request');
    }
}
