<?php


namespace App\Services\Cache;


use Illuminate\Support\Facades\Cache;

class CacheService
{
    public static function checkStatus($key, $id, $status): bool{
        $caches = Cache::get($key);
        if ($caches){
            foreach($caches as $cache){
                if ($cache['id'] == $id && $cache['status'] == $status){
                    return true;
                }
            }
        }
        return false;
    }

    public static function addNewFileStatus($key, $status, $id){
        $caches[] = ['id' => $id, 'status' => $status];
        if (Cache::has($key) && !in_array($id ,array_unique(array_column(Cache::get('export'), 'id')))){
            $caches = Cache::get($key);
            $caches[] = ['id' => $id, 'status' => $status];
        }
        Cache::forever('export', $caches);
    }
}