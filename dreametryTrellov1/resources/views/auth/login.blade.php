@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="form">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <input type="hidden" id="trelloId" name="userid" value="Content of the extra variable">
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" onclick="trelloLogin()" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <script src="js/app.js"></script>
<script type="text/javascript">
  

    var authenticationSuccess = function() { console.log('Successful authentication'); };
    var authenticationFailure = function() { console.log('Failed authentication'); };

    Trello.authorize({
        type: 'redirect',
        name: 'Dreametry App',
        scope: {
        read: 'true',
        write: 'true' },
        expiration: 'never',
        success: authenticationSuccess,
        error: authenticationFailure
    });

     function getUsername(){

        var retrieveSuccess = function(data) {
            console.log('Data returned:' + JSON.stringify(data));
            addObject(data.id);
            document.getElementById('trelloId').value = data.id;
            if(document.getElementById('trelloId').value != ''){
                document.getElementById("form").submit();
            }
              
        };

        Trello.get("members/me", {fields: "name,displayName,url,email"}, retrieveSuccess);
            }


    
function addObject(id){
        var retrieveSuccess = function(data) {
            console.log('Data returned:' + JSON.stringify(data));
            $('#trelloId').val(data.id);   
            document.getElementById('trelloId').value = data.id;
            console.log(document.getElementById('trelloId').value); 
        };

        Trello.get("members/" + id, {fields: "email, id"}, retrieveSuccess);

        

    }

    function get(){

        var retrieveSuccess = function(data) {
            console.log('Data returned:' + JSON.stringify(data));
          
        };

        Trello.get("members/me", {fields: "name,id"}, retrieveSuccess);

    }
$(document).ready(function () {
        getUsername();
        
    });

   



</script>


@endsection
