<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationManagerController extends Controller
{

    public function index(Request $request)
    {
        $configs = Configuration::editable()->get();
        return $this->jsonResponse("Success", $configs);
    }


    public function update(Request $request)
    {
        $request->validate([
            'configs'         => 'required|array',
            'configs.*.id'    => 'required|exists:configurations,id',
            'configs.*.value' => '',
        ]);

        foreach ($request->configs as $config) {
            $configObject = Configuration::find($config['id']);

            if (!$configObject->editable) {
                abort(422, "object of id {$configObject->id} is non editable");
            }

            $configObject->update(['value' => $config['value']]);
        }

        $configs = Configuration::get();

        return $this->jsonResponse("Success", $configs);
    }

}
