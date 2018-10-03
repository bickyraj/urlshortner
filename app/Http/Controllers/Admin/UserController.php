<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Client;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Str;
use App\Http\Resources\Admin\User as UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('role')->whereNotIn('id', [1])->get();

        // return collection of user as a resource.
        return UserResource::collection($user);
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

        $status = 0;
        $user = $request->isMethod('patch') ? User::findOrFail($request->id) : new User;

        $request->validate([
            'location' => 'required',
        ]);

        $user->id = $request->input('id');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->username = $request->input('username');
        $user->role_id = ($request->input('role_id'))? $request->input('role_id'): 2;
        $user->register_date = $request->input('register_date');
        // $user->password = Hash::make(str_random(8));
        $user->password = Hash::make('test123');
        $user->phone = $request->input('phone');

        if ($user->save()) {
            $status = 1;
        }

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('role')->where('id', $id)->first();
        $status = 0;
        if ($user) {
            $status = 1;
        }

        return response()->json([
            'data' => $user,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        $status = 0;
        $id = $request->id;
        $this->validate($request, [
            'email' => "required|unique:users,email,$id|max:255"
        ]);

        $user = User::findOrFail($request->id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->name = $request->input('firstname') . " " . $request->input('lastname');
        $user->email = $request->input('email');
        $user->username = $request->input('username');

        if ($request->input('role_id')) {
            $user->role_id = $request->input('role_id');
        }
        $user->register_date = $request->input('register_date');
        $user->phone = $request->input('phone');

        if ($user->save()) {
            $status = 1;
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get user.
        $user = User::findOrFail($id);
        $status = 0;
        if ($user->delete()) {
            $status = 1;
        }
        return response()->json([
            'status' => $status,
        ]);
    }

    public function getUser()
    {
        return auth()->user();
    }
}
