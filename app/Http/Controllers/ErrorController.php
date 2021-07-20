<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Theme\Theme;

class ErrorController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code, $message)
    {
        return Theme::view('error.error', [
            'code' => $code,
            'message' => $message
        ]);
    }
}
