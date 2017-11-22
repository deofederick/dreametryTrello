
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">TASK REPORT</div>
                    <div class="panel-body">
                    	<div class="col-md-12">
                    		<div class="col-md-6">
                    		<div class="form-group">
                    	<form action="/search">
						    <div class="input-group input-group-lg">
						      <span class="input-group-btn">
						        <button class="btn btn-primary" type="submit">Search</button>
						      </span>
						      <select class= "form-control" name="user">
							 	@foreach($users as $user)
							  	<option value={{$user->trelloId}}>{{$user->name}}</option>
							  	@endforeach
							</select>
						  </div>
						  </form>
						  </div>
						</div>
                    	<table class="table">
						  <thead class="thead-dark">
						    <tr>
						      <th scope="col">DATE STARTED</th>
						      <th scope="col">URL</th>
						      <th scope="col">DATE FINISHED</th>
						      <th scope="col">STATUS</th>
						    </tr>
						  </thead>
						  	<tr>
							</td>
							</tr>
						</table>
						 
                   </div>
        		</div>
    		</div>
		</div>
	</div>
    <script>
        $('#loading').hide();
    </script>
  
@endsection