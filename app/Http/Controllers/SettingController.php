<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Setting;

class SettingController extends Controller
{
    public function index(){
        return view('settings');
    }

    public function save(Request $request){
        Setting::set('mode',$request->mode);
        Setting::set('msgFaceToFace',$request->faceToFace);
        Setting::set('msgVideoCall',$request->videoCall);
        Setting::set('ip',$request->ip);
        Setting::save();
        alert()->success('Se guardó la configuración correctamente','Configuración');
        return redirect()->route('settings');
    }
}
