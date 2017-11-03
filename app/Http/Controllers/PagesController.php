<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    public function index(){
         if(Auth::guest()){
            return view('pages.index');
        }else{
            return view('home');
        }
    }
}
