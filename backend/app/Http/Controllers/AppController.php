<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function load(Request $request)
    {
        $data['dev'] = env('APP_DEBUG') == true;
        $data['settings'] = (object) [];
        $data['user'] = false;
        return $data;
    }
}
