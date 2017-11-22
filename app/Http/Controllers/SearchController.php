<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function search(){
    	$trelloId = Input::get('user');
    	\Log::info($trelloId);

    	

    }
}
