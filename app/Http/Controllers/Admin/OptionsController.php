<?php

namespace App\Http\Controllers\Admin;


use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Sheets\Export\Options\OptionsExport;
use App\Sheets\Import\Options\OptionsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class OptionsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->q) {
            $options = Option::where("name_en", "LIKE", "%{$request->q}%")
                ->orWhere("name_ar", "LIKE", "%{$request->q}%")
                ->orWhere("description_en", "LIKE", "%{$request->q}%")
                ->orWhere("description_ar", "LIKE", "%{$request->q}%")
                ->orWhere("id", $request->q)
                ->with('values')
                ->orderBy('created_at', 'DESC');
        }else{
            $options = Option::with('values')->orderBy('created_at', 'DESC');
        }
        $message = 'Success';
        if ($request->page == 0){
            $options = $options->get();
            return $this->jsonResponse($message, $options);
        }else{
            $options = $options->paginate(20);
            return $this->jsonResponse($message, ['options' =>$options->items() , 'total'=>$options->total()]);


        }


    }

    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), Option::$validation + []);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $data['active'] = 1;
        $data['created_by'] = \Auth::id();
        $option = Option::create($data);

        if ($request->values && is_array($request->values)) {
            foreach ($request->values as $value) {
                $data = [
                    'name_en' => $value['name_en'],
                    'name_ar' => $value['name_ar'],
                    'option_id' => $option->id,
                    'created_by' => \Auth::id()
                ];
                if ($option->type == 2 || $option->type == 4){
                    $data['color_code'] = $value['color_code'];
                }elseif($option->type == 3){
                    $data['image'] = $value['image'];
                }
                OptionValue::create($data);
            }
        }
        $option->push($option->values);
        return $this->jsonResponse("Success", $option);
    }

    public function show($id)
    {
        $options = Option::find($id);
        if ($options) {
            $options->push($options->values);
            $message = 'Success';
        } else {
            $options =[];
            $message = 'Not Found';
        }

        return $this->jsonResponse($message, $options);
    }

    public function update($id, Request $request)
    {
        $option = Option::find($id);
        if (!$option) {
            $message = 'This option Not Found';
            $option =[];
            return $this->jsonResponse($message, $option);
        }
        // validate request
        $validator = Validator::make($request->all(), Option::$validation + []);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $option->update($data);

        if ($request->values && is_array($request->values)) {
            foreach ($request->values as $value) {
                $data = [
                    'name_en' => $value['name_en'],
                    'name_ar' => $value['name_ar'],
                    'option_id' => $option->id,
                    'created_by' => \Auth::id()
                ];
                if ($option->type == 2 || $option->type == 4){
                    $data['color_code'] = $value['color_code'];
                }elseif($option->type == 3){
                    $data['image'] = $value['image'];
                }
                if (isset($value['id'])){
                    $optionValue =  OptionValue::find($value['id']);
                    $optionValue->update($data);
                }else{
                    OptionValue::create($data);
                }
            }
        }
        $option->push($option->values);
        return $this->jsonResponse("Success", $option);
    }

    public function activate($id)
    {
        $options = Option::find($id);
        if (!$options) {
            $message = 'This option Not Found';
            $options =[];
            return $this->jsonResponse($message, $options);
        }
        $data = ['active' => '1'];
        $options->update($data);
        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        $options = Option::find($id);
        if (!$options) {
            $message = 'This option Not Found';
            $options =[];
            return $this->jsonResponse($message, $options);
        }
        $data = ['active' => '0'];
        $options->update($data);
        return $this->jsonResponse("Success");
    }

    public function destroy($id)
    {
        $options = Option::find($id);
        if (!$options) {
            $message = 'This option Not Found';
            $options =[];
            return $this->jsonResponse($message, $options);
        }

        $options->delete();
        return $this->jsonResponse("Success");
    }

    public function export()
    {
        return Excel::download(new OptionsExport(), 'options_' . date("Ymd") . '.xlsx');
    }

    public function import(Request $request)
    {
        $this->validate($request, ["file" => "required"]);
        try {
            $file = $request->file('file');
            $fileName = "Options_" . date("Y_m_d H_i_s") . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/options', $fileName);
            Excel::import(new OptionsImport, $path);
        } catch (\Exception $e) {
            Log::error("Import File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
        return $this->jsonResponse("Success");
    }


}
