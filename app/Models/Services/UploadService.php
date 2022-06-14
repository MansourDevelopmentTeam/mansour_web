<?php

namespace App\Models\Services;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class UploadService
{

    private $_allowedImage = ['image/jpeg', 'image/png', 'image/gif', "image/jpg", "image/webp", "image/pjpeg"];
    private $_allowedFiles = ['text/csv','application/vnd.ms-excel'
        ,'application/pdf', 'application/msword','text/plain',
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/zip"];

    private function uploadFile($file, $originalName = false, $path = '')
    {
        $fileName = $this->generateName($file, $originalName);
        if ($this->isAllowedFile($file->getMimeType())) {
            $path = $path ? '/' . $path : '';
            $filePath = Storage::disk('public')->putFileAs("uploads" . $path, $file, $fileName);
            if (in_array($file->getMimeType(), $this->_allowedImage)) {
                $thumpPath = Storage::disk('public')->putFileAs('uploads/thumbnails', $file, $fileName);
                $img = $this->makeResize($file);
                Storage::disk('public')->put($thumpPath, $img);
                return ["filePath" => Storage::url($filePath), "thumbnail" => Storage::url($thumpPath), "name" => Storage::url($filePath)];
            }
            return ["filePath" => Storage::url($filePath), "name" => public_path("storage/" . $filePath)];
        }
        throw new \Exception(trans('mobile.file_type_not_allowed'));
    }

    public function uploadWithCustomPath(Request $request, $path)
    {
        return $this->uploadFile($request->file, false, $path);
    }

    public function upload(Request $request)
    {
        $request->validate([ "file" => "required" ]);
        return $this->uploadFile($request->file);
    }

    public function uploadFiles(Request $request)
    {
        $request->validate([ "files" => "required" ]);

        $files = [];
        foreach ($request->files->get("files") as $file) {
            $files[] = $this->uploadFile($file, true)['filePath'];
        }
        return $files;
    }

    public function getImageThumbnailLink($imageLink)
    {
        $imgArr = explode('/', $imageLink);
        $last = end($imgArr);
        array_pop($imgArr);
        $imgArr[] = 'thumbnails';
        $imgArr[] = $last;
        if (Storage::disk('public')->exists("uploads/thumbnails/{$last}")) {
            return implode('/', $imgArr);
        }
        return null;
    }

    public function getUploads(Request $request)
    {
        $request->validate([ "page" => "required|int" ]);

        $fullDirName = "public/uploads";
        $files = collect(File::allFiles(Storage::path($fullDirName)))->sortByDesc(function ($file) {
            return $file->getCTime();
        })->toArray();

        $files = array_map(function ($item) use ($fullDirName) {
            return [
                "name" => $item->getFileName(),
                "url" => Url::to('') . Storage::url('public/uploads/' . $item->getFileName())
            ];
        }, $files);
        array_shift($files);
        return array_slice($files, (($request->page - 1) * 8), 8);
    }

    private function makeResize($file)
    {
        return Image::make($file)
            ->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream();
    }

    private function generateName($file, $originalName)
    {
        $filenameWithoutExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // $random = Str::random(6);
        if ($originalName) {
            $fileName = preg_replace("/\s/", "-", $file->getClientOriginalName());
        } else {
            $fileName = $filenameWithoutExt . "-" . time() . "." . $file->getClientOriginalExtension();
        }
        return $fileName;
    }

    private function isAllowedFile($type)
    {
        if (in_array($type, array_merge($this->_allowedImage, $this->_allowedFiles))) {
            return true;
        }
        return true;
    }
}
