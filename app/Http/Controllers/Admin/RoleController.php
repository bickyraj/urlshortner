<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\Role as RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::where('id', '!=', 1)->paginate(15);

        // return collection of role as a resource.
        return RoleResource::collection($role);
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
        $role = new Role;
        $role->name = $request->input('name');

        if ($role->save()) {
            $status = 1;
        }

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        // return single role as resource.
        return new RoleResource($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $status = 0;

        $role = Role::findOrFail($request->id);
        $role->id = $request->input('id');
        $role->name = $request->input('name');

        if ($role->save()) {
            $status = 1;
        }

        return new RoleResource($role);
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
        // get role.
        $role = Role::findOrFail($id);
        $status = 0;
        if ($role->delete()) {
            $status = 1;
        }
        return response()->json([
            'status' => $status,
        ]);
    }
}
