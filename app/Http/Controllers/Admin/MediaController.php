<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $dirs = Storage::directories($request->get('parentPath'));
        $files = Storage::files($request->get('parentPath'));
        $folderContents = array_merge($dirs, $files);
        return $this->mapFiles($folderContents);
    }

    public function download(Request $request)
    {
        $request->validate(['path' => 'required']);
        $isDirectory = File::isDirectory(Storage::path($request->get('path')));
        if($isDirectory) {
            abort(404);
        }
        return Storage::download($request->get('path'));
    }

    public function makeDirectory(Request $request)
    {
        $request->validate([
            'dirName' => 'required',
        ]);
        $directory = $request->get('parentPath') .'/'. $request->get('dirName');
        Storage::makeDirectory($directory);
        return $this->jsonResponse('success');
    }

    public function remove(Request $request)
    {
        $request->validate(['path' => 'required']);
        Storage::delete($request->get('path'));
        Storage::deleteDirectory($request->get('path'));
        return $this->jsonResponse('success');
    }

    public function rename(Request $request)
    {
        $request->validate([
            'path'    => 'required',
            'newName' => 'required',
        ]);
        if(! Storage::exists($request->get('path'))) {
            abort(404);
        }
        Storage::move($request->get('path'), $request->get('newName'));
        return $this->jsonResponse('success');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $results = [];
        $dirs = Storage::allDirectories('');
        $files = Storage::allFiles('');
        $storageContents = array_merge($dirs, $files);
        foreach ($storageContents as $item) {
            if(preg_match("/$query/i", basename($item))) {
                $results[] = $item;
            }
        }
        return $this->mapFiles($results);
    }

    private function mapFiles(array $files)
    {
        $filesMap = [];
        foreach ($files as $file) {
            $item['name'] = $file;
            $item['full_path'] = Storage::path($file);
            $item['path'] = substr(Storage::url($file), 9);
            $item['dir'] = File::isDirectory($item['full_path']);
            $item['url'] = $item['dir'] ? null : route('admin.media-library.download', ['path' => $item['path']]);
            $item['id'] = $item['path'];
            $item['size'] = $item['dir'] ? '-' : humanFileSize(Storage::size($file));
            $filesMap[] = $item;
        }
        return $filesMap;
    }
}
