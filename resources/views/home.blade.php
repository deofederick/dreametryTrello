@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-info text-white">YOUR TASKS</div>
              <div class="card-body bg-info text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> 999999</h3>
                <p class="card-text">items</p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <p class="card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
            
                <li class="list-group-item">
                    <p class="card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
              </ul>

              <div class="card-footer text-center">
                <a href="#">See all</a>
              </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-danger text-white">PENDING TASKS</div>
              <div class="card-body bg-danger text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> 4</h3>
                <p class="card-text">items</p>
              </div>
               <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <p class="card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
            
                <li class="list-group-item">
                    <p class="card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
              </ul>
              <div class="card-footer text-center">
                <a href="#">See all</a>
              </div>
            </div>
        </div>
    </div>

@endsection
