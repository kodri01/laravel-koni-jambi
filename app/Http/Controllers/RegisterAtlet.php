<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\Cabor;
use App\Models\Club;
use App\Models\Atlet;
use App\Models\User;
use PhpParser\Node\NullableType;

class RegisterAtlet extends Controller
{
    //
    public function index()
    {
        # code...
        $cabors = Cabor::get();
        $roles = Role::get();
        $clubs = Club::get();
        return view('Auth.register', compact('cabors', 'roles', 'clubs'));
    }

    public function add(Request $request)
    {
        # code...
        $rules = [
            'firstname' => 'required|min:3',
            'lastname'  => 'required|min:3',
            'tgl_lahir'  => 'required|date',
            'no_telp'  => 'required|min:12',
            'no_ktp'  => 'required|min:15|unique:users',
            'no_kk'  => 'required|min:15',
            'email'     => 'required|email|unique:users',
            'pass'      => 'required|min:3',
            'file'      => 'required|file|mimes:jpg,jpeg,bmp,png',
            'filektp'   => 'required|file|mimes:jpg,jpeg,bmp,png',
        ];

        $messages = [
            'firstname.required'  => 'Firstname wajib Diisi',
            'firstname.min'       => 'Firstname Minimal 3 Karakter',
            'lastname.required'  => 'Lastname Wajib Diisi',
            'lastname.min'       => 'Lastname Minimal 3 Karakter',
            'tgl_lahir.required'       => 'Tanggal Lahir Wajib Diisi',
            'no_telp.min'       => 'Nomor Telp Minimal 12 Karakter',
            'no_telp.required'       => 'Nomor Telpon Wajib Diisi',
            'no_ktp.min'       => 'Nomor KTP Minimal 15 Karakter',
            'no_ktp.required'       => 'Nomor KTP Wajib Diisi',
            'no_ktp.unique'       => 'Nomor KTP Sudah Terdaftar',
            'no_kk.min'       => 'Nomor KK Minimal 15 Karakter',
            'no_kk.required'       => 'Nomor KK Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.unique' => 'Email Sudah Terdaftar, Coba Email yang Lain',
            'pass.required'  => 'Password Wajib Diisi',
            'pass.min'       => 'Password Minimal 3 Karakter',
            'file.required'  => 'Foto Profile wajib Diupload',
            'filektp.required'  => 'Foto KTP Wajib Diupload',
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
            'no_ktp' => $request->no_ktp,
            'no_kk' => $request->no_kk,
            'address' => $request->address,
            'profile_ktp' => $filename,
            'profile_pic' => $filename1,
            'email' => $request->email,
            'active' => 1,
            'password' => Hash::make($request->pass),
            'cabang_id' => $request->cabor
        ]);
        $insertid = $user->id;
        Atlet::create([
            'iduser' => $insertid,
            'club_id' => $request->club_id,
            'status' => 1,
        ]);
        $user->assignRole($role->name);

        return redirect()->route('login')->with('success', 'Account Anda berhasil dibuat, silahkan login ');
    }
}
