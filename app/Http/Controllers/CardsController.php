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
        $list = boardList::All();
        
        $done_list = boardList::where('status_id','=',$done)->get();
        $review_list = boardList::where('status_id','=',$review)->get();
        $todo_list = boardList::where('status_id','=',$todo)->get();
        $users = User::all();

        $startweek = self::getDay('Monday')->format('Y-m-d');
        $endweek = self::getDay('Friday')->format('Y-m-d');

        $allcards = Card::all();
        $finished =[];
        $daily = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("COUNT(*) as count_row, users.name"))->groupBy(DB::raw("user_id, users.name"))->get();
        $weekly = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("COUNT(*) as count_row, users.name"))->whereBetween('cards.date_finished', [$startweek, $endweek])->groupBy(DB::raw("user_id, users.name"))->get();
        $monthly=DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("COUNT(*) as count_row, users.name"))->whereMonth('cards.date_finished', Carbon::now()->month)->whereYear('cards.date_finished', Carbon::now()->year)->groupBy(DB::raw("user_id, users.name"))->get();
        $pending = [];
        $sample = [];
        $data = [];
        $memberid = '';


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
                                    if($action['type']== 'updateCard'){
                                        if($action['data']['listBefore']['id'] == $review->list_id && $action['data']['listAfter']['id'] == $done->list_id){
                                            array_push($finished, $user->name);
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
/*        foreach ($users as $user) {
            foreach ($actions as $action) {
                foreach ($done_list as $done) {
                    foreach ($review_list as $review) {
                         if($user->trelloId==$action->user_id){
                            if($action->listBefore == $review->list_id && $action->listAfter == $done->list_id && Carbon::parse($action->date)->toDateString() == $today){
                                array_push($sample, $action->user_id);
                                array_push($finished, $user->name);
                            }
                        }
                    }                     
                }
            }           
        } 
*/
       /* foreach ($users as $user) {
            foreach ($review_list as $review) {
                foreach ($cards as $card) {
                    if($user->trelloId == $card->user_id){
                        if ($card->list_id == $review->list_id){
                            array_push($data, $action->id);
                            array_push($pending, $user->name); 
                        }
                    }     
                }
            }           
        }*/
                    
              
            
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

    if($allcards == '[]'){
        foreach ($sample as $key => $value) {
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
        }
    }
    else{
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
    }

        return view('trello.counter')->with('finished',$daily)->with('pendings', $pendings)->with('weeklys', $weekly)->with('monthlys',$monthly);


             
             




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

    public function report(){
        
        $users= User::all();
        $trelloId = Input::get('user');
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        $data =[];
        $val = [];
        $allcards = array();
        $date_attach = [];
        /*$cards_url = 'https://api.trello.com/1/members/'.$trelloId.'/cards?key='.$key.'&token='.$token;
        $cardresponse = Curl::to($cards_url)->get();
        $cards = json_decode($cardresponse, TRUE);
            foreach ((array)$cards as $card) {
                $attachment_url = 'https://api.trello.com/1/cards/'.$card['id'].'/attachments?key='.$key.'&token='.$token;
                $attachresponse = Curl::to($attachment_url)->get();
                $attachments = json_decode($attachresponse, TRUE);
                    foreach ((array)$attachments as $attach) {
                        $ext = substr($attach['name'], -3);
                            if($attach['idMember'] == $trelloId){
                                $date_attach[] = array(
                                    'id' => $attach['id'],
                                    'cardid'=> $card['id'],
                                    'member' => $attach['idMember'],
                                    'name' => $attach['name'],
                                    'date' =>$attach['date'],
                                    );
                                array_push($allcards, $card['id']);
                               usort($date_attach, array($this, "sortFunction"));
                               \Log::info($date_attach[0]);
                               ksort($date_attach);
                               /*$val = array_count_values($allcards);
                               foreach ($date_attach as $da) {
                                  foreach ($val as $key => $value) {
                                   if($key == $da['cardid']){
                                     $data = array_chunk($date_attach, $value);
                                   }
                               }
                            }       
                        }
                    }
                }*/
                       


        //usort($date_attach, 'self::sortFunction');

        $allboards = "https://api.trello.com/1/members/4ede340cde0376000002b071/boards?key=78baac709b39d0f3e734d475272c29f3&token=5c42142acd11e8a7433edf1a696e0e83dd11023515acee34ec62e31a36733a63&fields=id";



        \Log::info($date_attach);
     
        return view('trello.reports')->with('users',$users);


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
