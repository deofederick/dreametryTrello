@extends('layouts.app')

@section('content')
@include('inc.sidebar')

<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="overflows">
              <div class="card-header bg-success text-white">SELECT BOARD</div>
              <!-- <div class="card-body bg-success text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-clipboard"></i> 999999</h3>
                <p class="card-text">boards</p>
              </div> -->
              <div id="app">
              
                <unregboard></unregboard>
            
              </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" id="overflows">
              <div class="card-header bg-warning text-white">REGISTERED BOARDS</div>
              <!-- <div class="card-body bg-warning text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-clipboard"></i> 999999</h3>
                <p class="card-text">boards</p>
              </div> -->
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
            </div>
        </div>
    </div>

        <script src="js/app.js"></script>
@endsection
