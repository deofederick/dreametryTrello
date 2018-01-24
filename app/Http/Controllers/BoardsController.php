<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\User;
use App\Card;
use App\Board;
use App\boardList;
use App\Status;
use App\Actions;
use App\Roles;
use Carbon\Carbon;
use App\Authentications;
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
     public function setcards(){
        $sample = Input::get('sample');
        $array = [];
        $pendings = Input::get('username');
        $pendings2 = Input::get('pendings');

        array_push($array, $pendings);
        
        \Log::info($pendings);
         foreach ((array)$sample as $key => $value) { 
               if($ucard = Card::where('card_id','=', $value['cardid'])->where('user_id', '=', $value['userid'])->exists()){
                   //\Log::info('existing'.'-'.$value['cardid']);
                }
                else{
                    $c = new Card;
                    $c->card_id = $value['cardid'];
                    $c->card_name = $value['cardname'];
                    $c->date_finished = Carbon::parse($value['date_finished']);
                    $c->user_id = $value['userid'];
                    $c->list_id = $value['listid'];
                    $c->status = $value['status'];
                    $c->date_started = Carbon::now();
                    $c->url = $value['url'];
                    $c->save();
                   //\Log::info('saved'.'-'.$value['cardid']);
                }
  
        }

     }

    public function getuser(){
        $users = User::all();
        $done = Status::where('status_name','=','Done')->pluck('id');
        $review = Status::where('status_name','=','For Review')->pluck('id');
        $todo = Status::where('status_name', '=','To Do')->pluck('id');
        
        $done_list = boardList::where('status_id','=',$done)->get();
        $review_list = boardList::where('status_id','=',$review)->get();
        $todo_list = boardList::where('status_id','=',$todo)->get();
        $pendingTasks = BoardList::where('status_id', 1)->orWhere('status_id', 2)->get();

        $boards = Board::all();
        
        $data = array(
            'users' => $users,
            'pendings' => $pendingTasks,
            'done' => $done_list,
            'boards' => $boards
        );

        return $data;
    }

    public function getcards(){

        if(Auth::guest()){
            return view('pages.index');
        }else{

        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;

        $done = Status::where('status_name','=','Done')->pluck('id');
        $review = Status::where('status_name','=','For Review')->pluck('id');
        $todo = Status::where('status_name', '=','To Do')->pluck('id');
        
        $done_list = boardList::where('status_id','=',$done)->get();
        $review_list = boardList::where('status_id','=',$review)->get();
        $todo_list = boardList::where('status_id','=',$todo)->get();
        $users = User::all();

      

        $allcards = Card::all();
        $finished =[];

        $allpending = [];
        $sample = [];

        $pendingTasks = BoardList::where('status_id', 1)->orWhere('status_id', 2)->get();
    

    foreach ($users as $user){
                $usercount = 0;
                foreach($pendingTasks as $pendingtask){
                    $cards_url = 'https://api.trello.com/1/lists/'.$pendingtask->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                foreach ((array)$cards as $card) {
                    if(isset($card['idMembers'])){
                        if(is_array($card['idMembers'])){    
                        foreach ($card['idMembers'] as $member){
                        $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                        $actionresponse = Curl::to($action_url)->get();
                        $actions = json_decode($actionresponse, TRUE);
                            if ($user['trelloId'] == $member) {
                                 if($pendingtask->status_id == 1){
                                    foreach ((array)$actions as $action) {
                                        if(isset($action['type'])){
                                        if($action['type']=='commentCard'){
                                        if(is_array($action) && $action['type']=='commentCard'){
                                            if(strpos( $action['data']['text'], "Working on" ) !== false && $action['memberCreator']['id'] == $member){
                                            \Log::info($card['id'].'-'.$card['name'].'1');
                                            $usercount++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                                    else if($pendingtask->status_id == 2){
                                        \Log::info($card['id'].'-'.$card['name'].'2');
                                        $usercount++;    
                                    }
                                }   
                            }
                        }
                    }
                    else{

                    }
                }            
            }                 
                $allpending[] = array(
                        'name' => $user['name'],
                        'count' => $usercount
                    );  
            }

         $daily = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("users.name"), DB::raw('SUM(CASE WHEN cards.date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(cards.date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(cards.date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->groupBy(DB::raw("user_id, users.name"))->get();
        $allcount = DB::table("cards")->select(DB::raw('SUM(CASE WHEN date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->get();
    

    $alldata =array(                                            
        'daily' => $daily,                     
        'allcount' => $allcount,
        'allpending' => $allpending
        );       
                                        
    return $alldata;
    }
}
}
