@extends('layouts.app')

@section('content')
<div class="jumbotron">
  <h1 class="display-3">Hello, world!</h1>
  <p class="lead"></p>
  <hr class="my-4">
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">login</a>
  </p>
</div>
@endsection