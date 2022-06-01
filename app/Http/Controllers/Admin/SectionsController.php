<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Arr;

use App\Models\Home\Section;
use Illuminate\Http\Request;
use App\Models\Products\Lists;
use App\Models\Home\SectionImage;
use App\Models\Products\ListItems;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Admin\SectionResource;


class SectionsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::with('list', 'images')->get();

        return $this->jsonResponse("Success", SectionResource::collection($sections));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), Section::$validation);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $request->only(['name_en', 'name_ar', 'description_en', 'description_ar', 'order', 'image_type', 'list_id', 'type']);
        $data['active'] = 1;
        DB::beginTransaction();

        $section = Section::create($data);
        $section->images()->createMany($request->input('images'));

        DB::commit();
        $section->load('list', 'images');

        Cache::forget('sections');
        return $this->jsonResponse("Success", new SectionResource($section));
    }


    public function update(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), Section::$validation);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $section = Section::findOrFail($id);

        DB::beginTransaction();

        $data = $request->only(['name_en', 'name_ar', 'description_en', 'description_ar', 'order', 'image_type', 'list_id', 'type']);
        $data['active'] = 1;
        $section->update($data);

        switch ($request->get('image_type')) {
            case Section::IMAGE_TYPE_NO_IMAGE:
                $section->images()->delete();
                break;
            case Section::IMAGE_TYPE_SINGLE:
            case Section::IMAGE_TYPE_MULTIPLE:
            case Section::IMAGE_TYPE_WIDE:
                $imagesIds = array_filter(array_column($request->input('images'), 'id'));
                SectionImage::where('section_id', $section->id)->whereNotIn('id', $imagesIds)->delete();
                break;
        }

        foreach ($request->get('images') as $key => $image) {
            //Accept 5 images per section only
            if ($key > 4) {
                continue;
            }
            if ($image['id'] == null || $image['id'] == 0) {
                $section->images()->create([
                    'image_ar' => $image['image_ar'],
                    'image_en' => $image['image_en'],
                    'link_en' => $image['link_en']
                ]);
            } else {
                SectionImage::updateOrCreate([
                    'section_id' => $section->id,
                    'id' => $image['id']
                ], [
                    'section_id' => $section->id,
                    'image_ar' => $image['image_ar'],
                    'image_en' => $image['image_en'],
                    'link_en' => $image['link_en']
                ]);
            }
        }

        DB::commit();

        $section->load('list', 'images');
        Cache::forget('sections');
        return $this->jsonResponse("Success", new SectionResource($section));
    }

    public function activate($id)
    {
        $section = Section::find($id);
        if (!$section) {
            $message = 'This section Not Found';
            return $this->jsonResponse($message, $section);
        }
        $data = ['active' => '1'];
        $section->update($data);
        Cache::forget('sections');
        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        $section = Section::find($id);
        if (!$section) {
            $message = 'This section Not Found';
            return $this->jsonResponse($message, $section);
        }
        $data = ['active' => '0'];
        $section->update($data);
        Cache::forget('sections');
        return $this->jsonResponse("Success");
    }

    /**
     * Delete section
     *
     * @param  Section $section
     * @return void
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return $this->jsonResponse("Success");
    }
}
