<div class="container-fluid">
    <div class="row d-flex d-md-block flex-nowrap wrapper">
        <div class="col-md-2 float-left col-1 pl-0 pr-0 collapse width show" id="sidebar">
            <div class="list-group border-0 card bg-dark text-center text-md-left">
                <!-- <a href="#menu1" class="list-group-item bg-dark d-inline-block collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-dashboard"></i> <span class="hidden-sm-down">My task</span> </a>
                <div class="collapse" id="menu1">
                    <a href="#menu1sub1" class="list-group-item bg-dark" data-toggle="collapse" aria-expanded="false">Subitem 1 </a>
                    <div class="collapse" id="menu1sub1">
                        <a href="#" class="list-group-item bg-dark" data-parent="#menu1sub1">Subitem 1 a</a>
                        <a href="#" class="list-group-item bg-dark" data-parent="#menu1sub1">Subitem 2 b</a>
                        <a href="#menu1sub1sub1" class="list-group-item bg-dark" data-toggle="collapse" aria-expanded="false">Subitem 3 c </a>
                        <div class="collapse" id="menu1sub1sub1">
                            <a href="#" class="list-group-item bg-dark" data-parent="#menu1sub1sub1">Subitem 3 c.1</a>
                            <a href="#" class="list-group-item bg-dark" data-parent="#menu1sub1sub1">Subitem 3 c.2</a>
                        </div>
                        <a href="#" class="list-group-item bg-dark" data-parent="#menu1sub1">Subitem 4 d</a>
                        <a href="#menu1sub1sub2" class="list-group-item bg-dark" data-toggle="collapse" aria-expanded="false">Subitem 5 e </a>
                        <div class="collapse" id="menu1sub1sub2">
                            <a href="#" class="list-group-item bg-dark" data-parent="#menu1sub1sub2">Subitem 5 e.1</a>
                            <a href="#" class="list-group-item bg-dark" data-parent="#menu1sub1sub2">Subitem 5 e.2</a>
                        </div>
                    </div>
                    <a href="#" class="list-group-item bg-dark" data-parent="#menu1">Subitem 2</a>
                    <a href="#" class="list-group-item bg-dark" data-parent="#menu1">Subitem 3</a>
                </div>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-film"></i> <span class="hidden-sm-down">Board Registration</span></a>
                <a href="#menu3" class="list-group-item bg-dark d-inline-block collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-book"></i> <span class="hidden-sm-down">Reports</span></a>
                <div class="collapse" id="menu3">
                    <a href="#" class="list-group-item bg-dark" data-parent="#menu3">3.1</a>
                    <a href="#menu3sub2" class="list-group-item bg-dark" data-toggle="collapse" aria-expanded="false">3.2 </a>
                    <div class="collapse" id="menu3sub2">
                        <a href="#" class="list-group-item bg-dark" data-parent="#menu3sub2">3.2 a</a>
                        <a href="#" class="list-group-item bg-dark" data-parent="#menu3sub2">3.2 b</a>
                        <a href="#" class="list-group-item bg-dark" data-parent="#menu3sub2">3.2 c</a>
                    </div>
                    <a href="#" class="list-group-item bg-dark" data-parent="#menu3">3.3</a>
                </div> -->

                @if( Auth::user()->role_id == 1 )

                <a href="{{ route('tasks') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-tasks"></i> <span class="hidden-sm-down">My Task</span></a>
                <a href="{{ route('opentask') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-check"></i> <span class="hidden-sm-down">Open Task</span></a>
                <a href="{{ route('regb') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-clipboard"></i> <span class="hidden-sm-down">Board Registration</span></a>
                <a href="{{ route('taskreport') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-file-text"></i> <span class="hidden-sm-down">Reports</span></a>
                <a href="{{ route('authuser') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-lock"></i> <span class="hidden-sm-down">Authentication</span></a>

                <!--
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-heart"></i> <span class="hidden-sm-down">My Task</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-list"></i> <span class="hidden-sm-down">Board Registration</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-clock-o"></i> <span class="hidden-sm-down">Reports</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-th"></i> <span class="hidden-sm-down">Link</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-gear"></i> <span class="hidden-sm-down">Link</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-calendar"></i> <span class="hidden-sm-down">Link</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-envelope"></i> <span class="hidden-sm-down">Link</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-bar-chart-o"></i> <span class="hidden-sm-down">Link</span></a>
                <a href="#" class="list-group-item bg-dark d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-star"></i> <span class="hidden-sm-down">Link</span></a> -->
                 @else
                 <a href="{{ route('tasks') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-tasks"></i> <span class="hidden-sm-down">My Task</span></a>
                 <a href="{{ route('opentask') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-check"></i> <span class="hidden-sm-down">Open Task</span></a>
                  <a href="{{ route('taskreport') }}" class="list-group-item bg-dark textcolor d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-file-text"></i> <span class="hidden-sm-down">Reports</span></a>
                  @endif
            </div>
        </div>

