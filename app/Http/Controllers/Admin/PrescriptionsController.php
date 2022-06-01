<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\PrescriptionResource;
use App\Models\Medical\Prescription;
use App\Models\Services\PushService;
use App\Models\Users\Address;
use App\Models\Users\User;
use App\Notifications\PrescriptionsChangeStatus;
use App\Sheets\Export\Prescriptions\PrescriptionsExport;
use App\Sheets\Export\Products\ProductsFullExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PrescriptionsController extends Controller
{
    private $pushService;
    public function __construct(PushService $pushService)
    {
        $this->pushService = $pushService;
    }

    public function index(Request $request)
    {
        // $query = Prescription::whereHas( "user",  function($user) use ($request) {
        //     if($request->q) {
        //         return $user->where('name', 'like', "%{$request->q}%")->orWhere('phone', "%{$request->q}%");
        //     }
        // })->with(["user.addresses", "address"]);
        $query = Prescription::with(["user.addresses", "address"]);
        $prescriptions = $query->orderBy('id', 'desc')->paginate(20);

    	return $this->jsonResponse("Success", [
    	    'prescriptions' => PrescriptionResource::collection($prescriptions),
            'total' => $prescriptions->total()
        ]);
    }

    /**
     * Assign prescription to admin
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function assignAdmin(Request $request, $id)
    {
        $request->validate([
            'admin_id' => 'required'
        ]);
        $prescription = Prescription::findOrFail($id);

        if (!$prescription->admin) {
            $prescription->update([
                'admin_id' => $request->admin_id,
                'assigned_at' => now()
            ]);
        }

    	return $this->jsonResponse("Success", [
    	    'prescriptions' => new PrescriptionResource($prescription->load("admin"))
        ]);
    }

    /**
     * Change prescription status
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function changeStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required',
            'invoice_id' => Rule::requiredIf($request->status == 2),
            'amount' => [
                Rule::requiredIf($request->status == 2)
            ],
            'comment' => Rule::requiredIf($request->status == 2)
        ]);
        $prescription = Prescription::find($id);
        switch ($request->status) {
            case 3 : $data = ['status' => $request->status]; break;
            case 2 : unset($data['cancellation_id']); break;
            case 4 :
                $data= [
                    'status' => $request->status,
                    'cancellation_id' => $request->cancellation_id,
                    'cancellation_text' => $request->cancellation_text,
                ];
                break;
        }

        $prescription->update($data);
        $prescription->user ? $prescription->user->notify(new PrescriptionsChangeStatus($prescription)) : null;
        return $this->jsonResponse('success', new PrescriptionResource($prescription));
    }
    /**
     * Export prescriptions
     *
     * @return void
     */
    public function export()
    {
        $fileName = "prescriptionsExport_" . date("Y-m-d-H-i-s") . '.xlsx';
        $filePath = 'public/exports/prescriptions/' . $fileName;
        $fileUrl = url("storage/exports/prescriptions") . "/" . $fileName;
        Excel::store(new PrescriptionsExport(), $filePath);
        $filePath = url("storage/exports") . '/' . $fileName . '.xlsx';
        Log::channel('exports')->info('Action: prescriptions Export , File link: ' . url($filePath) . ' Admin name: ' . auth()->user()->name . ' Date: ' . now());
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->User()->id);
        return $this->jsonResponse("Success");
    }
}
