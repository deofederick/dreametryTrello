<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BoardsController extends Controller
{
    public function setboards(Request $request){
    	$b = Input::get('data2');
    	$boards = $request->get('data');
    	$decoded = json_decode($request->get('data'));
    	$sample = Input::get('sample');
    	\Log::info($boards);
    	\Log::info($decoded);
    	\Log::info($sample);
    	\Log::info($b);

    	return response()->json($request->data);

    	if(isset($_POST['body'])){
  //Do something
		  echo "The type you posted is ".$_POST['body'];
		}
		else{
			echo "none";
		}
    }
}
