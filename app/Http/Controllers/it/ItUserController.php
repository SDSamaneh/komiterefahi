<?php

namespace App\Http\Controllers\it;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItUserController extends Controller
{
    public function index()
    {
   
        return view('it.index');
    }
}
