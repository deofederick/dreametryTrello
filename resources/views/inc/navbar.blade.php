  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  
  <div class="container-fluid">
        
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
     

        @if (Auth::guest())
        <a class="navbar-brand" href="{{ url('/') }}">Dreametry Trello</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"> Register</a></li>
          </ul>
          </div>
        @else
        <a class="navbar-brand" href="{{ route('home') }}">
          Dreametry Trello
        </a>
        <!-- <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">My Task</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Live Counter</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Trello</a></li>
          </ul>
          </div> -->

      
          @if($view_name == "home" || $view_name == "welcome")
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="https://trello.com/" target="_blank">Trello</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }} 
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout()">Logout</a>
                <!-- <a href="#" class="dropdown-item" data-target="#sidebar" data-toggle="collapse" aria-expanded="false" aria-controls="sidebar">Dashboard</a> -->
                <a href="{{route('board')}}" class="dropdown-item">Dashboard</a>

               

              </div>

               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}
               </form>
               

            </li>
            </ul>
          @else
          <ul class="navbar-nav">
             <li class="nav-item"><a class="nav-link" href="https://trello.com/">Trello</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }} 
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout()">Logout</a>
                <!-- <a href="#" class="dropdown-item" data-target="#sidebar" data-toggle="collapse" aria-expanded="false" aria-controls="sidebar">Dashboard</a> -->
                <a href="{{route('board')}}" class="dropdown-item">Dashboard</a>

                <a href="#" class="dropdown-item" data-target="#sidebar" data-toggle="collapse" aria-expanded="false" aria-controls="sidebar">Toggle Dashboard</a>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="logout()">
                                    Logout
                                </a>
                                <a href="{{ route('home') }}">Dashboard</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
            @endif
        @endif

      
    </nav>
  </div>



