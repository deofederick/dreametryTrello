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

        $daily = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("COUNT(*) as count_row, users.name"))->where('cards.date_finished','=', Carbon::now()->subDay(1)->toDateString())->groupBy(DB::raw("user_id, users.name"))->get();
        $weekly = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("COUNT(*) as count_row, users.name"))->whereBetween('cards.date_finished', [$startweek, $endweek])->groupBy(DB::raw("user_id, users.name"))->get();
        $monthly=DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("COUNT(*) as count_row, users.name"))->whereMonth('cards.date_finished', Carbon::now()->month)->whereYear('cards.date_finished', Carbon::now()->year)->groupBy(DB::raw("user_id, users.name"))->get();

    


        $pending = [];
        $sample = [];
        

    //get all cards
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
                                            //array_push($finished, $user->name);
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

//Ongoing tasks
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
        \Log::info($monthly);
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
        
        
        $dailytotal = '';
        $dtotal[] ='';

        foreach ($daily as $key) {
            array_push($dtotal, $key->count_row);
        }

        $dailytotal = array_sum($dtotal);
        

        $weeklytotal = '';
        $wtotal[] ='';

        foreach ($weekly as $key) {
            array_push($wtotal, $key->count_row);
        }

        $weeklytotal = array_sum($wtotal);

        $monthlytotal = '';
        $mtotal[] ='';

        foreach ($monthly as $key) {
            array_push($mtotal, $key->count_row);
        }

        $monthlytotal = array_sum($mtotal);

        $dailyarray[] ='';
        $dailyarray = json_decode(json_encode($daily), True);
        $monthlyarray[] ='';
        $monthlyarray = json_decode(json_encode($monthly), True);
        $weeklyarray[] ='';
        $weeklyarray = json_decode(json_encode($weekly), True);
        

        if($daily == '[]'){
            foreach ($users as $user) {
                $dailyarray[] = array(
                    'count_row' => 0,
                    'name' => $user->name,
                );
            }
         }
        if($weekly == '[]'){
            foreach ($users as $user) {
                $weeklyarray[] = array(
                    'count_row' => 0,
                    'name' => $user->name,
                );
            }
         }
       

        $alldata[]=array(
            'daily' => $dailyarray,
            'weekly' => $weeklyarray,
            'monthly' => $monthlyarray,
        );
        $otherdata[] = array(
            'pendings' => $pendings,
            'alldaily' => $dailytotal,
            'allweekly' => $weeklytotal,
            'allmonthly' => $monthlytotal,
        );

        //return $alldata;
        return view('trello.counter')->with('alldata',$alldata);
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

//per member
        $currentuser = User::where('trelloId','=',$idUser)->get();
        \Log::info($currentuser);
        foreach ($currentuser as $user) {
            foreach ($todo_list as $todo) {
                foreach ($review_list as $review) {
                    $cards_url = 'https://api.trello.com/1/lists/'.$todo->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url';
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
                                        if($action['data']['listBefore']['id'] == $review->list_id && $action['data']['listAfter']['id'] == $todo->list_id){
                                            //array_push($finished, $user->name);
                                            $sample[] = array(
                                                'cardid' => $card['id'],
                                                'cardname' => $card['name'],
                                                'listid' => $card['idList'],
                                                'userid' => $member,
                                                'date_action' => $action['date'],
                                                'status' => 'For Review',
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


        return $sample;
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

    foreach ($allcards as $card) {
        $action_url = 'https://api.trello.com/1/cards/'.$card['card_id'].'/actions?key='.$key.'&token='.$token;
        $actionresponse = Curl::to($action_url)->get();
        $actions = json_decode($actionresponse, TRUE);
            foreach ((array)$actions as $action) {
                if($action['type'] == 'commentCard'){
                    if($action['data']['text'] == 'Working on it.'){
                              $c = Card::where('card_id', '=', $card['card_id'])->get();
                              $c->date_started = Carbon::parse($action['date']);
                              $c->save();
                            }
                    else{
                        }
                    }
                }
        $sample[] = array(
        'cardid' => $card['card_id'],
        'cardname' => $card['card_name'],
        'listid' => $card['list_id'],
        'userid' => $card['user_id'],
        'date_started' => $card['date_started'],
        'date_finished' => $card['date_finished'],
        'status' => $card['status'],
        'url' => $card['url'],
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
                            );
                        }
                        else{
                        foreach ($card['labels'] as $label) {
                            $tasks[] = array(
                            'label' => $label['name'],
                            'card_name' => $card['name'],
                            'card_id' => $card['id'],
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
    $result = [];
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
    $all=array(
        'count' => $count,
        'unlabeled' => $unlabeled,
        'task' => $result
    );
    return $all;

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

}
