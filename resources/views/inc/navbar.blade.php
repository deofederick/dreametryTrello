  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  
  <div class="container-fluid">
        
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
     

        @if (Auth::guest())
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Dreametry') }}</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"> Register</a></li>
          </ul>
          </div>
        @else
        <a class="navbar-brand" href="{{ route('home') }}">
          {{ config('app.name', 'Dreametry') }}
        </a>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">My Task</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Live Counter</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Trello</a></li>
          </ul>
          </div>



          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }} 
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <!-- <a href="#" class="dropdown-item" data-target="#sidebar" data-toggle="collapse" aria-expanded="false" aria-controls="sidebar">Dashboard</a> -->
                <a href="{{route('board')}}" class="dropdown-item">Dashboard</a>
              </div>

               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}
               </form>
               

            </li>
            </ul>

          
        @endif

      
    </nav>
  </div>



