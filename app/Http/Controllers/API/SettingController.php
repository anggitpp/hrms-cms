<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting\Master;

class SettingController extends Controller
{
    public function masters($category)
    {
        $masters = Master::where('category', $category)->orderBy('order', 'asc')->get();

        if($masters) {
            return response()->json([
                "data" => $masters,
                "message" => "success",
            ], 200);
        }else{
            return response()->json([
                'message' => "something went wrong",
            ], 500);
        }
    }
}
