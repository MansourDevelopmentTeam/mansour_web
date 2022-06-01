<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::with("roles")->where("type", 2)->get();

        return $this->jsonResponse("Success", $admins);
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
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8"
        ]);
        $request->merge(["type" => 2, "password" => bcrypt($request->password),"active"=>1]);
        $admin = User::create($request->only(["name", "email", "password", "type","active"]));
        $admin->assignRole($request->role_id);
        $admin->refresh();
        return $this->jsonResponse("Success", $admin->load("roles"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = User::where("id", $id)->where("type", 2)->first();

        return $this->jsonResponse("Success", $admin);
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
        $admin = User::where("id", $id)->where("type", 2)->first();

        $this->validate($request, [
            "name" => "required",
            "email" => "required|email|unique:users,email,{$id}",
            "password" => "nullable|min:8"
        ]);


        $admin->update($request->only(["name", "email"]));
        if ($request->password) {
            $admin->update(["password" => bcrypt($request->password)]);
        }

        $admin->syncRoles($request->role_id);

        return $this->jsonResponse("Success", $admin->load("roles"));
    }

    public function activate($id)
    {
        $admin = User::findOrFail($id);

        $admin->active = 1;
        $admin->deactivation_notes = null;
        $admin->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $this->validate($request, ["deactivation_notes" => "required"]);

        $admin = User::findOrFail($id);

        $admin->active = 0;
        $admin->deactivation_notes = $request->deactivation_notes;
        $admin->save();

        return $this->jsonResponse("Success");
    }
}
