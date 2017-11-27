@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">This Day</th>
                      <th scope="col">This Week</th>
                      <th scope="col">This Month</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($alldata as $all)
                        @for($a = 0; $a<count($all); $a++)
                                    <tr>    
                                      <th scope="row">{{$all['monthly'][$a]['name']}}</th>
                                      <td>{{$all['daily'][$a]['count_row']}}</td>
                                      <td>{{$all['weekly'][$a]['count_row']}}</td>
                                      <td>{{$all['monthly'][$a]['count_row']}}</td>
                                    </tr>
                        @endfor
                    @endforeach
                  </tbody>
                </table>
                <div class="panel panel-danger">
                    <div class="panel-heading">REVISIONS</div>
                    
                    <div class="panel-body">
                        
                    </div>
                </div>



            </div>
        </div>
    <script>
        $('#loading').hide();
    </script>
  
@endsection