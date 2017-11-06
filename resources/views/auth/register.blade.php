@extends('layouts.app')

@section('content')
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

    function addObject(id){
        var retrieveSuccess = function(data) {
            console.log('Data returned:' + JSON.stringify(data));
            //$('#user').append("<img src=\"http://trello-avatars.s3.amazonaws.com/"+data.avatarHash+"/50.png\" style=\"width: 25px; height: 25px;\"> "+data.fullName+" <b class=\"caret\"></b>")
            $('#trelloId').val(data.id);
            $('#name').val(data.fullName);
            var src1 = 'https://trello-avatars.s3.amazonaws.com/' + data.avatarHash + '/50.png';
            $("#hash").attr("src", src1);
            $('#avatarHash').val(data.avatarHash);
        };

        Trello.get("members/" + id, {fields: "avatarHash,fullName,url,username,email"}, retrieveSuccess);

    }

    function getUsername(){

        var retrieveSuccess = function(data) {
            console.log('Data returned:' + JSON.stringify(data));
            addObject(data.id);
        };

        Trello.get("members/me", {fields: "name,displayName,url"}, retrieveSuccess);

    }


    $(document).ready(function () {
        getUsername();
        $("#apikey").keyup(function() {
            console.log($(this).val());
            $('#linkhreftoken').attr('href', "https://trello.com/1/authorize?expiration=never&scope=read,write,account&response_type=token&name=Dreametry%20App&key="+$(this).val());
        });

       
    });

    

</script>    

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('trelloId') ? ' has-error' : '' }}">
                            <label for="trelloId" class="col-md-4 control-label">Trello Id</label>
 
                            <div class="col-md-4">
                                <input id="trelloId" type="text" class="form-control" name="trelloId" value="" required readonly>
                                @if ($errors->has('trelloId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('trelloId') }}</strong>
                                    </span>
                                @endif
                            </div>
                             <div class="col-md-4">
                                <input id="avatarHash" type="hidden" class="form-control" name="avatarHash" value="" required readonly>
                                <img src="" alt="hash" id="hash" class="img-rounded">
                                @if ($errors->has('avatarHash'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('avatarHash') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('apikey') ? ' has-error' : '' }}">
                            <label for="apikey" class="col-md-4 control-label"><a href="https://trello.com/app-key" target="_blank">Add Api Key</a></label>

                            <div class="col-md-6">
                                <input id="apikey" type="text" class="form-control" name="apikey" value="{{ old('apikey') }}" required autofocus>

                                @if ($errors->has('apikey'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apikey') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('apitoken') ? ' has-error' : '' }}">
                            <label for="apitoken" class="col-md-4 control-label"><a id="linkhreftoken" href="" target="_blank">Add Api token</a></label>

                            <div class="col-md-6">
                                <input id="apitoken" type="text" class="form-control" name="apitoken" value="{{ old('apitoken') }}" required autofocus>

                                @if ($errors->has('apitoken'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apitoken') }}</strong>
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
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                                <!-- <input type="button" name="Logout" onclick="logout()" value="Logout"> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
