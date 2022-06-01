<?php

namespace App\Http\Controllers\Customer;

use App\Facade\Sms;
use Illuminate\Http\Request;
use App\Models\Users\Address;
use App\Services\SmsServices;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Medical\Prescription;
use App\Models\Services\PushService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Customer\PrescriptionRequest;
use App\Http\Resources\Customer\PrescriptionResource;

class PrescriptionsController extends Controller
{
    private $pushService;
    private $smsServices;

    public function __construct(PushService $pushService, SmsServices $smsServices)
    {
        $this->pushService = $pushService;
        $this->smsServices = $smsServices;
    }

    public function index()
    {
        $user = auth()->user();

        return $this->jsonResponse("Success", PrescriptionResource::collection($user->prescriptions->sortByDesc('id')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Customer\PrescriptionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionRequest $request)
    {
        $user = auth()->user();

        $prescription = Prescription::create([
            "address_id" => $request->address_id,
            "name" => $request->name,
            "note" => $request->note,
            "user_id" => $user ? $user->id : null
        ]);
        foreach ($request->images as $image) {
            $prescription->images()->create([
                'url' => $image
            ]);
        }
        $this->pushService->notifyAdmins("Medical Prescription", "You Have New a prescription requested With ID #{$prescription->id}");

        return $this->jsonResponse("Success", new PrescriptionResource($prescription));
    }
    /**
     * Cancel a prescription.
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function CancelPrescription(Request $request, $id)
    {
        $this->validate($request, [
            "cancellation_id" => "required"
        ]);
        $user = auth()->user();

        $prescription = Prescription::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $prescription->update([
            'status' => 4,
            'cancellation_id' => $request->cancellation_id,
            'cancellation_text' => $request->cancellation_text,
        ]);
        return $this->jsonResponse('success', new PrescriptionResource($prescription));
    }

}
