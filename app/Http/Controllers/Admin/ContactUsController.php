<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\ContactUs;

class ContactUsController extends Controller
{

    public function index(Request $request)
    {
        $contactQuery = ContactUs::query();

        $contactQuery->when($request->q, function($q) use ($request) {
            $q->where("name", "LIKE", "%{$request->q}%")->orWhere("phone", "LIKE", "%{$request->q}%")->orWhere("email", "LIKE", "%{$request->q}%");
        });

        $contacts = $contactQuery->orderBy("created_at", "DESC")->paginate(20);

        return $this->jsonResponse("Success", [
            "items" => $contacts->items(),
            "total" => $contacts->total()
        ]);
    }

    public function updateResolved(Request $request, $id)
    {
        $contact = ContactUs::findOrFail($id);

        $this->validate($request, [
            "resolved" => "required|in:0,1"
        ]);

        $contact->update(["resolved" => $request->resolved]);

        return $this->jsonResponse("Success", $contact);
    }
}
