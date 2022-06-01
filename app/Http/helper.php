<?php 

if (! function_exists('getBranches')) {
    /**
     * List types of branches
     *
     * @return array
     */
    function getBranchTypes() 
    {
        $types = \App\Models\Configuration::getValueByKey('BRANCH_TYPES');
        $branchs = explode(',', $types);

        $arr = [];
        foreach ($branchs as $branch) {
            $key = \Illuminate\Support\Str::before($branch, '=>');
            $detials = \Illuminate\Support\Str::after($branch, '=>');

            $arr[$key] = explode('|', $detials);
        }
        return $arr;
    }
}

if (! function_exists('getRealIp')) {
     function getRealIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
                     'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip();
//        return app()->environment('local') ? request()->ip() : null;
        // return request()->ip(); // it will return server ip when no client ip found
    }
}
if (!function_exists('getDevice')) {
    /**
     * Detect request device
     *
     * @return boolean
     */
    function getDevice()
    {
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $Android = preg_match(
            "/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|pie|up\.browser|up\.link|webos|wos)/i",
            $_SERVER["HTTP_USER_AGENT"]
        );

        if ($Android){
            $agent = 'android';
        }else if ($iPod || $iPhone || $iPad){
            $agent = 'ios';
        }else{
            $agent = 'web';
        }
        return $agent;
    }
}
if (! function_exists('humanFileSize')) {
    function humanFileSize($size, $unit = null) {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)."GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)."MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)."KB";
        return number_format($size)." Bytes";
    }
}

