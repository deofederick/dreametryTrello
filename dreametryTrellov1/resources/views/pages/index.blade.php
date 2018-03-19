@extends('layouts.app')

@section('content')
  @if (Auth::guest())
    <div class="container">
      <div class="jumbotron text-center">
        <h1>Welcome</h1>
        <p>This is a App for Dreametry Trello Task Counter</p>
        <p><a class="btn btn-lg btn-primary" href="{{route('register')}}" role="button">Register</a> <a class="btn btn-lg btn-success" href="{{route('login')}}" role="button">Login</a></p>
      </div>
    </div>
  @else
    <div class="container">
      <div class="jumbotron text-center">
        <h1>Welcome Back {{ Auth::user()->name }}</h1>
        <p>You Are Logged in!</p>
      </div>
    </div>
  @endif

 <!--  <script type="text/javascript">
   $.get('/registerlist', function(json) {
     console.log(json['object']);
   });
 </script> -->
@endsection