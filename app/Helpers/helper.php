<?php

use App\Models\User;
use App\Models\Translate;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Roles & Permissions
function hasPermissions($permission){
    $getPermission = Permission::where('name',$permission)->limit(1)->count();
    if ($getPermission > 0) {
        if(!Auth::user()->hasPermissionTo($permission))
            abort(403);
    }else{
        abort(404);
    }
}

function hasPermissionsStatistics($permission){
    $getPermission = Permission::where('name',$permission)->limit(1)->count();
    if ($getPermission > 0) {
        if(!Auth::user()->hasPermissionTo($permission))
            return 'hasnot';
    }else{
        return 'notfound';
    }
}

function getUserRole($userId){
    $user = User::findOrfail($userId);
    $roles = [];
    foreach ($user->getRoleNames() as $role) {
        array_push($roles,$role);
    }
    return $roles;
}

function transWord($word){
    $lang = LaravelLocalization::getCurrentLocale();
    if(Translate::where('word',$word)->where('key',$lang)->count() > 0){
        $transData = Translate::where('word',$word)->where('key',$lang)->get()->first();
        return $transData->translation;
    }else{
        return $word;
    }
    return $word;
}


function breadcrumbWidget($currentPageName,$pages){
    $breadcrumb = '';
    // if (count($pages) == 0) {
        // $breadcrumb .= '
        // <nav class="page-breadcrumb">
        //     <ol class="breadcrumb">';
        //     $breadcrumb .= '<li class="breadcrumb-item"><a href="./home">'.transWord('Home').'</a></li></ol></nav>';
           
    // }else{
        $breadcrumb .= '
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">';
            $breadcrumb .= '<li class="breadcrumb-item"><a href="./home">'.transWord('Home').'</a></li>';

            for ($i=0; $i < count($pages); $i++) {
                if ($pages[$i][1] == '' || $pages[$i][1] == '#') {
                    $breadcrumb .= '<li class="breadcrumb-item"><a href="'.$pages[$i][1].'" >'.$pages[$i][0].'</a></li>';
                }else if(is_array($pages[$i][1])){
                    $breadcrumb .= '<li class="breadcrumb-item"><a href="'.route($pages[$i][1]).'" >'.$pages[$i][0].'</a></li>';
                }else{
                    $breadcrumb .= '<li class="breadcrumb-item"><a href="'.route($pages[$i][1]).'" >'.$pages[$i][0].'</a></li>';
                }
            }
            $breadcrumb .= '</ol>
        </nav>
        ';
    // }
    return $breadcrumb;
}

// store Image
function base64($base64image,$path,$name="")
{
    $base64_str = substr($base64image, strpos($base64image, ",")+1);
    $image = base64_decode($base64_str);
    $type = explode(';', $base64image)[0];
    $type = explode('/', $type)[1]; // png or jpg etc
    if ($type == 'svg+xml') {
        $type='svg';
    }
    $time =$name.time().uniqid();
    $imageName    = $time.'.'.$type;
    Storage::disk('public')->put($path.$imageName, $image);
    return $imageName;
}

function uploadsStoreAs($image,$path,$name="")
{
    $originalName = uniqid().$image->getClientOriginalName();
    $image->storeAs($path,$originalName,"public");
    return $originalName;
}

function makeSlug($string)
{
    $string = mb_strtolower($string, "UTF-8");
    $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);
    $string = preg_replace("/[\s-]+/", " ", $string);
    $string = preg_replace("/[\s_]/", '-', $string);
    return $string;
}

function convertCurrency($from_currency="KWD",$to_currency="USD",$amount=1){

    $req_url = 'https://api.exchangerate.host/latest?base='.$from_currency.'&amount='.$amount.'&symbols='.$to_currency;

    $response_json = file_get_contents($req_url);

    $hasConversion = false;
    $converted_amount = 0;
    if(false !== $response_json) {
        try {
            $response = json_decode($response_json);

            if($response->success === true) {

                 // Read conversion rate
                 $converted_amount = round($response->rates->$to_currency,2);

                 $hasConversion = true;
            }

        } catch(Exception $e) {
            // Handle JSON parse error...

        }
    }

    // $return_arr = array(
    //     "success" => $hasConversion,
    //     "amount" => $amount,
    //     "converted_amount" => $converted_amount
    // );

    return $converted_amount;
}

function youtubeIframe($code)
{
    return '<iframe width="560" height="315" 
            src="https://www.youtube.com/embed/'.$code.'" title="YouTube video player" 
            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; 
            picture-in-picture; web-share" allowfullscreen></iframe>';
}

function normalizeArabicString($strToNormalize) {
    $strToReplace = preg_replace("/[آأإ]/u", "ا", $strToNormalize);
    $strToReplace = preg_replace("/[ى]/u", "ي", $strToReplace);
    $strToReplace = preg_replace("/[ة]/u", "ه", $strToReplace);

    return $strToReplace;
}

function DBImagesFullURL($imageFolder) {
    return url('') . '/uploads/' . $imageFolder . '/';
}
