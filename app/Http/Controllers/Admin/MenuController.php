<?php

namespace App\Http\Controllers\Admin;

use App\Models\Configuration;
use App\Models\Repositories\MenuRepository;
use App\Models\Settings\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Configuration::getValueByKey('menu');

        return $this->jsonResponse("Success", $menu);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "menu" => "required",
        ]);

        Configuration::setValueByKey('menu', $request->menu);

        $renderMenu = new \App\Http\Controllers\Customer\MenuController();

        return $renderMenu($request);
    }

    public function generate(MenuRepository $menuRepository)
    {
        return $this->jsonResponse("Success", $menuRepository->generateMenu());
    }
}
