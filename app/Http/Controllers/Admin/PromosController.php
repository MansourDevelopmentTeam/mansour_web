<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Payment\Promo;
use App\Sheets\Export\Promos\PromosExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class PromosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->jsonResponse("Success", Promo::with('paymentMethods')->orderBy("created_at", "DESC")->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "type" => "required|in:1,2,3",
            "amount" => "nullable|numeric",
            "expiration_date" => "required|date",
            "description" => "required",
            "name" => "required|unique:promos,name"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $promo = new Promo;
        $promo->type = $request->type;
        $promo->amount = $request->amount;
        $promo->max_amount = $request->type == 2 ? $request->max_amount * 100 : $request->max_amount;
        $promo->expiration_date = $request->expiration_date;
        $promo->description = $request->description;
        $promo->name = $request->name;
        $promo->recurrence = $request->recurrence;
        $promo->first_order = $request->first_order;
        $promo->list_id = $request->list_id;
        $promo->minimum_amount = $request->minimum_amount;
        $promo->target_type = $request->target_type;
        $promo->incentive_id = $request->incentive_id;
        $promo->save();

        if ($request->target_type == 1) {
            if ($request->customer_ids) {
                $promo->targets()->attach($request->customer_ids);
            }
        } elseif ($request->target_type == 2) {
            if ($request->customer_phones) {
                $filename = basename($request->customer_phones);

                Excel::load(Storage::path("public/uploads/{$filename}"), function ($reader) use ($promo) {
                    // Loop through all sheets
                    $results = $reader->all();
                    foreach ($results as $key => $record) {
                        $phone = (string)$record->phones;
                        $promo->target_lists()->create(["phone" => $phone]);
                    }
                });
            }
        }

        $promo->paymentMethods()->attach($request->payment_methods);
        $promo = Promo::with('paymentMethods')->findOrFail($promo->id);
        return $this->jsonResponse("Success", $promo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->jsonResponse("Success", Promo::with("targets", "target_lists", "paymentMethods")->findOrFail($id));
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
        $promo = Promo::with('paymentMethods')->findOrFail($id);

        // validate request
        $validator = Validator::make($request->all(), Promo::$validation + ["name" => ["required", Rule::unique("promos")->ignore($id)]]);

        if ($validator->fails()) {
            return $this->errorResponse("User Error Message", "Invalid data", $validator->errors(), 422);
        }

        $promo->type = $request->type;
        $promo->amount = $request->amount;
        $promo->max_amount = $request->type == 2 ? $request->max_amount * 100 : $request->max_amount;
        $promo->expiration_date = $request->expiration_date;
        $promo->description = $request->description;
        $promo->name = $request->name;
        $promo->recurrence = $request->recurrence;
        $promo->first_order = $request->first_order;
        $promo->minimum_amount = $request->minimum_amount;
        $promo->list_id = $request->list_id;
        $promo->target_type = $request->target_type;
        $promo->incentive_id = $request->incentive_id;
        $promo->save();

        if ($request->target_type == 1) {
            if ($request->customer_ids) {
                $promo->targets()->sync($request->customer_ids);
            }
        } elseif ($request->target_type == 2) {
            if ($request->customer_phones) {
                $promo->target_lists()->whereNotNull("phone")->delete();
                $filename = basename($request->customer_phones);
                Excel::load(Storage::path("public/uploads/{$filename}"), function ($reader) use ($promo) {
                    // Loop through all sheets
                    $results = $reader->all();
                    foreach ($results as $key => $record) {
                        $phone = (string)$record->phones;
                        $promo->target_lists()->create(["phone" => $phone]);
                    }
                });
            }
        } else {
            $promo->target_lists()->whereNotNull("phone")->delete();
        }
        $promo->paymentMethods()->sync($request->payment_methods);
        $promo->refresh();
        return $this->jsonResponse("Success", $promo);
    }

    public function activate($id)
    {
        $promo = Promo::findOrFail($id);

        $promo->active = 1;
        $promo->deactivation_notes = null;
        $promo->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $promo = Promo::findOrFail($id);

        $promo->active = 0;
        $promo->deactivation_notes = $request->deactivation_notes;
        $promo->save();

        return $this->jsonResponse("Success");
    }

    public function export()
    {
        return Excel::download(new PromosExport, 'Promos_' . date("Ymd") . '.xlsx');
    }
}
