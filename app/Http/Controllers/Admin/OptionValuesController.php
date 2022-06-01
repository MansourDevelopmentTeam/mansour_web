<?php

namespace App\Http\Controllers\Admin;


use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
class OptionValuesController extends Controller
{

    public function index($optionID)
    {
        $option = Option::find($optionID);
        if (!$option){
            $message = 'This option is Not Found';
            return $this->jsonResponse($message, $option);
        }
        $values = OptionValue::where('option_id',$optionID)->paginate();
      if (count($values) > 0){
          $message = 'Success';
      }else{
          $values = null;
          $message = 'there is no values Yet';
      }
        return $this->jsonResponse($message, $values);
    }

    public function store(Request $request,$optionID)
    {
        $option = Option::find($optionID);
        if (!$option){
            $message = 'This option is Not Found';
            return $this->jsonResponse($message, $option);
        }
        // validate request
        $validator = Validator::make($request->all(), OptionValue::$validation + []);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $data['option_id'] = $optionID;
        $data['created_by'] = \Auth::id();
        $value = OptionValue::create($data);
        return $this->jsonResponse("Success", $value);
    }

    public function show($optionID,$valueID)
    {
        $option = Option::find($optionID);
        if (!$option){
            $message = 'This option is Not Found';
            return $this->jsonResponse($message, $option);
        }
        $value = OptionValue::where('id',$valueID)->where('option_id',$optionID)->first();
        if ($value){
            $message = 'Success';
        }else{
            $message = 'Not Found';
        }
        return $this->jsonResponse($message, $value);
    }

    public function update(Request $request,$optionID,$valueID)
    {
        $option = Option::find($optionID);
        if (!$option){
            $message = 'This option is Not Found';
            return $this->jsonResponse($message, $option);
        }

        $value = OptionValue::where('id',$valueID)->where('option_id',$optionID)->first();
        if (!$value){
            $message = 'This value Not Found';
            return $this->jsonResponse($message, $value);
        }

        // validate request
        $validator = Validator::make($request->all(), OptionValue::$validation + []);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->valid();
        $value->update($data);

        return $this->jsonResponse("Success", $value);
    }

    public function activate($optionID,$valueID)
    {
        $value = OptionValue::where('id',$valueID)->where('option_id',$optionID)->first();
        if (!$value){
            $message = 'This Value Not Found';
            return $this->jsonResponse($message, $value);
        }
        $data = ['active'=>'1'];
        $value->update($data);
        return $this->jsonResponse("Success");
    }

    public function deactivate($optionID,$valueID)
    {
        $value = OptionValue::where('id',$valueID)->where('option_id',$optionID)->first();
        if (!$value){
            $message = 'This Value Not Found';
            return $this->jsonResponse($message, $value);
        }
        $data = ['active'=>'0'];
        $value->update($data);
        return $this->jsonResponse("Success");
    }

    public function destroy($optionID,$valueID)
    {
        $value = OptionValue::where('id',$valueID)->where('option_id',$optionID)->first();

        if (!$value){
            $message = 'This Value Not Found';
            return $this->jsonResponse($message, $value);
        }
        $value->delete();
        return $this->jsonResponse("Success");
    }
}
