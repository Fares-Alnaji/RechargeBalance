<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Admin::all();
        return response()->view('cms.admin.index',  compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Admin $admin)
    {
        //
        $request->validate([
            'user_name' => 'required|string|min:3|max:40|alpha',
            'user_email' => 'required|email|unique:users,email,' . $admin->id,
            'active' => 'nullable|string|in:on',
            'user_password' => 'required|string',
            // 'balance ' => 'required'
        ]);

        $admin = new Admin();
        $admin->name = $request->input('user_name');
        $admin->email = $request->input('user_email');
        $password =  $request->input('user_password');
        $admin->password = Hash::make($password);
        $admin->active = $request->has('active');
        $admin->balance = $request->input('balance');
        $isSaved = $admin->save();
        if ($isSaved) {
            session()->flash('message', 'Admin created successfully');
            return redirect()->back();
        }
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
    public function edit(Admin $admin)
    {
        //
        return response()->view('cms.admin.edit' , compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
        $request->validate([
            'user_name' => 'required|string|min:3|max:40',
            'user_email' => 'required|email|unique:users,email,' . $admin->id,
            'active' => 'nullable|string|in:on',
            // 'balance ' => 'required'
        ]);

        $admin->name = $request->input('user_name');
        $admin->email = $request->input('user_email');
        $admin->active = $request->has('active');
        $admin->balance = $request->input('balance');
        $isSaved = $admin->save();
        if ($isSaved) {
            session()->flash('message', 'Admin Edit successfully');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
        //
        $isDeleted = $admin->delete();
        return redirect()->route('admins.index');
    }
}
