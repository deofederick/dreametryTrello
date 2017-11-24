@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">TASKS FINISHED TODAY</div>
                    <div class="panel-body">
              			@foreach($finished as $key => $f)
              				<div class="card text-center">
							  <div class="card-body">
							    <h3 class="card-title">{{$f->count_row}}</h3>
							  </div>
							  <div class="card-footer text-muted">
							     <p>{{$f->name}}</p>
							  </div>
							</div>
						@endforeach
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">ON GOING TASKS</div>
                    <div class="panel-body">
                        @foreach($pendings[0] as $key => $pending)
                            <div class="card text-center">
                              <div class="card-body">
                                <h3 class="card-title">{{$pending}}</h3>
                              </div>
                              <div class="card-footer text-muted">
                                 <p>{{$key}}</p>
                              </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="panel panel-warning">
                    <div class="panel-heading">FINISHED TASKS (WEEKLY)</div>
                    <div class="panel-body">
                        
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">FINISHED TASKS (MONTHLY)</div>
                    <div class="panel-body">
                        
                    </div>
                </div>

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