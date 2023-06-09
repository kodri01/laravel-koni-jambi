<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Club;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Cabor;
use App\Models\TeamModel;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\DB as FacadesDB;

class ClubsController extends Controller
{
    public function __construct()
    {
        # code...
        $this->middleware(['permission:clubs-list|clubs-create|clubs-edit|clubs-delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        if ($role->name == 'superadmin') {
            $lists = Club::orderBy('clubs.id', 'ASC')
                ->leftJoin('cabors', 'clubs.cabang_id', '=', 'cabors.id')
                ->select('clubs.*', 'cabors.name')
                ->paginate(5);
            return view('pages.clubs.index', compact('lists'));
        } else {
            $lists = Club::orderBy('clubs.id', 'ASC')
                ->leftJoin('cabors', 'clubs.cabang_id', '=', 'cabors.id')
                ->select('clubs.*', 'cabors.name')
                ->where('cabang_id', auth()->user()->cabang_id)->paginate(5);
            return view('pages.clubs.index', compact('lists'));
        }

        // $lists = Club::where('cabang_id', auth::user()->cabang_id)->paginate(5);
        // return view('pages.clubs.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $users = User::where('active', 1)->get();
        $users = DB::table('users')->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->select('users.*', 'model_has_roles.role_id', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 2)->paginate(5);
        $cabors = Cabor::get();
        return view('pages.clubs.add', compact('users', 'cabors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'user' => 'required|integer',
            'clubname' => 'required',
            'file'      => 'required|file|mimes:jpg,jpeg,bmp,png',
        ];

        $messages = [
            'user.required'       => 'Nama event wajib diisi',
            'clubname.required'     => 'Nama Club wajib diisi',
            'file.required'      => 'Logo Club wajib diupload',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $namefile = str_replace(' ', '_', $request->file->getClientOriginalName());
        $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $filename);


        Club::create([
            'iduser' => $request->user,
            'club_name' => $request->clubname,
            'slug' => Str::slug($request->clubname),
            'file' => $filename,
            'description' => $request->desc,
            'cabang_id' => $request->cabor
        ]);

        return redirect()->route('clubs.index')
            ->with('success', 'Club create successfully');
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

        $club = Club::find($id);
        $users = User::where('active', 99)->get();
        $cabors = Cabor::get();
        return view('pages.clubs.edit', compact('club', 'users', 'cabors'));
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
        $rules = [
            'user' => 'required|integer',
            'clubname' => 'required',
        ];

        $messages = [
            'user.required'       => 'Nama event wajib diisi',
            'clubname.required'     => 'Nama Club wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $club = Club::find($id);
        $filename = $club->file;

        if (!empty($request->file)) {
            File::delete(public_path("uploads/" . $club->file));

            $namefile = str_replace(' ', '_', $request->file->getClientOriginalName());
            $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $filename);
        }

        $club->update([
            'iduser' => $request->user,
            'club_name' => $request->clubname,
            'slug' => Str::slug($request->clubname),
            'file' => $filename,
            'description' => $request->desc,
            'cabang_id' => $request->cabor
        ]);

        return redirect()->route('clubs.index')
            ->with('success', 'Club updated successfully');
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
        Club::find($id)->delete();
        return redirect()->route('clubs.index')
            ->with('success', 'Club deleted successfully');
    }
}
