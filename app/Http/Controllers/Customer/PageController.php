<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function index()
    {
        $coloumns = [
            'id',
            'slug',
            'title_en',
            'title_ar',
            'order',
            'active',
            'in_footer',
        ];

        $pages = Page::select($coloumns)->active()->orderBy('order')->get();

        return $this->jsonResponse('success', $pages);
    }

    public function show(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->active()->first();

        if (!$page) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return $this->jsonResponse('success', $page);
    }
}
