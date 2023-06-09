<?php

namespace App\Http\Controllers;

use App\Models\Cabor;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


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
        $modelrole = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
        $role = Role::where('id', $modelrole->role_id)->first();
        if ($role->name == 'superadmin') {
            // $lists = Club::orderBy('id', 'ASC')->paginate(5);
            $lists = User::where('active_atlet', 1)->paginate(5);
            return view('pages.usernoatlet.users', compact('lists'));
        } else {
            $lists = User::where('active_atlet', 1)->where('cabang_id', auth::user()->cabang_id)->paginate(5);
            // $cabors = Cabor::get();
            return view('pages.usernoatlet.users', compact('lists'));
        }
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
