<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role != 'Administrator') abort(404);        
        $users = User::orderBy('role')->paginate(10);

        return view('listuser', [
            'title' => 'List Akun',
            'users' => $users,
            'script' => 'user',
        ]);
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
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required|confirmed',
        ];

        if ($request->role == 'Surveyor') {
            $rules['role'] = 'required';
        }

        $request->validate($rules);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->role == 'Surveyor') {
            $user->team_id = $request->team;
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/user')->with('message', 'Input Data User Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [];
        if ($request->has('name')) {
            $rules = [
                'name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'role' => 'required',
            ];
            if (filled($request->username) && $request->username != $user->username) $rules['username'] = 'required|unique:users';
    
            if ($request->role == 'Surveyor') $rules['team'] = 'required';
        }

        if (filled($request->password)) $rules['password'] = 'confirmed';

        $request->validate($rules);

        $userData = [];

        if ($request->has('name')) {
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role' => $request->role,
            ];
            if (filled($request->team)) $userData['team_id'] = $request->team;
        }

        if (filled($request->password)) $userData['password'] = Hash::make($request->password);

        $user->update($userData);

        $msg = 'Ganti Password Berhasil';
        $url = '/profile';

        if ($request->has('name')) {
            $msg = 'Update Data User Berhasil';
            $url = '/user';
        }

        return redirect($url)->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::table('users')
            ->where('id', $user->id)
            ->delete();
        return redirect('/user')->with('message', 'Hapus Data User Berhasil');
    }

    public function profile()
    {
        return view('datauser', [
            'title' => 'Profile',
            'user' => auth()->user(),
            'script' => 'user'
        ]);
    }
}
