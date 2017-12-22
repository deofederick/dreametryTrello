@extends('layouts.app')

@section('content')
@include('inc.sidebar')
<div id = "app">
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="task-overflows">
                <div class="card-header bg-info text-white">YOUR TASKS</div>
                  <div class="card-body bg-info text-white text-center">
                    <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> @{{count}}</h3>
                    <p class="card-text">items</p>
                  </div>
              
                <div class="loader justify-content-center" v-show="loading"></div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-cloak v-for="task in tasks">
                      <a :href="task.url">
                      <p :class="task.label">@{{task.card_name}}</br>
                        <small class="text-muted">Started On @{{task.date_action}}</small></br>
                        <span :class="task.status">@{{task.listname}}</span>
                        </p>
                        </a>
                    </li>
                  </ul>
              
            </div>
        </div>
           
        <div class="col-md-6">
            <div class="card" id="task-overflows">
              <div class="card-header bg-danger text-white">PENDING TASKS </div>
                <div class="card-body bg-danger text-white text-center">
                  <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> @{{pcount}}</h3>
                  <p class="card-text">items</p>
                </div>
                
               
                
                 <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-cloak v-for="pending in pendings">
                      <p :class="pending.label">@{{pending.card_name}}</br>
                      <small class="text-muted">@{{pending.date_action}}</small></br>
                      <span :class="pending.status">@{{pending.statusname}}</span>
                    </p>
                    </li>
                  </ul>
              </div>
            </div>
        </div>
    </div>
</div>
  <div class="zoom">
  <a class="zoom-fab zoom-btn-large" id="zoomBtn"><span class="fa fa-info-circle"></span></a>
  <ul class="zoom-menu">
    <li><a class="zoom-fab zoom-btn-sm zoom-btn-l1 scale-transition scale-out text-white">L1</a></li>
    <li><a class="zoom-fab zoom-btn-sm zoom-btn-l2 scale-transition scale-out text-white">L2</a></li>
    <li><a class="zoom-fab zoom-btn-sm zoom-btn-l3 scale-transition scale-out text-white">L3</a></li>
    <li><a class="zoom-fab zoom-btn-sm zoom-btn-l4 scale-transition scale-out text-white">L4</a></li>
  </ul>
 
</div>

</div>


    <script src="js/app.js"></script>
<script>
         new Vue({
            el: '#app',
            name: 'test',
            data(){
                return{
                      count:'',
                      pcount:'',
                      loading: false,
                      tasks:[],
                      pendings:[]
                      }
                
              },

              mounted: function(){
                  this.getalltasks()
              }, methods:{
                  getalltasks: function(){
                    var vm = this;
                    vm.loading = true;

                 console.log('revisions');
                    
                    
                    vm.$http.get('/mytasks').then(function(response){
                      console.log('test');
                    //console.log(response.data.unRegBoards[0]);
                    //console.log(response);
                      var alltask = response.data.task;
                      var unlabeled = response.data.unlabeled;
                      var labeledr = response.data.labeledr;
                      var unlabeledr = response.data.unlabeledr;
                      
                      console.log(unlabeledr);

                     

                      alltask.forEach(function(value, id){
                        console.log(value.listname);
                        var status = value.listname;
                      vm.tasks.push({"label": "card-text notice notice-"+value.label.toLowerCase(), "card_name": value.card_name, "date_action": value.date_started, "url": value.url, "listname": value.listname, "status": "badge badge-"+status.replace(/\s+/g, '').toLowerCase()})
               
                    })
                      unlabeled.forEach(function(value, id){
                        var status = value.listname;
                      vm.tasks.push({"label": "card-text notice notice-null", "card_name": value.card_name, "url": value.url, "date_action": value.date_started, "listname": value.listname,  "status": "badge badge-"+status.replace(/\s+/g, '').toLowerCase()})
               
                    })

                      unlabeledr.forEach(function(value, id){
                        var status = value.status;
                      vm.pendings.push({"label": "card-text notice notice-null", "card_name": value.card_name, "date_action": value.date_started, "url": value.url,  "status": "badge badge-"+status.replace(/\s+/g, '').toLowerCase(), "statusname": value.status})
               
                    })
                       vm.count = vm.tasks.length;

                      labeledr.forEach(function(value, id){
                        
                      vm.pendings.push({"label": "card-text notice notice-"+value.label.toLowerCase(), "card_name": value.card_name, "date_action": value.date_started, "url": value.url,  "status": "badge badge-"+status.replace(/\s+/g, '').toLowerCase(), "statusname": value.status})
               
                    })
                    vm.pcount = vm.pendings.length;  
                   
                   vm.loading = false;
                    }).catch(function(error){

                    });

                    vm.$http.get('/revision').then(function(response){
                      console.log('allrevision');
                    //console.log(response.data.unRegBoards[0]);
                    //console.log(response);
                      var labeled = response.data.labeled;
                      var unlabeled = response.data.unlabeled;
                      
                      console.log(unlabeled);
                       console.log('1');
                      labeled.forEach(function(value, id){

                    vm.pendings.push({"label": "card-text notice notice-"+value.label.toLowerCase(), "card_name": value.card_name, "date_action": value.date_action, "url": value.url,  "status": "badge badge-revision", "statusname": "With Revisions"})
               
                    })  
                      console.log("ok");
                  unlabeled.forEach(function(value, id){

                    vm.pendings.push({"label": "card-text notice notice-null", "card_name": value.card_name, "date_action": value.date_action, "url": value.url,  "status": "badge badge-revision", "statusname": "With Revisions"})
               
                    })
                     vm.pcount = vm.pendings.length;  
                   
                      console.log("ok2");
                   
                    }).catch(function(error){

                    });                   


                    
                  }


              } 

          });

         
        </script>

    <script type="text/javascript">
        $('#zoomBtn').click(function() {
        $('.zoom-btn-sm').toggleClass('scale-out');
        if (!$('.zoom-card').hasClass('scale-out')) {
          $('.zoom-card').toggleClass('scale-out');
        }
      });

      $('.zoom-btn-sm').click(function() {
        var btn = $(this);
        var card = $('.zoom-card');
        if ($('.zoom-card').hasClass('scale-out')) {
          $('.zoom-card').toggleClass('scale-out');
        }
        if (btn.hasClass('zoom-btn-person')) {
          card.css('background-color', '#d32f2f');
        } else if (btn.hasClass('zoom-btn-doc')) {
          card.css('background-color', '#fbc02d');
        } else if (btn.hasClass('zoom-btn-tangram')) {
          card.css('background-color', '#388e3c');
        } else if (btn.hasClass('zoom-btn-report')) {
          card.css('background-color', '#1976d2');
        } else {
          card.css('background-color', '#7b1fa2');
        }
      });
    </script>



        
@endsection
