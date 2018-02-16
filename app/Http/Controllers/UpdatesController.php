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
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Routing\Controller;

class UpdatesController extends Controller
{
    public function updatecards(){
    	

        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;

        $users = User::all();
      
        $allcards = Card::all();
        $alltasks = BoardList::where('status_id', 1)->orWhere('status_id', 2)->orWhere('status_id', 3)->orWhere('status_id', 4)->get();
        $finished =[];

        $allpending = [];
        $sample = [];

        $pendingTasks = BoardList::where('status_id', 1)->orWhere('status_id', 2)->get();
        
   
            foreach($alltasks as $alltask){
                    $cards_url = 'https://api.trello.com/1/lists/'.$alltask->list_id.'/cards?key='.$key.'&token='.$token.'&fields=name,idList,idMembers,url,labels';
                    $cardresponse = Curl::to($cards_url)->get();
                    $cards = json_decode($cardresponse, TRUE);
                    
                foreach ((array)$cards as $card) {
                   
                        if(count($card['idMembers']) <= 0 && $alltask->status_id == 1){

                                 $sample[] = array(
                                    'cardid' => $card['id'],
                                    'cardname' => $card['name'],
                                    'listid' => $card['idList'],
                                    'userid' => '',
                                    'date_finished' => '0001-01-01',
                                    'status' => 'To Do',
                                    'url' => $card['url'],
                                    'from' => '',
                                    'labels' => $card['labels']
                                    );   
                        }


                    else{
                        foreach ($card['idMembers'] as $member){
                        $action_url = 'https://api.trello.com/1/cards/'.$card['id'].'/actions?key='.$key.'&token='.$token;
                        $actionresponse = Curl::to($action_url)->get();
                        $actions = json_decode($actionresponse, TRUE);
                        if(count($actions) <= 0 && $alltask->status_id == 1){
                             $sample[] = array(
                                    'cardid' => $card['id'],
                                    'cardname' => $card['name'],
                                    'listid' => $card['idList'],
                                    'userid' => $member,
                                    'date_finished' => '0001-01-01',
                                    'status' => 'To Do',
                                    'url' => $card['url'],
                                    'from' => '',
                                    'labels' => $card['labels']
                                    );   
                        }
                        else{ 
                            foreach ((array)$actions as $action) {
                                    if($alltask->status_id == 1){
                                        if(isset($action['type'])){
                                            if($action['type'] == 'updateCard'){
                                                     echo 'ok1';
                                                    $sample[] = array(
                                                    'cardid' => $card['id'],
                                                    'cardname' => $card['name'],
                                                    'listid' => $card['idList'],
                                                    'userid' => $member,
                                                    'date_finished' => '0001-01-01',
                                                    'status' => 'To Do',
                                                    'url' => $card['url'],
                                                    'from' => $action['data']['listBefore']['id'],
                                                    'labels' => $card['labels']
                                                     );                                                     
                                            } 
                                            
                                        }
                                    }

                                    else if($alltask->status_id == 2){
                                            if(isset($action['type'])){
                                            if($action['type']=='updateCard'){
                                                if(is_array($action) && $action['type']=='updateCard'){
                                                        $sample[] = array(
                                                        'cardid' => $card['id'],
                                                        'cardname' => $card['name'],
                                                        'listid' => $card['idList'],
                                                        'userid' => $member,
                                                        'date_finished' => '0001-01-01',
                                                        'status' => 'Doing',
                                                        'url' => $card['url'],
                                                        'from' => $action['data']['listBefore']['id'],
                                                        'labels' => $card['labels']
                                                        );                                             
                                                }
                                            }
                                        }
                                        
                                    }


                                    else if($alltask->status_id == 3){
                                        if(isset($action['type'])){
                                            if($action['type']=='updateCard'){
                                                if(is_array($action) && $action['type']=='updateCard'){
                                                        $sample[] = array(
                                                        'cardid' => $card['id'],
                                                        'cardname' => $card['name'],
                                                        'listid' => $card['idList'],
                                                        'userid' => $member,
                                                        'date_finished' => '0001-01-01',
                                                        'status' => 'For Review',
                                                        'url' => $card['url'],
                                                        'from' => $action['data']['listBefore']['id'],
                                                        'labels' => $card['labels']
                                                        );                                             
                                                }
                                            }
                                        }   
                                    }

                                   else if($alltask->status_id == 4){
                                        if(isset($action['type'])){
                                            if($action['type']=='updateCard'){
                                                if(is_array($action) && $action['type']=='updateCard'){
                                                        $sample[] = array(
                                                        'cardid' => $card['id'],
                                                        'cardname' => $card['name'],
                                                        'listid' => $card['idList'],
                                                        'userid' => $member,
                                                        'date_finished' => $action['date'],
                                                        'status' => 'Done',
                                                        'url' => $card['url'],
                                                        'from' => $action['data']['listBefore']['id'],
                                                        'labels' => $card['labels']
                                                        );                                          break;
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
                            
        
    foreach ($sample as $key1 => $value) { 
            $date_started = Carbon::parse('0001-01-01');
            $action_url = 'https://api.trello.com/1/cards/'.$value['cardid'].'/actions?key='.$key.'&token='.$token;
            $actionresponse = Curl::to($action_url)->get();
            $actions = json_decode($actionresponse, TRUE);
            foreach ((array)$actions as $action){
                if($action['type'] == 'commentCard'){
                    if(strpos(strtolower($action['data']['text']), "working on" ) !== false && $action['memberCreator']['id'] == $value['userid']){
                            $date_started = Carbon::parse($action['date']);
                             
                            }
                    else{
                             
                              
                        }
                    }
                }
                
        if(count($value['labels']) == 0){
            $ucard = Card::where('card_id','=', $value['cardid']);

            
               if($ucard->exists()){
                   $id = $ucard->pluck('id');
                   $uc = Card::where('id',$id)->first();
                   $uc->card_id = $value['cardid'];
                   $uc->card_name = $value['cardname'];
                   $uc->date_finished = Carbon::parse($value['date_finished']);
                   $uc->user_id = $value['userid'];
                   $uc->list_id = $value['listid'];
                   $uc->status = $value['status'];
                   $uc->date_started = $date_started;
                   $uc->url = $value['url'];
                   $uc->from_list_id = $value['from'];
                   $uc->label = '';
                   $uc->save();
                   
                }
                else{
                    $c = new Card;
                    $c->card_id = $value['cardid'];
                    $c->card_name = $value['cardname'];
                    $c->date_finished = Carbon::parse($value['date_finished']);
                    $c->user_id = $value['userid'];
                    $c->list_id = $value['listid'];
                    $c->status = $value['status'];
                    $c->date_started =  $date_started;
                    $c->url = $value['url'];
                    $c->from_list_id = $value['from'];
                    $c->label = ' ';
                    $c->save();
                   //\Log::info('saved'.'-'.$value['cardid']);
                }

        }
        else{
            foreach ($value['labels'] as $label) {
                $ucard = Card::where('card_id','=', $value['cardid']);
               if($ucard->exists()){
                 \Log::info($value['cardname'].'-'.$value['date_finished']);
                   $id = $ucard->pluck('id');
                   $uc = Card::where('id',$id)->first();
                   $uc->card_id = $value['cardid'];
                   $uc->card_name = $value['cardname'];
                   $uc->date_finished = Carbon::parse($value['date_finished']);
                   $uc->user_id = $value['userid'];
                   $uc->list_id = $value['listid'];
                   $uc->status = $value['status'];
                   $uc->date_started = $date_started;
                   $uc->url = $value['url'];
                   $uc->from_list_id = $value['from'];
                   $uc->label = $label['name'];
                   $uc->save();
                }
                else{
                    $c = new Card;
                    $c->card_id = $value['cardid'];
                    $c->card_name = $value['cardname'];
                    $c->date_finished = Carbon::parse($value['date_finished']);
                    $c->user_id = $value['userid'];
                    $c->list_id = $value['listid'];
                    $c->status = $value['status'];
                    $c->date_started = $date_started;
                    $c->url = $value['url'];
                    $c->from_list_id = $value['from'];
                    $c->label = $label['name'];
                    $c->save();
                   //\Log::info('saved'.'-'.$value['cardid']);
                }
            }

        }
              
    }
     return $sample;   
    }


public function getcards(){

    $daily = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("users.name"), DB::raw('SUM(CASE WHEN cards.date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(cards.date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(cards.date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->where('status', 'Done')->groupBy(DB::raw("user_id, users.name"))->get();

    $pending = DB::table("cards")->join('users', 'user_id','=','users.trelloId')->select(DB::raw("users.name"), DB::raw('count(cards.id) as count'))->where('status','!=','Done')->groupBy(DB::raw("user_id, users.name"))->get();
    
    $allcount = DB::table("cards")->select(DB::raw('SUM(CASE WHEN date_finished = CURDATE() THEN 1 ELSE 0 END) AS daily_count'), DB::raw('SUM(CASE WHEN month(date_finished) = month(CURDATE()) and year(cards.date_finished) = year(CURDATE())  THEN 1 ELSE 0 END) AS monthly_count'), DB::raw('SUM(CASE WHEN weekofyear(date_finished) = weekofyear(now()) THEN 1 ELSE 0 END) AS weekly_count'))->where('user_id','!=', ' ')->where('status','Done')->get();
    

    $alldata =array(                                            
        'daily' => $daily,                     
        'allcount' =>$allcount,
        'pending' => $pending    
        );       
                                        
    return $alldata;

}

public function gcal()
    {
        session_start();

        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);

      
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($client);

            $calendarId = 'primary';

            $results = $service->events->listEvents($calendarId);
            $events = $results->getItems();

            $data = [];

            foreach ($events as $event) {


                $data[] = array(
                    'id' => $event['id'],
                    'title' => $event['summary'],
                    'startdate' => $event['start']['date'],
                    'start' => $event['start']['dateTime'],
                    'endate' => $event['end']['date'],
                    'end' => $event['end']['dateTime'],
                    'link' => $event['htmlLink']
                      
                );

            }

            //return $data;

            //return $data[1]['start'];

            $test = new Carbon($data[1]['start']);
            
            return $test;


        } else {
            //return redirect()->route('oauthCallback');
            return redirect('/oauth');
        }

        if ($client->isAccessTokenExpired()) {
        session_destroy();
       
        }
    }

    public function oauth(){
        session_start();

        $rurl = action('gCalendarsController@oauth');
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
        $client->setHttpClient($guzzleClient);
        $client->setRedirectUri($rurl);


        if (!isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
            return redirect($filtered_url);
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            //return redirect()->route('cal.index');
            return redirect('/cal');
        }

        if($client->isAccessTokenExpired()) {
          session_destroy();
      }
    }

}


