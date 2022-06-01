<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            'created_at',
            'updated_at',
        ];

        $pages = Page::select($coloumns)->orderBy('order')->get();

        return $this->jsonResponse('success', $pages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'slug'       => 'required|unique:pages',
            'title_en'   => 'required',
            'title_ar'   => 'required',
            'content_en' => 'required',
            'content_ar' => 'required',
            'in_footer'  => 'required|boolean',
            'order'      => 'required|integer',
        ]);

        $page = Page::create($request->all());

        return $this->jsonResponse('success', $page);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Pages\Page $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return $this->jsonResponse('success', $page);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pages\Page $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'slug'      => 'unique:pages,slug,' . $page->id,
            'in_footer' => 'boolean',
            'active'    => 'boolean',
            'order'     => 'integer',
        ]);

        $page->update($request->all());

        return $this->jsonResponse('success', $page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Pages\Page $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if (!$page->deletable) {
            return $this->errorResponse('Page can not be deleted', null);
        }

        $page->delete();

        return $this->jsonResponse('success');
    }
}
