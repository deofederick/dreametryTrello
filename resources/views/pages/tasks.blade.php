@extends('layouts.app')

@section('content')
@include('inc.sidebar')
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="task-overflows">
              <div id="app">
              <div class="card-header bg-info text-white">YOUR TASKS</div>
              <div class="card-body bg-info text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> @{{count}}</h3>
                <p class="card-text">items</p>
              </div>
              
              <ul class="list-group list-group-flush">
                <li class="list-group-item" v-cloak v-for="task in tasks">
                    <p :class="task.label" :href="task.url">@{{task.card_name}}</br>
                    <small class="text-muted">November 16, 2017</small></br>
                    <span class="badge badge-primary">@{{task.listname}}</span>
                </li>
              </ul>
            </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" id="task-overflows">
              <div class="card-header bg-danger text-white">PENDING TASKS</div>
              <div class="card-body bg-danger text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-tasks"></i> 4</h3>
                <p class="card-text">items</p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <p class="notice notice-l1 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
            
                <li class="list-group-item">
                    <p class="notice notice-l2 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l3 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l4 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
                <li class="list-group-item">
                    <p class="notice notice-l5 card-text">Lorem ipsum dolor sit amet</br>
                    <small class="text-muted">November 16, 2017</small>
                </li>
              </ul>

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
                      tasks:[],
                      alltask:[]
                      }
                
              },

              mounted: function(){
                  this.fetchUnreg()
              }, methods:{
                  fetchUnreg: function(){
                    var vm = this;

                   /* $.get('/registerlist', function(json){
                      console.log('testgiididididis');
                      console.log(json)
                      vm.unregboards = json['regBoards'];
                      console.log(unregboards);
                      
                    });*/
                    
                    vm.$http.get('/mytasks').then(function(response){
                      console.log('test');
                    //console.log(response.data.unRegBoards[0]);
                    //console.log(response);
                      var alltask = response.data.task;
                      
                      console.log(alltask);

                      alltask.forEach(function(value, id){
                        console.log(value.listname);

                      vm.tasks.push({"label": "card-text notice notice-"+value.label.toLowerCase(), "card_name": value.card_name, "url": value.url})
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
