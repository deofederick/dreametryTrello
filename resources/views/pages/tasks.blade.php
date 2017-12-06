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
              
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-cloak v-for="task in tasks">
                      <a :href="task.url">
                      <p :class="task.label">@{{task.card_name}}</br>
                        <small class="text-muted">November 16, 2017</small></br>
                        <span :class="task.status">@{{task.listname}}</span>
                        </p>
                        </a>
                    </li>
                  </ul>
              
            </div>
        </div>
           
        <div class="col-md-6">
            <div class="card" id="task-overflows">
              <div class="card-header bg-danger text-white">PENDING TASKS</div>
                <div class="card-body bg-danger text-white text-center">
                  <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> @{{pcount}}</h3>
                  <p class="card-text">items</p>
                </div>
                 <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-cloak v-for="pending in pendings">
                      <p :class="pending.label" >@{{pending.card_name}}</br>
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
                      tasks:[],
                      pendings:[]
                      }
                
              },

              mounted: function(){
                  this.getalltasks()
              }, methods:{
                  getalltasks: function(){
                    var vm = this;

                   /* $.get('/registerlist', function(json){
                      console.log('testgiididididis');
                      console.log(json)
                      vm.unregboards = json['regBoards'];
                      console.log(unregboards);
                      
                    });*/
                     console.log('revisions');
                    vm.$http.get('/revisions').then(function(response){
                      console.log('revisions');
                    //console.log(response.data.unRegBoards[0]);
                    //console.log(response);
                      var labeledrevision = response.data.labeled;
                      var unrevision = response.data.unlabeled;
                      var forreviewlabel = respone.data.forreview_label;
                      var forreviewunlabel = respone.data.forreview_unlabel;
                      
                      console.log(labeledrevision);

                      labeledrevision.forEach(function(value, id){
                        
                       
                      vm.pendings.push({"label": "card-text notice notice-"+value.label.toLowerCase(), "card_name": value.cardname, "url": value.url, "status": "badge badge-revision", "statusname": "With Revisions"})
               
                    })


                      unrevision.forEach(function(value, id){
                        
                       
                      vm.pendings.push({"label": "card-text notice notice-null", "card_name": value.cardname, "url": value.url, "status": "badge badge-revision", "statusname": "With Revisions"})
               
                    })


                      forreviewlabel.forEach(function(value, id){
                        
                       
                      vm.pendings.push({"label": "card-text notice notice-"+value.label.toLowerCase(), "card_name": value.cardname, "url": value.url, "status": "badge badge-revision", "statusname":"Waiting for Response"})
               
                    })

                      forreviewunlabel.forEach(function(value, id){
                        
                       
                      vm.pendings.push({"label": "card-text notice notice-null", "card_name": value.cardname, "url": value.url, "status": "badge badge-revision", "statusname":"Waiting for Response"})
               
                    })

                      vm.pcount = vm.pendings.length;
                      console.log(vm.pcount);
                      

                    }).catch(function(error){

                    });
                    
                    vm.$http.get('/mytasks').then(function(response){
                      console.log('test');
                    //console.log(response.data.unRegBoards[0]);
                    //console.log(response);
                      var alltask = response.data.task;
                      var unlabeled = response.data.unlabeled;
                      
                      console.log(alltask);

                      alltask.forEach(function(value, id){
                        console.log(value.listname);
                        var status = value.listname;
                      vm.tasks.push({"label": "card-text notice notice-"+value.label.toLowerCase(), "card_name": value.card_name, "url": value.url, "listname": value.listname, "status": "badge badge-"+status.replace(/\s+/g, '').toLowerCase()})
               
                    })
                      unlabeled.forEach(function(value, id){
                        var status = value.listname;
                      vm.tasks.push({"label": "card-text notice notice-null", "card_name": value.card_name, "url": value.url, "listname": value.listname, "status": "badge badge-"+status.replace(/\s+/g, '').toLowerCase()})
               
                    })

                      vm.count = vm.tasks.length;
                      console.log(vm.count);
                      

                    }).catch(function(error){

                    });

                    
                  }


              } 

          });

         
        </script>



        
@endsection
