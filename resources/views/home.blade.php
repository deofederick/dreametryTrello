@extends('layouts.app')

@section('content')

<div class="container" id="paddingtop">
  <div class="row">
    <div class="col-md-4 placeholder justify-content-center text-center" id="tasktoday">
      <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
      <div class="centered text-white"><h1>0</h1></div>
      <h4>Today</h4>
      <div class="text-muted">mm/dd/yyyy</div>
    </div>

    <div class="col-md-4 placeholder justify-content-center text-center" id="tasktoday">
      <img src="" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
      <div class="centered text-white"><h1>0</h1></div>
      <h4>This week</h4>
      <div class="text-muted">mm/dd/yyyy</div>
    </div>

    <div class="col-md-4 placeholder justify-content-center text-center" id="tasktoday">
      <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
      <div class="centered text-white"><h1>0</h1></div>
      <h4>This month</h4>
      <div class="text-muted">mm/dd/yyyy</div>
    </div>
  </div>
</div>

@endsection