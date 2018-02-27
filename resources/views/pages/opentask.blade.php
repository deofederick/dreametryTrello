@extends('layouts.app')

@include('inc.sidebar')
@section('content')
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="task-overflows">
                <div class="card-header bg-info text-white">YOUR TASKS</div>
                  <div class="card-body bg-info text-white text-center">
                    <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> 0</h3>
                    <p class="card-text">items</p>
                  </div>
              
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <a href="task.url" target="_blank">
                      <p :lass="task.label">Lorem Ipsum</br></a>
                        <small class="text-muted">Started On 02-23-2018</small></br>
                        <span class="badge badge-doing">To-do</span>
                        </p>
                        
                    </li>
                  </ul>
              
            </div>
        </div>
    </div>
</div>

@endsection
