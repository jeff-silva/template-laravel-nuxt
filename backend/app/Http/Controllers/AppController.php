<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AppController extends Controller
{

    #[\Spatie\RouteAttributes\Attributes\Get('/api/app/load', name: 'app.load')]
    public function load(Request $request)
    {
        $data['dev'] = env('APP_DEBUG') == true;
        $data['datetime'] = date('Y-m-d H:i:s');
        $data['settings'] = (object) [];
        $data['user'] = auth()->user();
        return $data;
    }

    // #[\Spatie\RouteAttributes\Attributes\Get('/app/stream', name: 'app.stream')]
    // public function stream()
    // {
    //     $sendData = function($event, $data = []) {
    //         return "event: {$event}\ndata: ". json_encode($data) ."\n\n";
    //     };

    //     return response()->stream(
    //         function() use($sendData) {
    //             for($i=rand(5, 20); $i>=0; $i--) {
    //                 echo $sendData('progress', [ 'value' => $i ]);
    //                 ob_flush(); flush(); sleep(1);
    //             }

    //             echo $sendData('end');
    //         },
    //         200,
    //         [
    //             'Cache-Control' => 'no-cache',
    //             'Content-Type' => 'text/event-stream',
    //         ]
    //     );
    // }
}
