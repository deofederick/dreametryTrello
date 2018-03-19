<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;

class gCalendarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    



    public function index()
    {
        session_start();

        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

        //$client->revokeToken();

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
            $months = array();
            $new_array = array();

            foreach ($data as $key => $value) {
              $date = '';
              $month = '';
              if(is_null($value['start'])){

                $sdate = Carbon::parse($value['startdate']);
                $edate = Carbon::parse($value['endate']);
                $range = self::generateDateRange($sdate, $edate);
                foreach ($range as $dt) {
                    $date = Carbon::parse($dt);
                    $month = $date->month.'/'.$date->year;   
                }
              }
              else{
                $sdate = Carbon::parse($value['start']);
                $edate = Carbon::parse($value['end']);
                $range = self::generateDateRange($sdate, $edate);
                foreach ($range as $dt) {
                    $date = Carbon::parse($dt);
                    $month = $date->month.'/'.$date->year;   
                }
              }
              array_push($months, $month);
            }

            $group = array_unique($months);
            foreach ($group as $date) {
                foreach ($data as $key => $value) {
                    if(is_null($value['start'])){
                        $sdate = Carbon::parse($value['startdate']);
                        $edate = Carbon::parse($value['endate']);
                        $range = self::generateDateRange($sdate, $edate);
                        foreach ($range as $dt) {
                            $dts = Carbon::parse($dt);
                            $month = $dts->month.'/'.$dts->year;
                           if($date == $month){
                            $new_array[$date][] = array(
                                'title' => $value['title'], 
                                'date' => $dt,
                                'url' => $value['link']);
                            }   
                        }
                        //$sdt = Carbon::parse($value['startdate']);
                        //$month = $sdt->month.'/'.$sdt->year;
     
                    }
                    else{
                        $dt = Carbon::parse($value['start']);
                        $month = $dt->month.'/'.$dt->year;
                        if($date == $month){
                            $new_array[$date][] = array(
                                'title' => $value['title'], 
                                'date' => $value['start'],
                                'url' => $value['link']);
                        }   
                    }
                }
            }

            $alldata = array(
                'months' => $group,
                'events' => $new_array,
            );
            return $alldata;


        } else {
            //return redirect()->route('oauthCallback');
            return redirect('/oauth');
        }

        if ($client->isAccessTokenExpired()) {
        session_destroy();
       
        }
    }

    public function generateDateRange(Carbon $start_date, Carbon $end_date)
    {

    $dates = [];
    $diff = $start_date->diffInDays($end_date);  
    if($diff <= 1){
        $dates[] = $start_date->format('Y-m-d');
    }
    else{
       for($date = $start_date; $date->lte($end_date); $date->addDay()) {
          $dates[] = $date->format('Y-m-d');
       }

    }

    return $dates;

    }

    public function oauth(){
        session_start();

        $rurl = action('gCalendarsController@oauth');
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

       // $client->revokeToken();

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
