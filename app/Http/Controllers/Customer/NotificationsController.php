<?php

namespace App\Http\Controllers\Customer;

use App\Http\Resources\Client\NotificationsResource;
use App\Models\Notifications\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
    	$notifications = Auth::user()->notifications()->orderBy("created_at", "DESC")->paginate(10);

        $count = $notifications->total();

        $notifications = $notifications->getCollection();
        $ids = $notifications->pluck("id")->toArray();
        Notification::whereIn("id", $ids)->update(["read" => 1]);
		$unread_count = Auth::user()->notifications()->where("read", 0)->count();

        return $this->jsonResponse("Success", [
        	"items" => NotificationsResource::collection($notifications),
        	"total" => $count,
        	"unread_count" => $unread_count
        ]);
    }

    public function markRead()
    {
        Notification::Where('user_id', Auth::id())->update(["read" => 1]);
        return $this->jsonResponse("Success");
    }
}
