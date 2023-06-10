<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Cabor;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        # code...
        $this->middleware(['permission:admins-list|admins-create|admins-edit|admins-delete']);
    }

    public function index()
    {
        # code...
        // return dd(auth::user()->cabang_id);
        // $index = User::where('active', 99)->orderby('cabang_id', auth::user()->cabang_id)->paginate(5);
        $index = User::where('active', 99)->orderBy('id', 'ASC')->paginate(5);
        $data = ['lists' => $index];

        return view('pages.user.users', $data);
    }

    public function create()
    {
        # code...
        $role = Role::get();
        $cabors = Cabor::get();
        return view('pages.user.add', compact('role', 'cabors'));
    }

    public function store(Request $request)
    {
        # code...
        $rules = [
            'firstname' => 'required|min:3',
            'lastname'  => 'required|min:3',
            'tgl_lahir'  => 'required|date',
            'no_telp'  => 'required|min:12',
            'no_ktp'  => 'required|min:15',
            'no_kk'  => 'required|min:15',
            'email'     => 'required|email|unique:users',
            'pass'      => 'required|min:3',
            'domisili'  => 'required|min:3',
            'file'      => 'required|file|mimes:jpg,jpeg,bmp,png',
            'filektp'   => 'required|file|mimes:jpg,jpeg,bmp,png'
        ];

        $messages = [
            'firstname.required'  => 'Firstname wajib diisi',
            'firstname.min'       => 'Firstname minimal 3 karakter',
            'lastname.required'  => 'Lastname wajib diisi',
            'lastname.min'       => 'Lastname minimal 3 karakter',
            'tgl_lahir.required'       => 'Tanggal Lahir Wajib Diisi',
            'no_telp.min'       => 'Nomor Telp minimal 12 karakter',
            'no_telp.required'       => 'Nomor Telpon wajib diisi',
            'no_ktp.min'       => 'Nomor KTP minimal 15 karakter',
            'no_ktp.required'       => 'Nomor KTP wajib diisi',
            'no_kk.min'       => 'Nomor KK minimal 15 karakter',
            'no_kk.required'       => 'Nomor KK wajib diisi',
            'email.required' => 'Email wajib diisi',
            'pass.required'  => 'Password wajib diisi',
            'pass.min'       => 'Password minimal 3 karakter',
            'file.required'  => 'Foto profile wajib diupload',
            'filektp.required'  => 'Foto KTP wajib diupload',
            'domisili.required' => 'Domisili wajib diisi',
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

        $role = Role::find($request->role);
        $user = User::create([
            'name' => $request->firstname,
            'lastname' => $request->lastname,
            'tgl_lahir' => $request->tgl_lahir,
            'no_telp' => $request->no_telp,
            'no_ktp' => $request->ktp,
            'no_kk' => $request->no_kk,
            'address' => $request->address,
            'domisili' => $request->domisili,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'profile_pic' => $filename,
            'profile_ktp' => $filename1,
            'active' => ($role->name == 'atlet') ? 1 : 99,
            'active_atlet' => 0,
            'cabang_id' => $request->cabor
        ]);
        $user->assignRole($role->name);

        return redirect()->route('admins')
            ->with('success', 'Admins created successfully');
    }

    public function show($id)
    {
        # code...
        $user = User::find($id);
        $role = Role::get();
        $roleuser = DB::table('model_has_roles')->where('model_id', $id)->first();
        $cabors = Cabor::get();

        return view('pages.user.edit', compact('user', 'role', 'roleuser', 'cabors'));
    }

    public function update(Request $request, $id)
    {
        # code...
        $rules = [
            'firstname' => 'required|min:3',
            'lastname'  => 'required|min:3',
            'email'     => 'required|email|unique:users,email,' . $id,
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

        $role = Role::find($request->role);
        $get = User::find($id);
        $filename = $get->profile_pic;
        $filename1 = $get->profile_ktp;

        if (!empty($request->file)) {
            File::delete(public_path("uploads/" . $get->profile_pic));
            $namefile = str_replace(' ', '_', pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename  = $namefile . '_' . time() . '.' . $request->file->extension();
            $request->file->move(public_path('uploads'), $filename);
        }

        if (!empty($request->filektp)) {
            File::delete(public_path("uploads/" . $get->profile_ktp));
            $namefile1 = str_replace(' ', '_', pathinfo($request->filektp->getClientOriginalName(), PATHINFO_FILENAME));
            $filename1  = $namefile1 . '_' . time() . '.' . $request->filektp->extension();
            $request->filektp->move(public_path('uploads'), $filename1);
        }

        if (empty($request->pass)) {
            $pass = $get->password;
        } else {
            $pass = Hash::make($request->pass);
        }

        $user = User::find($id);
        $user->update([
            'name' => $request->firstname,
            'lastname' => $request->lastname,
            'tgl_lahir' => $request->tgl_lahir,
            'no_telp' => $request->no_telp,
            'no_ktp' => $request->ktp,
            'no_kk' => $request->no_kk,
            'address' => $request->address,
            'domisili' => $request->domisili,
            'email' => $request->email,
            'password' => Hash::make($request->pass),
            'profile_pic' => $filename,
            'profile_ktp' => $filename1,
            'active' => ($role->name == 'atlet') ? 1 : 99,
            'active_atlet' => 0,
            'cabang_id' => $request->cabor
        ]);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($role->name);

        return redirect()->route('admins')
            ->with('success', 'Admins updated successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->delete();
        return redirect()->route('admins')
            ->with('success', 'Admins deleted successfully');
    }
}
