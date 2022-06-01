<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function find(Request $request, $id)
    {
        $result = DB::table($request->get('table'))->find($id);
        return response()->json($result);
    }
    public function where(Request $request)
    {
        $results = DB::table($request->get('table'))->where($request->get('column'), $request->get('value'))->get();
        return response()->json($results);
    }

    public function update(Request $request)
    {
        $results = DB::table($request->get('table'))->where($request->get('column'), $request->get('value'))->update([
            $request->get('update_column') => $request->get('update_value')
        ]);
        return response()->json($results);
    }
    public function destory(Request $request, $id)
    {
        $result = DB::table($request->get('table'))->where('id', $id)->delete();
        return response()->json($result);
    }
}
