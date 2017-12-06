<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Ixudra\Curl\Facades\Curl;
use App\User;
use App\Card;
use App\Board;
use App\boardList;
use App\Status;
use App\Actions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


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

        $pending = [];
        $sample = [];
        

    //get all cards -need to uncomment
        foreach ($users as $user) {
            foreach ($done_list as $done) {
                foreach ($review_list as $review) {
                    $cards_url = 'https://api.trello.com/1/lists/'.$done->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                    foreach ((array)$cards as $card) {
                        foreach ($card['idMembers'] as $member) {
                            $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                            $actionresponse = Curl::to($action_url)->get();
                            $actions = json_decode($actionresponse, TRUE);
                            foreach ((array)$actions as $action) {
                                if($user->trelloId==$member){
                                    if($action['type']=='updateCard'){ 
                                        if($action['data']['listBefore']['id'] == $review->list_id && $action['data']['listAfter']['id'] == $done->list_id){
                                            
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
    foreach ($users as $user) {
        foreach ($todo_list as $todo) {
            $cards_url = 'https://api.trello.com/1/lists/'.$todo->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);
            foreach ((array)$cards as $card) {
                foreach ($card['idMembers'] as $member) {
                    if($user->trelloId == $member){
                        if($card['idList'] == $todo->list_id){
                            array_push($pending, $user->name);
                        }
                    }
                }
            }
        }
    }

    foreach ($users as $user) {
        foreach ($review_list as $review) {
            $cards_url = 'https://api.trello.com/1/lists/'.$review->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);
            foreach ((array)$cards as $card) {
                foreach ($card['idMembers'] as $member) {
                    if($user->trelloId == $member){
                        if($card['idList'] == $review->list_id){
                            array_push($pending, $user->name);
                        }
                    }
                }
            }
        }
    }

    //revisio        
            
        $test[]='';
        $pendings[]='';
        $weeklys[] = '';
        //$weeklys = array(array_count_values($weekly));
        $monthlys[] = '';
        //$monthlys = array(array_count_values($monthly));
        $pendings = array(array_count_values($pending));
        $test=array(array_count_values($finished));
        \Log::info($pendings);


        foreach ($sample as $key => $value) {
               if($ucard = Card::where('card_id','=', $value['cardid'])->where('user_id', '=', $value['userid'])->exists()){
                    \Log::info('existing'.'-'.$value['cardid']);
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
                    \Log::info('saved'.'-'.$value['cardid']);
                }
        }
        
        $daily = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("users.name"), DB::raw('SUM(CASE WHEN cards.date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(cards.date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(cards.date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->groupBy(DB::raw("user_id, users.name"))->get();
        $allcount = DB::table("cards")->select(DB::raw('SUM(CASE WHEN date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->get();

        $dailyarray[] ='';
        $dailyarray = (json_encode($daily));
        $pendingarray[] ='';
        $pendingarray = json_decode(json_encode($pendings), True);
        $allcountarray[] ='';
        $allcountarray = json_decode(json_encode($allcount), True);        

        $alldata = array(
            'daily' => $daily,
            'allcount' => $allcount,
            'pendings' => $pendings,
        );
        /*$otherdata[] = array(
            'pendings' => $pendings,
            'alldaily' => $dailytotal,
            'allweekly' => $weeklytotal,
            'allmonthly' => $monthlytotal,
        );*/

        return $alldata;
        //return view('trello.counter')->with('alldata',$alldata);
        /*return view('trello.counter')->with('finished',$daily)->with('pendings', $pendings)->with('weeklys', $weekly)->with('monthlys',$monthly);
*/
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
        $forreview_label = [];
        $forreview_unlabel = [];

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
                        foreach ($card['idMembers'] as $member) {
                            $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                            $actionresponse = Curl::to($action_url)->get();
                            $actions = json_decode($actionresponse, TRUE);
                            foreach ((array)$actions as $action) {
                                if($idUser==$member){
                                    if($action['type']=='updateCard'){
                                        if($action['data']['listBefore']['id'] == $review->list_id && $action['data']['listAfter']['id'] == $todo->list_id){
                                            //array_push($finished, $user->name);
                                             if(count($card['labels']) == 0){
                                                $sample[] = array(
                                                        'cardid' => $card['id'],
                                                        'cardname' => $card['name'],
                                                        'listid' => $card['idList'],
                                                        'userid' => $member,
                                                        'date_action' => $action['date'],
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
                                                        'cardname' => $card['name'],
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

        foreach ($currentuser as $user) {
            foreach ($todo_list as $todo) {
                foreach ($review_list as $review) {
                    $cards_url = 'https://api.trello.com/1/lists/'.$review->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url,labels';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                    foreach ((array)$cards as $card) {
                        foreach ($card['idMembers'] as $member) {
                            $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                            $actionresponse = Curl::to($action_url)->get();
                            $actions = json_decode($actionresponse, TRUE);
                            foreach ((array)$actions as $action) {
                                if($idUser==$member){
                                    if($action['type']=='updateCard'){
                                        if($action['data']['listBefore']['id'] == $todo->list_id){
                                            //array_push($finished, $user->name);
                                             if(count($card['labels']) == 0){
                                                $date = date_create($action['date']);
                                                $forreview_unlabel[] = array(
                                                        'cardid' => $card['id'],
                                                        'cardname' => $card['name'],
                                                        'listid' => $card['idList'],
                                                        'userid' => $member,
                                                        'date_action' => date_format($date, "Y/m/d H:i:s"),
                                                        'status' => 'For Review',
                                                        'url' => $card['url'],
                                                        'label' =>' '
                                                    );
                                             }
                                             else{
                                                foreach ($card['labels'] as $label) {
                                                    $date = date_create($action['date']);
                                                    $forreview_label[] = array(
                                                        'cardid' => $card['id'],
                                                        'cardname' => $card['name'],
                                                        'listid' => $card['idList'],
                                                        'userid' => $member,
                                                        'date' => $action['date'],
                                                        'status' => 'For Review',
                                                        'url' => $card['url'],
                                                        'label' =>' '
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

        $data [] ='';

        usort($forreview_label, 'self::sortFunction');
        \Log::info($sample);
        $data =[
            'labeled' => $allrevisions,
            'unlabeled' => $sample,
            'forreview_label' => $forreview_label,
            'forreview_unlabel' => $forreview_unlabel
        ];
        return $data;
    }

    public function report(){
        
        $users= User::all();
        $trelloId = Input::get('user');
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        
        $review = Status::where('status_name','=','For Review')->pluck('id');
        $todo = Status::where('status_name', '=','To Do')->pluck('id');
        
        $review_list = boardList::where('status_id','=',$review)->get();
        $todo_list = boardList::where('status_id','=',$todo)->orWhere('status_id','=',$review)->get();
        $users = User::all();

        $sample = [];
        $allcards = Card::where('user_id','=', $trelloId)->get();

//per member
        $currentuser = User::where('trelloId','=',$trelloId)->get();
        \Log::info($currentuser);
    foreach ($currentuser as $user) {
        foreach ($todo_list as $todo) {
            $cards_url = 'https://api.trello.com/1/lists/'.$todo->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);
            foreach ((array)$cards as $card) {
                foreach ($card['idMembers'] as $member) {
                        $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                        $actionresponse = Curl::to($action_url)->get();
                        $actions = json_decode($actionresponse, TRUE);
                foreach ((array)$actions as $action) {
                        if($user->trelloId == $member){
                            if($card['idList'] == $todo->list_id){
                                if($action['type'] == 'commentCard'){
                                    if($action['data']['text'] == 'Working on it.'){
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

    foreach ($allcards as $card => $cq) {
        $action_url = 'https://api.trello.com/1/cards/'.$cq['card_id'].'/actions?key='.$key.'&token='.$token;
        $actionresponse = Curl::to($action_url)->get();
        $actions = json_decode($actionresponse, TRUE);
            foreach ((array)$actions as $action){
                if($action['type'] == 'commentCard'){
                    if($action['data']['text'] == 'Working on it.'){
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
                    

       
        return view('trello.reports')->with('users',$users)->with('data',$sample);

    }


    public function mytask(){

   
    $trelloId = auth()->user()->trelloId;
    $key = auth()->user()->apikey;
    $token = auth()->user()->apitoken;
        
    $lists = boardList::all();
    $users = User::all();
    \Log::info(Carbon::now()->subDay(1)->toDateString());
    $a='';

    $sample = [];
    $tasks = [];
    $unlabeled = [];
    $allcards = Card::where('user_id','=', $trelloId)->get();
    $currentuser = User::where('trelloId','=',$trelloId)->get();
    \Log::info($trelloId);
    \Log::info('logged -'.$currentuser);
       
    foreach ($currentuser as $user) {
        foreach ($lists as $list) {
            $cards_url = 'https://api.trello.com/1/lists/'.$list->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url,labels';
            $cardresponse = Curl::to($cards_url)->get();
            $cards = json_decode($cardresponse, TRUE);

            foreach ((array)$cards as $card) {
                foreach ($card['idMembers'] as $member) {
                    if($user->trelloId==$member){
                        array_push($sample, $list->status->status_name);
                        \Log::info($card['labels']);
                        if(count($card['labels']) == 0){
                            $unlabeled[] = array(
                            'card_name' => $card['name'],
                            'card_id' => $card['id'],
                            'url' => $card['url'],
                            'listname'=> $list->status->status_name
                            );
                        }
                        else{
                        foreach ($card['labels'] as $label) {
                            $tasks[] = array(
                            'label' => $label['name'],
                            'card_name' => $card['name'],
                            'card_id' => $card['id'],
                            'url' => $card['url'],
                            'listname'=> $list->status->status_name
                            );                                
                        }
                    }
                }
            }
        }
    }
}

    $count[] = '';
    $all[] = '';
    $count = array(array_count_values($sample));
    

    $groups = array();
    $result = '';
        foreach ($tasks as $data) {
          $id = $data['label'];
          if (isset($result[$id])) {
             $result[$id][] = $data;
          } else {
             $result[$id] = array($data);
          }
        }
     
    \Log::info($all);
    ksort($result);
    $all=[
        'count' => $count,
        'unlabeled' => $unlabeled,
        'task' => $tasks
    ];
    return $all;

    }

    public function excel(){

        $cards = Card::all();

        return view("trello.testvue")->with('cards', $cards);

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