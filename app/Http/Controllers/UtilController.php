<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{
    static public function generateV4()
    {
        list($fMSec, $fSec) = explode(' ', microtime());

        return sprintf('%04x%04x-%04x-%04x-%04x-%08x%04x',
            mt_rand(0, 0xffff), mt_rand( 0, 0xffff ),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            (int) $fSec, (int)1000*$fMSec
        );
    }
}
