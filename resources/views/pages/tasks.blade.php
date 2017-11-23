@extends('layouts.app')

@section('content')
@include('inc.sidebar')
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="task-overflows">
              <div class="card-header bg-info text-white">YOUR TASKS</div>
              <div class="card-body bg-info text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> 999999</h3>
                <p class="card-text">items</p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <p class="notice notice-l1 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
            
                <li class="list-group-item">
                    <p class="notice notice-l2 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l3 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l4 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l5 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
              </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" id="task-overflows">
              <div class="card-header bg-danger text-white">PENDING TASKS</div>
              <div class="card-body bg-danger text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> 4</h3>
                <p class="card-text">items</p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <p class="notice notice-l1 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
            
                <li class="list-group-item">
                    <p class="notice notice-l2 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l3 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l4 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l5 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
              </ul>

            </div>
        </div>
    </div>

@endsection
