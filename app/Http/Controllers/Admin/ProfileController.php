<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function profile()
    {
        return $this->jsonResponse("Success", \Auth::user()->load("roles.permissions"));
    }

    public function update(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => ["required", Rule::unique("users")->ignore(\Auth::id())],
            // "password" => "required_if:current_password|min:8"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $user = \Auth::user();
        $user->update($request->only(["name", "email", "image"]));

        if ($request->password) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
            } else {
                return $this->jsonResponse("Incorrect current password", "error", [], 401);
            }
        }

        return $this->jsonResponse("Success", $user);
    }

    public function getNotifications()
    {
        $notifications = Notification::where(function ($query) {
            $query->whereNull("user_id")->orWhere('user_id', \Auth::id());
        })->orderBy("created_at", "DESC")->get();
        $unread_count = Notification::where(function ($query) {
            $query->whereNull("user_id")->orWhere('user_id', \Auth::id());
        })->where("read", 0)->count();
        return $this->jsonResponse("Success", ["notifications" => $notifications, "unread" => $unread_count]);
    }

    public function deleteNotifications($id)
    {
        $notifications = Notification::find($id);
        if ($notifications) {
            if ($notifications->type == 11) {
                if (isset($notifications->details['link'])) {
                    $explode = explode('exports/', $notifications->details['link']);
                    $path = storage_path("app/public/exports/") . $explode[1];
                    if (file_exists($path))
                        unlink($path);
                }
            }
            $notifications->delete();
        }

        return $this->jsonResponse("Success", null);
    }

    public function markRead()
    {
        Notification::where(function ($query) {
            $query->whereNull("user_id")
                ->orWhere('user_id', \Auth::id());
        })->update(["read" => 1]);

        return $this->jsonResponse("Success");
    }
}
