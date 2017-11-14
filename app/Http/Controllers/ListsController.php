<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Board;
use App\BoardList;
use Auth;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
        $boards = Board::orderBy('created_at', 'desc')->paginate(10);
        //\Log::info($boards);
  
        $id = auth()->user()->trelloId;
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
  
          $regBoard = [];
          $unRegBoard = [];
          if (count($boards) > 0) {
            
             
              $url = 'https://api.trello.com/1/members/'.$id.'/boards?key='.$key.'&token='.$token.'&fields=id,name,url,memberships,idOrganization&lists=open';
              $response = Curl::to($url)->get();
              $urlboards = json_decode($response, TRUE);
  
              foreach ($urlboards as $urlboard) {
                  $orgurl = 'https://api.trello.com/1/organizations/'.$urlboard['idOrganization'].'?key='.$key.'&token='.$token;
                  
                  $orgresponse = Curl::to($orgurl)->get();
                  $org = json_decode($orgresponse, TRUE);
                
                  for ($i=0; $i < count($boards); $i++) { 

                    
                      if ($urlboard['id'] === $boards[$i]->board_id) {
                       
                          $regBoard[] = array(
                              'boardName' => $urlboard['name'],
                              'boardId' => $urlboard['id'],
                              'organization' => $org['displayName']
                          );

                          
                          $i = count($boards);
                      }elseif (count($boards)-1 === $i) {
                          $unRegBoard[] = array(
                              'boardName' => $urlboard['name'],
                              'boardId' => $urlboard['id'],
                              'organization' => $org['displayName']
                          );
                      }
  
                  }
  
              }
          }else{
              
              $url = 'https://api.trello.com/1/members/'.$id.'/boards?key='.$key.'&token='.$token.'&fields=id,name,url,memberships,idOrganization&lists=open';
             
              $response = Curl::to($url)->get();
              $urlboards = json_decode($response, TRUE);
            //  \Log::info($urlboards);
              foreach ($urlboards as $urlboard) {
                  $orgurl = 'https://api.trello.com/1/organizations/'.$urlboard['idOrganization'].'?key='.$key.'&token='.$token;
                  
                  $orgresponse = Curl::to($orgurl)->get();
                  $org = json_decode($orgresponse, TRUE);
                 // \Log::info($org);
                  $unRegBoard[] = array(
                      'boardName' => $urlboard['name'],
                      'boardId' => $urlboard['id'],
                      'organization' => $org['displayName']
                      
                  );
              }
          }
          
          $data = array(
              'regBoards' => $regBoard,
              'unRegBoards' => $unRegBoard
          );
  
          //\Log::info($data);
          return $data;
         // return view('trello.registerList')->with($data);

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

        $this->validate($request,[
            'selecttodo' => 'required',
            'selectforreview' => 'required',
            'selectdone' => 'required',
            'selectpaid' => 'required'
        ]);
        
        $id = $request->input('board_id');

        $todo = $request->input('todo');
        $selecttodo = $request->input('selecttodo');

        $forreview = $request->input('forreview');
        $selectforreview = $request->input('selectforreview');

        $done = $request->input('done');
        $selectdone = $request->input('selectdone');

        $paid = $request->input('paid');
        $selectpaid = $request->input('selectpaid');


        if (($selecttodo === $selectforreview) || ($selecttodo === $selectdone)
         || ($selecttodo === $selectpaid) || ($selectforreview === $selectdone)
         || ($selectforreview === $selectpaid) || ($selectdone === $selectpaid)) {
            
            //return redirect('/registerlist/'.$id)->with('error', 'Duplicate Choice');

        }else{
            
            $list = new boardList;
            $list->list_id = $selecttodo;
            $list->status_id = $todo;
            $list->board_id = $id;
            $list->save();

            $list = new boardList;
            $list->list_id = $selectforreview;
            $list->status_id = $forreview;
            $list->board_id = $id;
            $list->save();

            $list = new boardList;
            $list->list_id = $selectdone;
            $list->status_id = $done;
            $list->board_id = $id;
            $list->save();

            $list = new boardList;
            $list->list_id = $selectpaid;
            $list->status_id = $paid;
            $list->board_id = $id;
            $list->save();

            //return redirect('/registerlist')->with('success', 'Lists Saved');
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $regboard = Board::where('board_id', $id)->first();
       // \Log::info($regboard->id);
        
        $idUser = auth()->user()->trelloId;
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;

        $boardListurl = 'https://api.trello.com/1/boards/'.$id.'?key='.$key.'&token='.$token.'&fields=name';
        $boardListresponse = Curl::to($boardListurl)->get();
        $boardLists = json_decode($boardListresponse, TRUE);
        //\Log::info($boardLists);
      
        $edit = false;
        if(count($regboard) > 0/*  && count($regboardList) != 0 */){
           // \Log::info("found");

           $regboardList = boardList::where('board_id', $regboard->id)->first();

           if (count($regboardList) != 0) {
                $edit = true;
           }
           
           $listUrl = "https://api.trello.com/1/boards/".$id."/lists?key=".$key."&token=".$token."&cards=none&filter=open";
           $listresponse = Curl::to($listUrl)->get();
           $lists = json_decode($listresponse, TRUE);
          
         //  \Log::info($lists);
           $data = array(
              // 'boards' => $boardArray,
               'lists' => $lists,
               'listsBoard' => $boardLists,
               'editable' => $edit,
               'boardid' => $regboard

           );
   
          // \Log::info($data);
         //  return view('trello.registerListShow')->with($data);


        }else{
            
            if (count($regboard) <= 0) {
                $board = new Board;
                $board->board_id = $id;
                $board->board_name = $boardLists['name'];
                $board->save();
            }

        /*     $listUrl = "https://api.trello.com/1/boards/".$id."/lists?key=".$key."&token=".$token."&cards=none&filter=open";
            $listresponse = Curl::to($listUrl)->get();
            $lists = json_decode($listresponse, TRUE);
           
          //  \Log::info($lists);
            $data = array(
               // 'boards' => $boardArray,
                'lists' => $lists,
                'listsBoard' => $boardLists,
                'editable' => $edit,
                'boardid' => $regboard
 
            ); */
            
           // return view('trello.registerListShow')->with($data);

          // return redirect('/registerlist/'.$id)->with('success', 'Board Registered');
        }

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
