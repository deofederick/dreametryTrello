@extends('layouts.app')


@section('content')
@include('inc.sidebar')
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="task-overflows">
                <div class="card-header bg-info text-white">Open Task</div>
                  <div class="card-body bg-info text-white text-center">
                    <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> {{$totalopen}}</h3>
                    <p class="card-text">items</p>
                  </div>
              
                  <ul class="list-group list-group-flush">
                    @foreach($cards as $card)

                    <li class="list-group-item">
                      <div class="row">

                        <div class="col-md-6">
                            <a href="{{ $card["url"] }}" target="_blank">
                                <p>{{ $card["cardname"] }}
                                </p>
                            </a>
                        </div>
                        <div class="col-md-6">
                    
                            <button onclick="comment('{{$card["id"]}}')" class="btn btn-sm btn-success float-right">GET</button>
                            
                        </div>
                        
                      </div>
                        
                    </li>

                    @endforeach
                  </ul>
              
            </div>
        </div>
    </div>
</div>

<script>
    function comment(card_id, user_id) {

        var creationSuccess = function (data) {
            console.log('Data returned:' + JSON.stringify(data));
            console.log("Commented");

            window.location.href = '{{route("updatecarduser", ["card_id" => ''])}}'+'/'+card_id

        };

        Trello.post("/cards/"+card_id+"/actions/comments?text=Working on it", creationSuccess);

        //console.log("/cards/" + card_id + "/idList?value=" + list_id);

    }

   
    
</script>

@endsection
