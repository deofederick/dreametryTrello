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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use File;
use View;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller;


class CardsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        $startweek = self::getDay('Monday')->format('Y-m-d');
        $endweek = self::getDay('Friday')->format('Y-m-d');

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

    //get all cards -need to uncomment
        foreach ($users as $user) {
            foreach ($done_list as $done) {
                    $cards_url = 'https://api.trello.com/1/lists/'.$done->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                    foreach ((array)$cards as $card) {
                     if(isset($card['idMembers'])){
                        if(is_array($card['idMembers'])){
                        foreach ((array)$card['idMembers'] as $member) {
                            $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                            $actionresponse = Curl::to($action_url)->get();
                            $actions = json_decode($actionresponse, TRUE);
                            foreach ((array)$actions as $action) {
                                if(is_array($action) && $user->trelloId==$member){
                                    if($action['type']=='updateCard'){ 
                                            $sample[] = array(
                                                'cardid' => $card['id'],
                                                'cardname' => $card['name'],
                                                'listid' => $card['idList'],
                                                'userid' => $member,
                                                'date_finished' => $action['date'],
                                                'status' => 'Done',
                                                'url' => $card['url'],
                                            );
                                    }
                                }           
                            }
                        }
                    }
                }
            }      
        }
    }
         foreach ($sample as $key => $value) { 
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


        $daily = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("users.name"), DB::raw('SUM(CASE WHEN cards.date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(cards.date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(cards.date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->groupBy(DB::raw("user_id, users.name"))->get();
        $allcount = DB::table("cards")->select(DB::raw('SUM(CASE WHEN date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->get();
    

    $alldata =array(                                            
        'daily' => $daily,                     
        'allcount' =>$allcount,
        'pending' => $allpending    
        );       
                                        
    return $alldata;
    }



//saving
        
//weekly
      /*foreach ($users as $user) {
            foreach ($done_list as $done) {
                foreach ($review_list as $review) {
                    $cards_url = 'https://api.trello.com/1/lists/'.$done->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                    foreach ((array)$cards as $card) {
                        foreach ($card['idMembers'] as $member) {
                            $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                            $actionresponse = Curl::to($action_url)->get();
                            $actions = json_decode($actionresponse, TRUE);
                            foreach ((array)$actions as $action) {
                                if($user->trelloId==$member){
                                    if($action['type']== 'updateCard'){
                                        $startweek = self::getDay('Monday')->format('Y-m-d');
                                        $endweek = self::getDay('Friday')->format('Y-m-d');
                                        if($action['data']['listBefore']['id'] == $review->list_id && $action['data']['listAfter']['id'] == $done->list_id && $action['date'] >= $startweek && $action['date'] <= $endweek){
                                            \Log::info($member.'-'.$action['date']);
                                            array_push($weekly, $user->name); 
                                        }
                                    }
                                }           
                            }
                        }
                    }
                }       
            }
        }*/

//monthly
        /*foreach ($users as $user) {
            foreach ($done_list as $done) {
                foreach ($review_list as $review) {
                    $cards_url = 'https://api.trello.com/1/lists/'.$done->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                    foreach ((array)$cards as $card) {
                        foreach ($card['idMembers'] as $member) {
                            $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                            $actionresponse = Curl::to($action_url)->get();
                            $actions = json_decode($actionresponse, TRUE);
                            foreach ((array)$actions as $action) {
                                if($user->trelloId==$member){
                                    if($action['type']== 'updateCard'){
                                        $startweek = self::getDay('Monday')->format('Y-m-d');
                                        $endweek = self::getDay('Friday')->format('Y-m-d');
                                        if($action['data']['listBefore']['id'] == $review->list_id && $action['data']['listAfter']['id'] == $done->list_id && Carbon::parse($action['date'])->month == Carbon::now()->month){
                                            \Log::info($member.'-'.$action['date']);
                                            array_push($monthly, $user->name); 
                                        }
                                    }
                                }           
                            }
                        }
                    }
                }       
            }
        }*/

//Ongoing tasks -need to uncomment
  /*  foreach ($users as $user) {
        foreach ($todo_list as $todo) {
            $cards_url = 'https://api.trello.com/1/lists/'.$todo->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);
            foreach ((array)$cards as $card) {
                if(is_array($card)){
                foreach ((array)$card['idMembers'] as $member) {
                    $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                    $actionresponse = Curl::to($action_url)->get();
                    $actions = json_decode($actionresponse, TRUE);
                    foreach ((array)$actions as $action) {
                        if($user->trelloId == $member){
                            if($action['type']=='commentCard'){
                                if(strpos( $action['data']['text'], "Working on" ) !== false && $action['memberCreator']['id'] == $member){
                                    array_push($pending, $user->name);
                                    \Log::info($card['name']);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
 }
    }*/
/* 
    foreach ($users as $user) {
        foreach ($pending_list as $pend) {
            $cards_url = 'https://api.trello.com/1/lists/'.$pend->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);
            foreach ((array)$cards as $card) {
                if(is_array($card)){
                foreach ((array)$card['idMembers'] as $member) {
                    if($user->trelloId == $member){
                        \Log::info($card['name'].' - '.$user->name);
                            array_push($pending, $user->name);
                        
                        }
                    }
                }
            }
        }
    }
 */
    /*foreach ($users as $user) {
        foreach ($review_list as $review) {
            $cards_url = 'https://api.trello.com/1/lists/'.$review->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);
            foreach ((array)$cards as $card) {
                if(is_array($card)){
                foreach ((array)$card['idMembers'] as $member) {
                    if($user->trelloId == $member){
                        \Log::info($card['name']);
                            array_push($pending, $user->name);
                        
                    }
                }
            }
        }
    }
}
    }*/
    //revisio        
        //$monthlys = array(array_count_values($monthly));
     //   $pendings = array(array_count_values($pending));
     //   $test=array(array_count_values($finished));
      //  \Log::info($pendings);

 
       
    }

        //return view('trello.counter')->with('alldata',$alldata);
        /*return view('trello.c`    ounter')->with('finished',$daily)->with('pendings', $pendings)->with('weeklys', $weekly)->with('monthlys',$monthly);

        return $pending;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function revisions(){

//all members
         if(Auth::guest()){
            return view('pages.index');
        }else{
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        $idUser = auth()->user()->trelloId;

        $review = Status::where('status_name','=','For Review')->pluck('id');
        $todo = Status::where('status_name', '=','To Do')->pluck('id');
        
        $review_list = boardList::where('status_id','=',$review)->get();
        $todo_list = boardList::where('status_id','=',$todo)->get();
        $users = User::all();

        $sample = [];
        $allrevisions = [];
        $unlabeledreview = [];
        $labeledreview = [];

//per member
        $currentuser = User::where('trelloId','=',$idUser)->get();
        \Log::info($currentuser);
        foreach ($currentuser as $user) {
            foreach ($todo_list as $todo) {
                foreach ($review_list as $review) {
                    $cards_url = 'https://api.trello.com/1/lists/'.$todo->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url,labels';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                    foreach ((array)$cards as $card) {
                        if(isset($card['idMembers'])){
                        foreach ($card['idMembers'] as $member) {
                            $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                            $actionresponse = Curl::to($action_url)->get();
                            $actions = json_decode($actionresponse, TRUE);
                            foreach ((array)$actions as $action) {
                                if($idUser==$member){
                                    if (isset($action['type'])){
                                    if($action['type']=='updateCard'){
                                        if($action['data']['listBefore']['id'] == $review->list_id && $action['data']['listAfter']['id'] == $todo->list_id){
                                            //array_push($finished, $user->name);
                                             if(count($card['labels']) == 0){
                                                $date = date_create($action['date']);
                                                $sample[] = array(
                                                        'cardid' => $card['id'],
                                                        'card_name' => $card['name'],
                                                        'date_action' => date_format($date,"Y/m/d H:i:s"),
                                                        'status' => 'For Review',
                                                        'url' => $card['url'],
                                                        'label' =>' '
                                                    );
                                             }
                                             else{
                                                foreach ($card['labels'] as $label) {
                                                    $date = date_create($action['date']);
                                                    $allrevisions[] = array(
                                                        'cardid' => $card['id'],
                                                        'card_name' => $card['name'],
                                                        'listid' => $card['idList'],
                                                        'userid' => $member,
                                                        'date_action' => date_format($date,"Y/m/d H:i:s"),
                                                        'status' => 'For Review',
                                                        'url' => $card['url'],
                                                        'label' =>$label['name']
                                                    );
                                                }
                                            }
                                        }
                                    }
                                    }
                                }           
                            }
                        }
                    }
                    }
                }       
            }
        }

    

        

        $data [] ='';
        $data =[
            'labeled' => $allrevisions,
            'unlabeled' => $sample,
        ];
        return $data;
    }
    }

    public function report(){
         if(Auth::guest()){
            return view('pages.index');
        }else{
        $curuser = '';
        $trelloId = '';
        
        if(auth()->user()->role_id == 1){
            $trelloId = Input::get('user');
        }
        else{
             $trelloId = auth()->user()->trelloId;
             $curuser = User::find(auth()->user()->id);  
        } 
        
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        
        $review = Status::where('status_name','=','For Review')->pluck('id');
        $todo = Status::where('status_name', '=','To Do')->pluck('id');
        
        $review_list = boardList::where('status_id','=',$review)->get();
        $todo_list = boardList::where('status_id','=',$todo)->orWhere('status_id','=',$review)->get();
        $users = User::all();

        $sample = [];
        $allcards = Card::where('user_id','=', $trelloId)->get();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();


//per member
        $currentuser = User::where('trelloId','=',$trelloId)->get();
        \Log::info($currentuser);

    foreach ($allcards as $card => $cq) {
        $action_url = 'https://api.trello.com/1/cards/'.$cq['card_id'].'/actions?key='.$key.'&token='.$token; // change to database call
        $actionresponse = Curl::to($action_url)->get();
        $actions = json_decode($actionresponse, TRUE);
            foreach ((array)$actions as $action){
                if($action['type'] == 'commentCard'){
                    if(strpos( $action['data']['text'], "Working on" ) !== false && $action['memberCreator']['id'] == $cq['user_id']){
                              $c = Card::where('card_id', '=', $cq['card_id'])->first();
                              $c->date_started = Carbon::parse($action['date']);
                              \Log::info("ok");
                              $c->save();
                            }
                    else{
                            \Log::info("not ok");
                        }
                    }
                }*/
        if($cq['status'] == 'For Review' || $cq['status'] == 'To Do'){
             $sample[] = array(
            'cardid' => $cq['card_id'],
            'cardname' => $cq['card_name'],
            'listid' => $cq['list_id'],
            'userid' => $cq['user_id'],
            'date_started' => $cq['date_started'],
            'date_finished' => ' ',
            'status' => $cq['status'],
            'url' => $cq['url'],
            );
        }
        else{
            $sample[] = array(
            'cardid' => $cq['card_id'],
            'cardname' => $cq['card_name'],
            'listid' => $cq['list_id'],
            'userid' => $cq['user_id'],
            'date_started' => $cq['date_started'],
            'date_finished' => $cq['date_finished'],
            'status' => $cq['status'],
            'url' => $cq['url'],
            );
        }
       

    }

        if(count($sample) == 0){
            $entries = '';
            $perPage = 5;
        }
        else{
        $col = new Collection($sample);
        $perPage = count($sample);
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $entries = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

        }
        $report = self::paginate($sample, 5);
        $data = [
            'trelloId' => $curuser,
            'users' => $users,
            'sample' => $entries,
            'sample2' => $sample
        ];

       
      return $data;
        }
    }

 public function myreport(){
         if(Auth::guest()){
            return view('pages.index');
        }else{
        
        $trelloId = auth()->user()->trelloId; 
        
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        
        $review = Status::where('status_name','=','For Review')->pluck('id');
        $todo = Status::where('status_name', '=','To Do')->pluck('id');
        
        $review_list = boardList::where('status_id','=',$review)->get();
        $todo_list = boardList::where('status_id','=',$todo)->orWhere('status_id','=',$review)->get();
        $users = User::all();

        $sample = [];
        $allcards = Card::where('user_id','=', $trelloId)->get();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();


//per member
        $currentuser = User::where('trelloId','=',$trelloId)->get();
        \Log::info($currentuser);
    foreach ($currentuser as $user) {
        foreach ($todo_list as $todo) {
            $cards_url = 'https://api.trello.com/1/lists/'.$todo->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);
            \Log::info($cards);
            foreach ((array)$cards as $card) {
                foreach ($card['idMembers'] as $member) {
                        $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                        $actionresponse = Curl::to($action_url)->get();
                        $actions = json_decode($actionresponse, TRUE);
                foreach ((array)$actions as $action) {
                        if($user->trelloId == $member){
                            if($card['idList'] == $todo->list_id){
                                if($action['type'] == 'commentCard'){
                                    if(strpos( $action['data']['text'], "Working on" ) !== false && $action['memberCreator']['id'] == $member){
                                        $listid = boardList::where('list_id', '=', $card['idList'])->first();
                                        $sample[] = array(
                                        'cardid' => $card['id'],
                                        'cardname' => $card['name'],
                                        'listid' => $card['idList'],
                                        'userid' => $member,
                                        'date_started' => $action['date'],
                                        'date_finished' =>'',
                                        'status' => $listid->status->status_name,
                                        'url' => $card['url'],
                                        );
                                    }
                                }
                            }
                        }            
                    }
                }
            }
        }
    }
\Log::info($sample);
    foreach ($allcards as $card => $cq) {
        $action_url = 'https://api.trello.com/1/cards/'.$cq['card_id'].'/actions?key='.$key.'&token='.$token;
        $actionresponse = Curl::to($action_url)->get();
        $actions = json_decode($actionresponse, TRUE);
            foreach ((array)$actions as $action){
                if($action['type'] == 'commentCard'){
                    if(strpos( $action['data']['text'], "Working on" ) !== false && $action['memberCreator']['id'] == $member){
                              $c = Card::where('card_id', '=', $cq['card_id'])->first();
                              $c->date_started = Carbon::parse($action['date']);
                              $c->save();
                            }
                    else{

                        }
                    }
                }
        $sample[] = array(
        'cardid' => $cq['card_id'],
        'cardname' => $cq['card_name'],
        'listid' => $cq['list_id'],
        'userid' => $cq['user_id'],
        'date_started' => $cq['date_started'],
        'date_finished' => $cq['date_finished'],
        'status' => $cq['status'],
        'url' => $cq['url'],
        );

    }

        if(count($sample) == 0){
            $entries = '';
            $perPage = 5;
        }
        else{
        $col = new Collection($sample);
        $perPage = count($sample);
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $entries = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

        }
        $report = self::paginate($sample, 5);
        $data = [
            'trelloId' => $trelloId,
            'users' => $users,
            'sample' => $entries
        ];

       
      return $data;
        }
    }

    public function mytask(){
    
    if(Auth::guest()){
            return view('pages.index');
        }else{
   
    $trelloId = auth()->user()->trelloId;
    $key = auth()->user()->apikey;
    $token = auth()->user()->apitoken;
        
    $lists = boardList::all();
    $users = User::all();
    $done = Status::where('status_name','=','For Review')->first()->id;
    $todo = Status::where('status_name', '=','To Do')->pluck('id');
    \Log::info(Carbon::now()->subDay(1)->toDateString());
    $allcards = Card::where('user_id',$trelloId)->get();
    $revisions = BoardList::where('status_id', 3)->orWhere('status_id', 2)->get();

    $sample = [];
    $tasks = [];
    $listid = '';
    $unlabeled = [];
    $forreviewlabeled = [];
    $forreviewunlabeled = [];
    $withrevisionslabeled = [];
    $withrevisionsunlabeled = [];
    //$allcards = Card::where('user_id','=', $trelloId)->get();
    $currentuser = User::where('trelloId','=',$trelloId)->get();
    $count = 0;
    foreach ($currentuser as $user) {
           foreach ($allcards as $card) {
            $count++;
            if($card['label'] == ' '){
                if($card['status'] == 'For Review'){
                     $forreviewunlabeled[] = array(
                        'card_name' => $card['card_name'],
                        'card_id' => $card['id'],
                        'url' => $card['url'],
                        'status'=> "For Review",
                        'date_started' => $card['date_started'],
                        );   
                }
                 else if($card['status'] == 'Doing'){
                     $forreviewunlabeled[] = array(
                        'card_name' => $card['card_name'],
                        'card_id' => $card['id'],
                        'url' => $card['url'],
                        'status'=> "Doing",
                        'date_started' => $card['date_started'],
                        );   
                }
                else if($card['status'] =='To Do'){
                    foreach ($revisions as $revision) {
                        if($card['from_list_id'] == $revision['list_id']){
                             $withrevisionsunlabeled[] = array(
                                'card_name' => $card['card_name'],
                                'card_id' => $card['id'],
                                'url' => $card['url'],
                                'status'=> "With Revisions",
                                'date_started' => $card['date_started'],
                            ); 
                        }
                    }
                }
              $unlabeled[] = array(
               'card_name' => $card['card_name'],
               'card_id' => $card['cardid'],
               'url' => $card['url'],
               'listname'=> $card['status'],
               'date_started' => $card['date_started'],
                );
            }
            else{
                if($card['status'] == 'For Review'){
                     $forreviewlabeled[] = array(
                        'card_name' => $card['card_name'],
                        'label' => $card['label'],
                        'card_id' => $card['id'],
                        'url' => $card['url'],
                        'status'=> "For Review",
                        'date_started' => $card['date_started'],
                        );   
                }

                else if($card['status'] == 'Doing'){
                     $forreviewunlabeled[] = array(
                        'card_name' => $card['card_name'],
                        'card_id' => $card['id'],
                        'url' => $card['url'],
                        'status'=> "Doing",
                        'date_started' => $card['date_started'],
                        );   
                }
                else if($card['status'] =='To Do'){
                    foreach ($revisions as $revision) {
                        if($card['from_list_id'] == $revision['list_id']){
                             $withrevisionslabeled[] = array(
                                'card_name' => $card['card_name'],
                                'card_id' => $card['id'],
                                'url' => $card['url'],
                                'label' => $card['label'],
                                'status'=> "With Revisions",
                                'date_started' => $card['date_started'],
                            ); 
                        }
                    }
                }
                 $tasks[] = array(
                'label' => $card['label'],
                'card_name' => $card['card_name'],
                'card_id' => $card['id'],
                'url' => $card['url'],
                'listname'=> $card['status'],
                'date_started' => $card['date_started'],
                     );   
            }
        } 
    }


    
 
    $all=[
        'count' => $count,
        'unlabeled' => $unlabeled,
        'task' => $tasks,
        'labeledr' => $forreviewlabeled,
        'unlabeledr' => $forreviewunlabeled,
        'unlabeledwr' =>$withrevisionsunlabeled,
        'labeledwr' => $withrevisionslabeled,
    ];
    return $all;
        }

    }

    public function excel(){
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        $cardresponse ="";
        $cards ="";
        $cards_url ="https://api.trello.com/1/cards?name=asdasdasds&desc=hello&idList=59ffba51a8e61972dea61748?key=".$key.'&token='.$token;
        $cardresponse = Curl::to($cards_url)->get();
        
        return $cardsresponse;

    }

    public function postcards(){
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        $cards_url ='https://api.trello.com/1/cards?name=123123&idList=59ffba51a8e61972dea61748?key='.$key.'&token='.$token;
        $cardresponse = Curl::to('https://api.trello.com/1/cards?name=123123&desc=asdsad&idList=59ffba51a8e61972dea61748&key=78baac709b39d0f3e734d475272c29f3&token=4448a4fa8e34775ad010188b5a9b28aa51b172d900ec514728bb4d7431c84fef')->post();
    }

    public function paginate($array, $count){
        $col = new Collection($array);
        $perPage = $count;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $entries = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);
        return $entries;
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function create_auth(){

        $users= User::all();
        $allroles = Roles::all();
        
        $filesInFolder = File::allFiles(resource_path('views/pages'));

        foreach($filesInFolder as $path)
        {
            $manuals[] = pathinfo($path);
            
        }
        foreach ($manuals as $manual) {
            $array [] = array(
                'filename' => str_replace(".blade", '', $manual['filename']),
            );
        }
         $roles = DB::table("users")->join('roles', 'role_id','=','roles.id')->select(DB::raw("users.id"), DB::raw("users.name"), DB::raw("roles.role_desc"))->get();
        $data = [
            'users' => $users,
            'files' => $array,
            'roles' => $roles,
            'allroles' => $allroles
        ];
        
        
        
       return $data;
      

    }
    public function setmembers(){
     
         $role = Input::get('roles');
         $page = Input::get('page');
             $auth = new Authentications;
             $auth->has_access = $page;
             $auth->role_id = $role;
             $auth->save();
          return redirect('/authuser')->with('success','Authentication created');   
    }


    public function setroles(){
     
         $user = Input::get('users');
         $role = Input::get('roles2');
             $user = User::find($user);
             $user->role_id = $role;
             $user->save();  
             return redirect('/authuser')->with('success','Roles Updated'); 
    }

    public function getDay($day)
    {
        $days = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];

        $today = new \DateTime();
        $today->setISODate((int)$today->format('o'), (int)$today->format('W'), $days[ucfirst($day)]);
        return $today;
    }

    public function sortFunction( $a, $b ) {
        $t1 = strtotime($a['date']);
        $t2 = strtotime($b['date']);
        return $t1 - $t2;
    }

    public function multi_in_array($value, $array) 
    { 
        foreach ($array AS $item) 
        { 
            if (!is_array($item)) 
            { 
                if ($item == $value) 
                { 
                    return true; 
                } 
                continue; 
            } 

            if (in_array($value, $item)) 
            { 
                return true; 
            } 
            else if (multi_in_array($value, $item)) 
            { 
                return true; 
            } 
        } 
        return false; 
    } 

}
