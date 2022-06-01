<?php

namespace App\Http\Controllers\Admin;

use App\Models\ACL\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with("permissions", "states")->get();

        return $this->jsonResponse("Success", $roles);
    }

    public function getPermissions()
    {
        $permissions = Permission::all();

        return $this->jsonResponse("Success", $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required"
        ]);

        $role = Role::create(['name' => $request->name, "active" => 1, "guard_name" => "web"]);

        $role->syncPermissions($request->permissions);

        $role->states()->attach($request->order_states);

        return $this->jsonResponse("Success", $role->load("states"));
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

        return $this->jsonResponse("Success", $role);
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
        $role = Role::findOrFail($id);

        $this->validate($request, [
            "name" => "required"
        ]);

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        $role->states()->sync($request->order_states);

        return $this->jsonResponse("Success", $role->load('states'));
    }

    public function activate($id)
    {
        $role = Role::findOrFail($id);

        $role->active = 1;
        $role->deactivation_notes = null;
        $role->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $role = Role::findOrFail($id);

        $role->active = 0;
        $role->deactivation_notes = $request->deactivation_notes;
        $role->save();

        return $this->jsonResponse("Success");
    }
}
