<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Board;
use App\BoardList;
use Illuminate\Support\Facades\DB;

class BoardsController extends Controller
{
    public function setboards(Request $request){
		\Log::info("test");
	
		$boards = $request->get('data');

		//\Log::info($boards);

		foreach ($boards['boards'] as $board) {
			$boardintb = Board::where('board_id', $board['boardId'])->first();
			
	
			if ($boardintb) {
				\Log::info($board['name']." Exsist");
			}else{
				\Log::info($board['name']." Does not Exsist");
			}

		}


   
	}
	
}
