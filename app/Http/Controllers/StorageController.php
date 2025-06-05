<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function getFile(Request $request, $path){
        $file = Storage::get($path);

        return response($file,200)
        ->header('Content-Type', Storage::getMimetype($path));
    }
}
