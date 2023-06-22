<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CaborController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lists = Cabor::orderBy('id')->paginate(10);
        return view('pages.cabor.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.cabor.add');
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
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Nama cabang wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Cabor::create([
            'name' => $request->name,
            'user_id' => auth::user()->id
        ]);

        return redirect()->route('cabors.index')
            ->with('success', 'Cabang Olahraga create successfully');
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
        $cabor = Cabor::find($id);
        return view('pages.cabor.edit', compact('cabor'));
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
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Nama cabrang wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cabor = Cabor::find($id);

        $cabor->update([
            'name' => $request->name,
            'user_id' => auth::user()->id
        ]);

        return redirect()->route('cabors.index')
            ->with('success', 'Cabang Olahraga update successfully');
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
        Cabor::find($id)->delete();
        return redirect()->route('cabors.index')
            ->with('success', 'Cabang Olahraga deleted successfully');
    }
}
