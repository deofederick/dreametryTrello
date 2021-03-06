<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" content="{{ csrf_token() }}">
    <meta http-equiv="pragma" content="no-cache" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dreametry Trello</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://api.trello.com/1/client.js?key=96d0a89716c8ba8fc038f09b46e49330"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue"></script>


</head>
<body class="test">
  <script>
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

        function logout() {
            Trello.deauthorize();
           // console.log('test');
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }

    </script>
    <div>
        @include('inc.navbar')
        @include('inc.loading')
       
        @yield('content')
         <div class="col-md-6">
            @include('inc.message')
        </div>
        

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
    

    <!-- Sidebar Script -->
   <!--  <script>
   $("#menu-toggle").click(function(e) {
       e.preventDefault();
       $("#wrapper").toggleClass("toggled");
   });
   </script> -->

   <!-- <script>
         $('#sidebar').collapse('hide');
   </script> -->
   
    </body>
</html>
